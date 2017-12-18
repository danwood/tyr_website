<?php

error_reporting(E_ALL);
date_default_timezone_set('America/Los_Angeles');

class MyDB extends SQLite3
{
    function __construct()
    {
		$dbPath = $_SERVER['DOCUMENT_ROOT'] . '/db/tyr.sqlite3';

        $this->open($dbPath, SQLITE3_OPEN_READWRITE);
    }

    function backup()
    {
		$dbPath = $_SERVER['DOCUMENT_ROOT'] . '/db/tyr.sqlite3';
		$copyPath = $_SERVER['DOCUMENT_ROOT'] . '/db/backup.' . date('Y-m-d.G;i;s') . '.sqlite3';
		copy($dbPath, $copyPath);
		error_log("copy $dbPath to $copyPath");
    }
}


// The Main EVENT

class Event
{
    function __construct($rowAssoc)
    {
    	global $now;
    	global $urlBase;
    	global $staging;

	    foreach($rowAssoc as $key => $value) {

//	        if ($staging) error_log("$key : $value");

	    	if (FALSE !== strpos($key, 'Date')) {
	    		if (empty($value)) {
	    			$value = 0;
//	    			if ($staging) error_log(@"Empty $key");
	    		}
	    		else {
	    			$value = strtotime($value);
	    		}
//	        if ($staging) error_log("$key CHANGED TO : $value");
	    	}
	        $this->{$key} = $value;
	    }

// Dates, datetimes need to be loaded from strtotime()
//
//

// Guarantee that the first and last dates will be set.  They might be equivalent though.

 		if (!$this->showLastDate) $this->showLastDate = $this->showFirstDate;	// For one-day performances, now we don't have to specify date twice
 		if (!$this->showFirstDate) $this->showFirstDate = $this->showLastDate;	// Be forgiving the other way around too.

 		if (!$this->auditionDateTime2) $this->auditionDateTime2 = $this->auditionDateTime1;	// For one-day auditions, now we don't have to specify date twice
 		if (!$this->auditionDateTime1) $this->auditionDateTime1 = $this->auditionDateTime2;	// Be forgiving the other way around too.

		// Other initialization

		$dateStates = array(
			'announceDate',		// Careful, this correponds to 1 enum
			'signupStartDate',
			'auditionDateTime1',
			'auditionDateTime2',
			'callbackDateTime',
			'signupEndDate',
			'rehearsalStartDate',
			'ticketSaleDate',
			'showFirstDate',
			'showLastDate');

		$dateStatesForDebugging = $dateStates;
		array_unshift($dateStatesForDebugging, 'STATE_UNANNOUNCED');
		$dateStatesForDebugging[STATE_PAST_ARCHIVE] = 'STATE_PAST_ARCHIVE';
		$dateStatesForDebugging[STATE_PAST_HIDE] = 'STATE_PAST_HIDE';

		$bestStateMatch = STATE_UNANNOUNCED;
		// $bestDateMatch = 0x7FFFFFFF;		// hang onto the date we matched, just in case later event is actually before it's supposed to
		foreach ($dateStates as $key)
		{
			$thisDate = $this->{$key};
			if ($thisDate)
			{
				error_log($key . ' = ' . date('c', $thisDate));
				if ($now >= $thisDate)
							// Assume date has time embedded if we want to not switch until time in that day?
				{
					$bestStateMatch = array_search($key, $dateStates, TRUE) + 1; // add one to adjust for 1-based array
				}
			}
		}

		if ($bestStateMatch == showLastDate) $bestStateMatch = STATE_PAST_ARCHIVE;

		if ($staging) error_log('####### ' . $this->title . ' ' . $this->id . " best state: " . $bestStateMatch . ' ' . $dateStatesForDebugging[$bestStateMatch]);

		$this->state = $bestStateMatch;
		// Fudge state if we shouldn't archive.
		$canArchive = (!$this->isAnnounceOnlyType() && (!$this->isBackstageCampType() || !empty($this->photoFilename)) );		// FIXME: CONVOLUTED LOGIC!
		if ($this->isPastArchiveState() && !$canArchive)
		{
			$this->state = STATE_PAST_HIDE;
		}

		// Set up URL based on state: past (archive), announced yet, regular upcoming.
		if ($this->isPastArchiveState())
		{
			$this->path = 'archive/' . $this->nameCode();
			if (isset($_GET['when']))
			{
				$this->path .= '?when=' . $_GET['when'];
			}
		}
		else if ($this->isComingSoonStates())
		{
			$this->path = '';	// No special link; just home page.  We shouldn't actually link to it.
		}
		else
		{
			$this->path = 'upcoming/?id=' . $this->id;
			if (isset($_GET['when']))
			{
				$this->path .= '&when=' . $_GET['when'];
			}
		}

		if ($staging) error_log($this->id . '  ' . $this->title . '     state: ' . $this->state . '   path: ' . $this->path);
   }

    private $state;
	private $nameCode;	// special key we assign to look up an event by its year and name.  Precalculate for speed.
	private $path;		// URL *path* for sharing and linking to the event


    // Accessors of the properties
    //
    // TODO: FIGURE OUT HOW TO MAKE NEW ACCESSORS OR BRING MORE CODE INTO BEING METHODS, SO MORE PUBLIC METHODS CAN BE PRIVATE

	public $id;						// Used to key other tables into this master table
	public $title;					// Title for display
	public $prefix;				//
	public $suffix;				// suffix like "jr", probably in smaller font or something
	public $storyOverview;
	public $venue;
	public $venueAddress;
	public $credits;
	public $rehearsalInfo;
	public $directorQuote;

	public $infoIfNoLogo;			// Small blurb to show if no logo, also shown below title main card/signup card
	public $descriptionBefore;		// General blurb used for recruiting show, on the recruitment page. Several paragraphs is fine. **
	public $logoFilename;			// An image with the name of the show in it; we won't display show title!  FILE
	public $photoFilename;			// Photo of performance or publicity photo like Les Mis, shown WITH title. Supercedes above when available.
	public $photoCredits;			// Human-readable list of people who took the photos we feature in column above
	public $type;					// 'Audition Show', 'Class Show', 'Combo Show', or 'Event to Archive' or 'Event Announce-Only'  It had better be one of these?
	public $signupDetails;			// Where classes are, audition preparations, what to expect, etc. **
	public $whoCanGo;				// Tiny description to show on card. Just a few words -- make sure it fits on various window sizes!
	public $signupAttachment;		// name of file in attachments directory, should be downloadable from signup details page.
	public $performanceInfo;		// Details on when and where performances are.  **

	public $howTheShowWent;		// After the show, some text to describe how it went. For people reading details about show from archives **
	public $castList;				// Fill this in to show who got cast.  Goes away after rehearsal start date **

	public $tuition;				// human-readable dollars
	public $ticketURL;				// URL to buy tickets (otherwise free show?)
	public $photoURLs;				// URLs of photo albums for a show, after the run is over
	public $videoURLs;				//
	public $publicityAttachment;	// downloadable PDF that parents can print out for a show that is ready for ticketing
	public $auditionLocation;		// WHERE auditions will be held
	public $auditionPrepare;		// WHAT to prepare for auditions **

	public $classDays;				// Days of the week the rehearsals/camp/classes are, or maybe specific dates
	public $startTime;				// time, in human-readable format, that auditions/camp/classes start
	public $endTime;				// time, in human-readable format, that auditions/camp/classes end

	public $googleCalendarURL;		// URL of google calendar … for linking or embedding

	public $announceDate;			// We first want event to appear to the public. Before, hidden. On/After, visible in "later this year"
	public $signupStartDate;		// Announce and make signup possible (Or announce rehearsals). Before, "later this year". After, "coming soon"
	public $auditionDateTime1;		// (If audition) date AND time of audition. Before, announce this (and second) dates. After, only second date
	public $auditionDateTime2;		// (If a second audition) ""   -- After, "rehearsals starting soon" [Assume cast notified by email]
	public $callbackDateTime;		// When callbacks are scheduled, just to help cast families schedule if they get called back [Assume cast notified by email]

	public $signupEndDate;			// Deadline for signups. (Before, "sign up soon" countdown. Afterward, "rehearsals starting soon")
	public $rehearsalStartDate;	// Rehearsals underway. After, "rehearsals in progress", no action for this show.
	public $ticketSaleDate;		// Tickets now available.  If no tickets for sale, shows a countdown timer to first performance; click for cast details.

	public $showFirstDate;			// First performance (of any cast). Keep linking to ticket URL if available, otherwise show details.
									// Use approximate date (1st of month) when it's in the distant future and date hasn't been nailed down yet
	public $showLastDate;			// Last performance [if applicable] Before this, show countdown to last performance. After this, show moves to past events & archives!

	public $sliderPromoFilename;
	public $sliderArchiveFilename;

	public $parentEventID;				// If there is a grouping like 'A mysterious mainstage' this is foreign key to that ID
	public $similarEventID;				// If there is an older TYR show of this same title, this will pull photos from it for recruiting
	public $similarImageFilename;		// For recruiting, bring in a photo of some other production. Filename if we upload something
	public $similarImageSourceURL;		// For recruiting, bring in a photo of some other production. URL of source page/company
	public $similarImageAttribution;	// For recruiting, bring in a photo of some other production. Permission statement.
	public $season;						// Quarter = 1 winter, 2 spring, 3 summer, 4 fall, for not-ready-to-sign-up upcoming events.

  // Static methods

	public static function eventAnnounceCompare($aEvent, $bEvent)
	{
		// We want to sort by the date they were announced....
		$a = $aEvent ? $aEvent->showAnnounceDate : 0;
		$b = $bEvent ? $bEvent->showAnnounceDate : 0;

		// However this doesn't make sense for historical shows; also if two items were announced the same date,
		// we really want to compare by their performance date!  Hopefully that works.
		// (We prefer announce dates so something recently added as an event gets announced at the top of the feed)

		if ($a < 1357794000) $aEvent->showFirstDate;
		if ($b < 1357794000) $bEvent->showFirstDate;

	    if ($a == $b) {
	        return 0;
	    }
	    return ($a < $b) ? 1 : -1;
	}

	public static function eventForwardCompare($aEvent, $bEvent)
	{
		$a = $aEvent ? $aEvent->showFirstDate : 0;
		$b = $bEvent ? $bEvent->showFirstDate : 0;
	    if ($a == $b) {
	        return 0;
	    }
	    return ($a < $b) ? -1 : 1;
	}
	public static function eventReverseCompare($aEvent, $bEvent)
	{
		$a = $aEvent ? $aEvent->showFirstDate : 0;
		$b = $bEvent ? $bEvent->showFirstDate : 0;
	    if ($a == $b) {
	        return 0;
	    }
	    return ($a < $b) ? 1 : -1;
	}

	public static function getEventByID($eventID)
	{
		global $events;
		foreach ($events as $event)
		{
			if (0 + $event->id == 0 + $eventID)
			{
				return $event;
			}
		}
		return NULL;
	}

	public static function getEventByNameCode($nameCode)		// spaces as dash, all lowercase, no punctuation, no diacriticals
	{
		global $events;
		foreach ($events as $event)
		{
			$itsNameCode = $event->nameCode();
			if ($itsNameCode == $nameCode) return $event;
		}
		return NULL;
	}

	public static function getSpecifiedEvent($mustBeArchive)	// BOOL; if not true, then must be upcoming.
	{
		$event = NULL;
		if (isset($_GET['name']) && !empty($_GET['name']))
		{
			$nameCode = $_GET['name'];
			$event = Event::getEventByNameCode($nameCode);
		}
		if (isset($_GET['id']) && !empty($_GET['id']))
		{
			$event = Event::getEventByID(0 + $_GET['id']);
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && !empty($_POST['id']))
		{
			$event = Event::getEventByID(0 + $_POST['id']);
		}
		if ( $event && $mustBeArchive && !$event->isPastArchiveState() )
		{
			//error_log("Nullifying non-past event");
			$event = NULL;
		}
		// error_log("event ended up being " . print_r($event, 1));
		// if ($event && !$mustBeArchive && !$event->isUpcomingStates() )
		// {
		// 	error_log("Nullifying non-past mustNotBeArchive event");
		// 	$event = NULL;
		// }
		return $event;
	}

	// State functions

	public function isComingSoonStates()
	{
		// AFTER the announce date but BEFORE the state where we are ready so sign up... FUDGE SO THAT WE MOVE IT UP A WEEK BEFORE DATE.  REALLY NEEDS A SEPARATE STATE.
		global $now;
		$result = $this->state >= announceDate
				&& $this->state < signupStartDate
				&& ($now < $this->signupStartDate - (86400 * 7) ) ;
		// error_log($this->title . ' coming soon? ' . $result);
		return $result;
	}

	public function isUpcomingStates()			{ return $this->state >= announceDate && $this->state < showLastDate; }

	public function isPastArchiveState()		{ return $this->state == STATE_PAST_ARCHIVE; }
	public function isPastStates() 				{ return $this->state == STATE_PAST_ARCHIVE || $this->state == STATE_PAST_HIDE; }

	public function isSignupStates()			{ return $this->state >= signupStartDate && $this->state < signupEndDate; }
	public function isBeforeRehearsalStates()	{ return $this->state >= signupStartDate && $this->state < rehearsalStartDate; }
	public function isAfterSignupStates()		{ return ($this->signupEndDate ? $this->state >= signupEndDate : $this->state >= rehearsalStartDate); } // FIXME: LAST COMPARISON OK?

	public function isTicketingStates()			{ return ($this->ticketSaleDate > 0) && ($this->state >= ticketSaleDate && $this->state < showLastDate); }

	public function isShowOpenTypes()			{ return $this->state >= showFirstDate && $this->state < showLastDate; }
	public function isBeforeSignupTypes()		{ return $this->state < signupStartDate; }

	// Type functions

	public function isArchiveType()				{ return $this->type == TYPE_EVENT_ARCHIVE; }
	public function isAnnounceOnlyType()		{ return $this->type == TYPE_EVENT_ANNOUNCE_ONLY; }
	public function isSpecialEventTypes()		{ return $this->type == TYPE_EVENT_ARCHIVE || $this->type == TYPE_EVENT_ANNOUNCE_ONLY; }
	public function isShowTypes()				{ return $this->type == TYPE_AUDITION_SHOW || $this->type == TYPE_CLASS_SHOW || $this->type == TYPE_COMBO_SHOW; }
	public function isAuditionShowTypes()		{ return $this->type == TYPE_AUDITION_SHOW || $this->type == TYPE_COMBO_SHOW; }
	public function isBackstageCampType()		{ return $this->type == TYPE_BACKSTAGE_CAMP; }		// Gets put in a separate list from regular shows

	public function shouldShowLogo()			{ return $this->isUpcomingStates() 	&& !empty($this->logoFilename) && !$this->isBackstageCampType(); }
	public function shouldShowLogoPNG()			{ return $this->shouldShowLogo() && pathinfo($this->logoFilename, PATHINFO_EXTENSION) == 'png'; }
	public function shouldShowPhoto()			{ return $this->isPastArchiveState()		&& !empty($this->photoFilename); }
	public function photoFilename()				{ return $this->photoFilename; }

	public function getYear() { $dateComponents = getdate($this->showFirstDate); return $dateComponents["year"]; }

	public function link() { global $urlBase; return $urlBase . $this->path; }

	public function linkOrTicketURL() { return ($this->isTicketingStates() && $this->ticketURL) ? $this->ticketURL : $this->link();  }

	public function matchesFromPhotoFilename()
	{
		$result = NULL;

		$photoFilename = $this->photoFilename;
		$basename = basename($photoFilename);
		$matches = array();

		if (preg_match('/^(.+?)([0-9]+)\.([A-Za-z]+)/', $basename, $matches))
		{
			$result = $matches;		// let caller go from there
		}
		return $result;
	}

    // Other stuff

	public function nameCode()		// Calculate.
	{
		$eventYear = date('Y', $this->showFirstDate);
		$title = $this->title;

		//$title = bin2hex($title) . ' -> ' . bin2hex(utf8_decode($title));
		//return $title;
		$title = utf8_decode($title);

		$title = strtr($title,utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
		$title = strtolower($title);
		$title = preg_replace('/[^a-z0-9]+/', '-', $title);

		if (FALSE === strpos($title, $eventYear))	// Add year but only if not included in title already
		{
			$title = $eventYear . '-' . $title;
		}
		return $title;
	}

	public function outputSocialSharing($numberOfImagesForPinterest, $isAbsoluteURL = FALSE)
	{
		global $urlBase;
		global $root;

		$sourceRoot = $isAbsoluteURL ? $urlBase : $root;

		$isUpcoming = $this->isUpcomingStates();
		$upcomingOrRecent = $isUpcoming ? 'Upcoming' : 'Recent';
		$upcomingOrArchive = $isUpcoming ? 'upcoming' : 'archive';

		$headline = $upcomingOrRecent . ' ' . ($this->isSpecialEventTypes() ? 'event' : 'show');

		// <!-- Should be pre-populated with name of show, but the URL to share should be the signup page. -->

		$mailtoURL = 'mailto:?subject=' . encodeAmpersand($headline . ': ' . $this->title)
			. '&amp;body=' . encodeAmpersand($this->title . ' ... Check it out at ') . urlencode($this->link());
		echo '<div class="social">' . PHP_EOL;
		echo '<a href="' . $mailtoURL . '">';
		echo '<img title="Compose an email to share the URL for ' . htmlspecialchars($this->title) . '" src="' . $sourceRoot . 'img/email.png" width="26" height="26" alt="email" /></a>' . PHP_EOL;

		echo '<a href="https://twitter.com/intent/tweet?text=' . urlencode($headline . ' from Tomorrow Youth Rep: ' . $this->title)
			. '&amp;url=' . urlencode($this->link())
			. '">';
		echo  '<img title="Compose an tweet to share the URL for ' . htmlspecialchars($this->title) . '" src="' . $sourceRoot . 'img/Twitter.png" width="26" height="26" alt="Twitter" /></a>' . PHP_EOL;

		echo '<a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=' . urlencode($this->link())
			. '">';
		echo  '<img title="Compose a Facebook post to share the URL for ' . htmlspecialchars($this->title) . '" src="' . $sourceRoot . 'img/Facebook.png" width="26" height="26" alt="Facebook" /></a>' . PHP_EOL;

		if ($numberOfImagesForPinterest)
		{
			echo '<span style="padding-left:8px; position:relative; top:7px; ">';
			if ($numberOfImagesForPinterest > 1)
			{
				// "Any Image" picker, from http://business.pinterest.com/widget-builder/
				echo '<a target="_blank" data-pin-do="buttonBookmark" href="http://www.pinterest.com/pin/create/button/">';
			}
			else
			{
				// Single image, specify image directly in URL. (Javascript needed?)

				$mediaURL = '';		// Hey, it BETTER be here!
				if ($this->shouldShowPhoto())
				{
					$mediaURL = $urlBase . 'shows/photo/' . $this->getYear() . '/' . $this->photoFilename;
				}
				else if ($this->shouldShowLogo())
				{
					$mediaURL = $urlBase . 'shows/logo/' . $this->getYear() . '/' . $this->logoFilename;
				}
				echo '<a target="_blank" href="http://www.pinterest.com/pin/create/button/?url=' . urlencode($this->link())
				. '&amp;media=' . urlencode($mediaURL)
				. '&amp;description=' . urlencode($this->title . ' from Tomorrow Youth Rep')
				. '" data-pin-do="buttonPin" data-pin-config="none">';
			}
			echo  '&nbsp;</a></span>' . PHP_EOL;	// Image inserted for us
		}
		echo '</div>' . PHP_EOL;
	}

	public function outputActionButton()					// FIXME: Some less convoluted way of determining what to show?
	{
		$href = $this->path;
		$text = 'More Info';

		if ($this->isTicketingStates())
		{
			if ($this->ticketURL)
			{
				$href = $this->ticketURL;
				$text = 'Buy Tickets';
			}
			else
			{
				if ($this->isSpecialEventTypes())
				{
					$text = 'Event Info';
				}
				else
				{
					$text = 'Show Info';
				}
			}
		}
		else if ($this->isSignupStates())
		{
			if (!$this->isAuditionShowTypes())
			{
				$text = 'Sign Up';
			}
		}

		echo '<div class="card-action"><a class="button" href="';
		echo $href;
		echo '">';
		echo $text;
		echo '</a></div>' . PHP_EOL;
	}

	public function getCardLowerLeftText()
	{
		$caption = '';
		if (!$this->isPastArchiveState())
		{
			$caption = $this->whoCanGo;
		}
		return $caption;
	}

	public function getCardLowerRightText()
	{
		global $staging;

		$date = '';
		if ($this->isPastArchiveState())
		{
			$date = smartDate('M Y', $this->showFirstDate);			// Date of performance, just month/year
		}
		else if ($this->isComingSoonStates())	// Show season, not actual date.
		{
			$dateInfo = getdate($this->showFirstDate);
			$seasonNumber = $this->season;
			$seasons = array('Winter', 'Spring', 'Summer', 'Fall');		// All you have to do is call!
			$season = $seasons[$seasonNumber];
			$year = (integer) date('Y', $this->showFirstDate);
			if (1 == $seasonNumber)	// Winter
			{
				$yearBefore = $year - 1;
				$date = $season . ' ' . $yearBefore . '-' . ($year % 100);	// e.g. for 1/1/2016 we say Winter 2015-16
			}
			else
			{
				$date =  $season . ' ' . $year;
			}
			// ALTERNATE POSSIBILITY:
			// Show range of months from rehearsal starting to performance
			// $date = smartDateRange($this->rehearsalStartDate, $this->showLastDate);
		}
		else	// Need more specifics of what the date is.
		{
			if ($staging) error_log($this->id . " Not past or later During? "
				. $this->isSignupStates()
				. " After? " . $this->isAfterSignupStates());
			if ($this->isSignupStates())
			{
				if ($staging) error_log($this->id . " during signup");
				if ($this->isAuditionShowTypes())
				{
					if ($staging) error_log("Yes, audition show...");
					if ($this->auditionDateTime1)
					{
						$date = 'Audition ' . smartDateRange($this->auditionDateTime1, $this->auditionDateTime2, ' & ');
					}

				}
				else
				{
					$date = '';	// don't use actual date since the sign up end date is not right for staggeßred registration shows
					// if ($this->signupEndDate)
					// {
					// 	$date = 'Register by ' . smartDate('M j', $this->signupEndDate);
					// }
					// else
					// {
					// 	$date = 'Registration Open';
					// }
				}
			}
			else if ($this->isAfterSignupStates())
			{
				if ($staging) error_log($this->id . " after signup");
				if ($this->isSpecialEventTypes())
				{
					$date = smartDateRange($this->showFirstDate, $this->showLastDate, ' & ');
				}
				else if (!$this->isBackstageCampType())
				{
					if ($this->isShowOpenTypes())
					{
						$date = 'Closing ' . smartDate('M j', $this->showLastDate);
					}
					else if ($this->showLastDate != $this->showFirstDate)
					{
						$date = 'Opening ' . smartDate('M j', $this->showFirstDate);
					}
					else
					{
						$date = 'Performance ' . smartDate('M j', $this->showFirstDate);
					}
				}
			}
			else
			{
				if ($staging) error_log($this->id . " not signing up yet");
				// Not signing up yet
				$date = 'Signups coming soon';

				if ($this->signupStartDate)
				{
					$date = "Signup starting " . smartDate('M j', $this->signupStartDate);
				}
			}
		}
		return $date;
	}

	public function getCardClasses()
	{
		$result = array();
		$result[]  = $this->isSpecialEventTypes() ? 'event-card' : 'show-card';

		if  ($this->shouldShowPhoto())
		{
			$result[] = 'photo-card';	// images are equal sizes so no need for equalizing
		}
		else
		{
			$showLogo 	= $this->shouldShowLogo();
			$showLogoPNG = $this->shouldShowLogoPNG();
			$result[] = $showLogo ? 'logo-card':'text-card';
			$result[] = ((!$this->shouldShowPhoto() && !$showLogo) || $showLogoPNG) ? 'later-gradient' : '';

			$statusString = 'show';
			if ($this->isComingSoonStates()) 	$statusString = 'later';
			else if ($this->isPastArchiveState()) 		$statusString = 'past';
			else if ($this->isBackstageCampType())	$statusString = 'other';

			$result[] = ' equalize-' . $statusString;
		}
		return implode(' ', $result);
	}

	public function outputEventCard($link = TRUE, $includeActionButton = FALSE)	// output HTML for event.
	{
		global $root;
		global $staging;

		$numberOfImagesForPinterest = 0;		// We will set this later if we have a logo or images

		// Determine special string used for keeping cards grouped together the same size

		if ($this->shouldShowLogo())
		{
			$numberOfImagesForPinterest = 1;
		}
		$photoFilename = '';
		if ($this->shouldShowPhoto())
		{
			$numberOfImagesForPinterest = 1;	// we have at least one

			$photoFilename = $this->photoFilename;

			// Look for ending number, e.g. narnia3.jpg.  If so, that means we should 1 through n, so RANDOMLY pick one of them.
			$matches = $this->matchesFromPhotoFilename();
			if ($matches)
			{
				$totalNumberOfPhotos = $matches[2];
				$totalNumberOfPhotos = min($totalNumberOfPhotos, 4);		// For card, don't show anything past first four
				$basename = $matches[1] . rand(1,$totalNumberOfPhotos);
				$photoFilename = $basename . '.' . $matches[3];

				$numberOfImagesForPinterest = $totalNumberOfPhotos;
			}
		}

		$actuallyLink = $link;
		if ($this->isPastArchiveState() && !$this->shouldShowPhoto())
		{
			$actuallyLink = FALSE;		// don't link archive shows that don't have photos yet
		}


	// We should assume that > 3 months away, if we specify a date of 1/1, 4/1, 7/1, or 10/1, it's to be shown as Winter, Spring, Summer, Fall.
	// Otherwise for dates > 3 months away, we'll just say the month, so specify any date of that month (e.g. the 15th)

		if ($actuallyLink)
		{
			echo '<a class="stealth" href="' . $this->path . '">' . PHP_EOL;
		}
		echo '<div class="' . $this->getCardClasses() . '">' . PHP_EOL;

		echo '<div class="card-title'
			. ($this->shouldShowLogo() ? ' logo-hides-title':'')
			. '">' . PHP_EOL;
			if (!empty($this->prefix)) { echo ' <div class="prefix">' . htmlspecialchars($this->prefix) . '</div>'; }
			echo '<span class="title">' . htmlspecialchars($this->title) . '</span>' . PHP_EOL;
			if (!empty($this->suffix)) { echo ' <span class="suffix">' . htmlspecialchars($this->suffix) . '</span>'; }
		echo '</div>' . PHP_EOL;

		if ($this->shouldShowLogo())
		{
			echo '<img src="' . $root . 'shows/logo/' . $this->getYear() . '/' . htmlspecialchars($this->logoFilename) . '" '
				. 'alt = "' . htmlspecialchars($this->title . ' Logo') . '" />' . PHP_EOL;
		}
		else if ($this->shouldShowPhoto())
		{
			echo '<img src="' . $root . 'shows/photo/'  . $this->getYear() . '/' . htmlspecialchars($photoFilename) . '" '
				. 'alt = "' . htmlspecialchars($this->title . ' Photo') . '" />' . PHP_EOL;
		}
		else	// Text card, but might have mini-logo in corner
		{
			if ($this->isBackstageCampType() && $this->logoFilename)
			{
				echo '<img class="miniicon" src="' . $root . 'shows/logo/' . $this->getYear() . '/' . htmlspecialchars($this->logoFilename) . '" '
					. 'alt = "' . htmlspecialchars($this->title . ': ' . htmlspecialchars($this->infoIfNoLogo)) . '" />' . PHP_EOL;
			}
			if ($this->isPastArchiveState() && !$this->shouldShowPhoto())
			{
				echo '<div class="card-text">Archive coming soon!</div>' . PHP_EOL;
			}
			else
			{
				echo '<div class="card-text">' . htmlspecialchars($this->infoIfNoLogo) . '</div>' . PHP_EOL;
			}
		}
		echo '<div class="card-caption">' . htmlspecialchars($this->getCardLowerLeftText()) . '</div>' . PHP_EOL;
		echo '<div class="card-date">' . htmlspecialchars($this->getCardLowerRightText()) . '</div>' . PHP_EOL;

		echo '</div>' . PHP_EOL;

		if ($actuallyLink)
		{
			echo '</a>' . PHP_EOL;
		}
		if ($this->isUpcomingStates())
		{
			if ($includeActionButton)
			{
				$this->outputActionButton();
			}

			$this->outputSocialSharing($numberOfImagesForPinterest);
		}
	}




	public function outputEventCurrentBlurb()
	{
		global $root;
		global $staging;

		echo '<h3>';
		if (!empty($this->prefix)) { echo ' <span class="suffix">' . htmlspecialchars($this->prefix) . '</span> '; }
		echo htmlspecialchars($this->title);
		if (!empty($this->suffix)) { echo ' <span class="suffix">' . htmlspecialchars($this->suffix) . '</span>'; }
	 	echo '</h3>' . PHP_EOL;

		$html = Markdown::defaultTransform($this->descriptionBefore);
		echo $html;



		if (!$this->isAfterSignupStates())
		{
			if (!empty($this->whoCanGo))
			{
				echo '<p><b>Who can Sign Up:</b> ' . htmlspecialchars($this->whoCanGo) . '</p>' . PHP_EOL;
			}

			if ($this->signupDetails)
			{
				$html = Markdown::defaultTransform($this->signupDetails);
				echo $html;
			}

			if (!empty($this->tuition))
			{
				echo '<p><b>Tuition:</b> ' . htmlspecialchars($this->tuition) . '</p>' . PHP_EOL;
			}
			if ($this->isAuditionShowTypes())
			{
				echo '<p><b>Audition:</b> ';
				if ($this->auditionDateTime1)
				{


				if ($this->auditionDateTime1 == $this->auditionDateTime2)
				{
					$date = smartDate('l, F j \a\t g:i A', $this->auditionDateTime1);
				}
				else
				{
					$month1 = smartDate('F', $this->auditionDateTime1);
					$month2 = smartDate('F', $this->auditionDateTime2);
					$time1 = date('g:i A', $this->auditionDateTime1);
					$time2 = date('g:i A', $this->auditionDateTime2);
					if ($time1 == $time2)
					{

						$date = smartDate('l, F j', $this->auditionDateTime1) . ' and ' . smartDate('l, F j', $this->auditionDateTime2) . ' at ' . $time1;
					}
					else
					{
						if ($month1 == $month2)
						{
							$date = $month1 . ' ' . date('j', $this->auditionDateTime1) . ' at ' . $time1
								. ' and ' . $month2 . ' ' . date('j', $this->auditionDateTime2) . ' at ' . $time2;
						}
						else
						{
							$date = smartDate('F j', $this->auditionDateTime1) . ' at ' . $time1
								. ' and ' . smartDate('F j', $this->auditionDateTime2) . ' at ' . $time2;
						}
					}
				}

				}
				else
				{
					$date = '';		// we could say TBA, or maybe it's in the description.
				}



				$location = $this->auditionLocation;
				//if (empty($location)) $location = 'Location TBA';
				if (!empty($date)) { echo $date . ', ' . htmlspecialchars($location); }

				if ($this->callbackDateTime)
				{
					echo ' <span style="font-style:italic">(Callbacks: ' . smartDate('F j \a\t g:i A', $this->callbackDateTime) . ')</span>';
				}
				echo '</p>' . PHP_EOL;
				if ($this->auditionPrepare)
				{
					$html = Markdown::defaultTransform($this->auditionPrepare);
					echo $html;
				}

				if ($this->isBeforeRehearsalStates())
				{
					$castList = trim($this->castList);
					if ($castList)
					{
						echo '<p><b>Cast List:</b></p>';
						echo '<div style="background-color:#DDD; padding:15px; margin-bottom:1em;">';
						$html = Markdown::defaultTransform($castList);
						echo $html;
						echo '</div>';
					}
					else
					{
	//					echo '<p><b>Cast List not yet available. Please check back later.</b></p>';
					}
				}
			}
			else
			{
				if (!$this->isSpecialEventTypes())
				{
					if ($this->signupEndDate)
					{
						$deadlineToShow = date('l, F j', $this->signupEndDate);
					}
					else
					{
						$deadlineToShow = "first rehearsal";
					}
					echo '<p><b>Registration:</b> Registration must be received by ' . $deadlineToShow . '.'
						. '</p>' . PHP_EOL;
				}
			}

			if ($this->classDays || $this->startTime || $this->endTime || $this->rehearsalStartDate)
			{
				echo '<p><b>';
				echo $this->isBackstageCampType() ? 'Camp Days' : 'Rehearsals';
				echo ':</b> ';

				if ($this->rehearsalStartDate)
				{
					if ($this->isBackstageCampType())
					{
						echo date('F j', $this->rehearsalStartDate) . ' - ' . date('F j', $this->showLastDate);
					}
					else
					{
						echo 'Starting ' . date('F j', $this->rehearsalStartDate);
					}

					if ($this->classDays || $this->startTime || $this->endTime)
					{
						echo ', ';
					}
				}

				if ($this->classDays)
				{
					echo htmlspecialchars($this->classDays);
					if ($this->startTime || $this->endTime) echo ', ';
				}
				if ($this->startTime) echo htmlspecialchars($this->startTime);
				if ($this->endTime)   echo ' - ' . htmlspecialchars($this->endTime);
				echo '</p>';
			}

			if ($this->signupAttachment)
			{
				$attachmentsString = trim($this->signupAttachment);
				$attachmentsArray = explode("\n", $attachmentsString);

				foreach ($attachmentsArray as $att)
				{
					$att = trim($att);
					if ($att)
					{
						echo '<p><a href="shows/signup/' . $this->getYear() . '/' . htmlspecialchars(rawurlencode($att)) . '">';

						$attachment = $att;
						$extension = strtolower(pathinfo($attachment, PATHINFO_EXTENSION));
						$iconfilename = 'teambox/' . $extension . '.png';
						if (file_exists($iconfilename))
						{
							echo '<img alt="file icon" width="24" height="24" src="' . $iconfilename . '"> ';
						}
						echo htmlspecialchars($att) . '</a></p>' . PHP_EOL;
					}
				}
			}

		}
		else
		{
			if (!$this->isSpecialEventTypes())	// Not a special event; make it clear that registration is over.
			{
				echo '<p><b>Registration:</b> Registration is over.</p>' . PHP_EOL;
			}
			if ($this->isBeforeRehearsalStates())
			{
				// Redundant?  Hmm....
				//
				$castList = trim($this->castList);
				if ($castList)
				{
					echo '<p><b>Cast List:</b></p>';
					echo '<div style="background-color:#DDD; padding:15px; margin-bottom:1em;">';
					$html = Markdown::defaultTransform($castList);
					echo $html;
					echo '</div>';
				}
			}

			// Special events will probably not have signups, so they will end up here.
			//
			if ($this->isSpecialEventTypes())		// For special events with no signup deadline, BUT with a signup attachment.
			{
				// Just show the attachment, and let the descriptionBefore explain it.
				//
				if ($this->signupAttachment)
				{
					echo '<p><a href="shows/signup/' . $this->getYear() . '/' . htmlspecialchars(rawurlencode($this->signupAttachment)) . '">';

					$extension = strtolower(pathinfo($this->signupAttachment, PATHINFO_EXTENSION));
					$iconfilename = 'teambox/' . $extension . '.png';
					if (file_exists($iconfilename))
					{
						echo '<img alt="file icon" width="24" height="24" src="' . $iconfilename . '"> ';
					}
					echo htmlspecialchars($this->signupAttachment) . '</a></p>' . PHP_EOL;
				}
			}
		}

	// Now show performance dates


		if (!$this->isBackstageCampType())
		{

			$time = date(' g:i A', $this->showFirstDate);
			if ($time == ' 12:00 AM') $time = '';		// don't show date if midnight

			$date = smartDate('F j', $this->showFirstDate) . $time;		// for single-date events, show time if possible

			$datePrompt = 'Date';

			if ($this->showLastDate != $this->showFirstDate)
			{
				// Make sure only showing initial date, not date+time
				$date = smartDateRange($this->showFirstDate, $this->showLastDate, ' – ', TRUE);
				$datePrompt = 'Dates';

			}
			else
			{
				// Now if it's a generic indicator, don't say the actual date.
				$dateInfo = getdate($this->showFirstDate);
				if (   $dateInfo['mon' ] % 3 == 1	// 1, 4, 7, 10a
					&& $dateInfo['mday'] == 1 )
				{
					$seasons = array('Winter', 'Spring', 'Summer', 'Fall');		// All you have to do is call!

					$season = $seasons[($dateInfo['mon']-1)/3];
					$year = (integer) date('Y', $this->showFirstDate);
					if ($season == 'Winter')
					{
						$yearBefore = $year - 1;
						$date = $season . ' ' . $yearBefore . '-' . ($year % 100);	// e.g. for 1/1/2016 we say Winter 2015-2016
					}
					else
					{
						$date = '@' . $season . ' & ' . $year;
					}

				}
			}




			if (!$this->isSpecialEventTypes()) $datePrompt = 'Performance ' . $datePrompt;

			echo '<p><b>' . $datePrompt . ':</b> ' . $date . '</p>' . PHP_EOL;

			if (!empty($this->performanceInfo))
			{
				if (!$this->isSpecialEventTypes()) echo '<p><b>Performances:</b></p>' . PHP_EOL;
				$html = Markdown::defaultTransform($this->performanceInfo);
				echo $html;
			}
			else
			{
				// if (!$this->isSpecialEventTypes()) echo '<p><b>Performances:</b> TBA</p>' . PHP_EOL;
			}
		}

		if ($this->publicityAttachment)
		{
			echo '<p><b><i>Help get the word out!</i></b> Download this file and print it out, or email to your friends!</p>' . PHP_EOL;
			echo '<p><a href="shows/poster/' . $this->getYear() . '/' . htmlspecialchars(rawurlencode($this->publicityAttachment)) . '">';

			$extension = strtolower(pathinfo($this->publicityAttachment, PATHINFO_EXTENSION));
			$iconfilename = 'teambox/' . $extension . '.png';
			if (file_exists($iconfilename))
			{
				echo '<img alt="file icon" width="24" height="24" src="' . $iconfilename . '"> ';
			}
			echo htmlspecialchars($this->publicityAttachment) . '</a></p>' . PHP_EOL;
		}


		if ($this->isTicketingStates())
		{
			if ($this->ticketURL)
			{
				echo '<p><b>Tickets:</b> &nbsp; <a class="button" href="' . $this->ticketURL . '">Buy Tickets</a></p>' . PHP_EOL;
			}
		}

		if ($this->isBeforeSignupTypes())
		{
			echo "<p><b>Registration will open " . date('F j', $this->signupStartDate) . "</b></p>\n";
		}

		if (!$this->isTicketingStates())		// Don't show calendar if we are now selling tickets; too much clutter
		{
			$googleCalendarURL = trim($this->googleCalendarURL);
			if ($googleCalendarURL)
			{
				echo '<p><a href="' . htmlspecialchars($googleCalendarURL) . '">Schedule — Google Calendar</a>';

				$matched = preg_match('/src=(.+)&/', $googleCalendarURL, $matches);
				if ($matched)
				{
					$fragment = $matches[1];
					$iCalURL = 'webcal://www.google.com/calendar/ical/' . $fragment . '/public/basic.ics';

					echo '&nbsp;&nbsp;&nbsp; <a style="color:#ddd" href="' . $iCalURL . '">[iCalendar Subscription Link]</a></p>' . PHP_EOL;

?>
<!-- Responsive iFrame http://themeloom.com/2013/02/tips-embed-google-maps-and-calendars-in-a-responsive-wordpress-theme/ -->
<div class="responsive-iframe-container">
<!-- https://www.google.com/calendar/embed?src=lna97bbhu6s8663hr9gt76i4b8%40group.calendar.google.com&ctz=America/Los_Angeles -->
<!-- iCal: https://www.google.com/calendar/ical/lna97bbhu6s8663hr9gt76i4b8%40group.calendar.google.com/public/basic.ics -->
<iframe
src="https://www.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;height=400&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=<?php
echo $fragment;
?>&amp;color=%236B3304&amp;ctz=America%2FLos_Angeles"
style="border-width:0"
width="620"
height="400"
frameborder="0"
scrolling="no"></iframe>
</div>
<?php
				}
				else
				{
					// Problem, but at least we have the URL, so we've output that.  End paragraph.
					echo "</p>\n";
				}
			}
		}
	}


	public function outputHeadTags()
	{
		global $urlBase;

		// Output card type and other metadata based on presence of photo[s], logo, or none
		$photoFilename = $this->photoFilename;
		if ($photoFilename)
		{
			$photoCount = 1;
			$matches = $this->matchesFromPhotoFilename();
			if ($matches)
			{
				$photoCount = $matches[2];
				if ($photoCount > 1)
				{
					$photoCount = min($photoCount, 4);	// no more than 4 for Twitter
					// handle this now, since we have our components
					echo '<meta name="twitter:card" content="gallery">' . PHP_EOL;
					for ($i = 0 ; $i < $photoCount ; $i++)
					{
						echo '<meta name="twitter:image' . $i . '" content="' . $urlBase . 'shows/photo/'  . $this->getYear() . '/' . $matches[1] . ($i+1) . '.' . $matches[3] . '">' . PHP_EOL;
					}
				}
			}

			if ($photoCount == 1)	// Only 1? OK, do it here as a photo card.
			{
				echo '<meta name="twitter:card" content="photo">' . PHP_EOL;
				echo '<meta name="twitter:image" content="' . $urlBase . 'shows/photo/'  . $this->getYear() . '/' . $photoFilename . '">' . PHP_EOL;
				// <meta name="twitter:image:width" content="610">
				// <meta name="twitter:image:height" content="610">
			}
			// Facebook only one photo, so just take the last (highest number) one, which is $photoFilename
			echo '<meta property="og:image" content="' . $urlBase . 'shows/photo/'  . $this->getYear() . '/' . $photoFilename . '">' . PHP_EOL;
			// <meta property="og:image:type" content="image/png">
			// <meta property="og:image:width" content="1024">
			// <meta property="og:image:height" content="1024">
		}
		else
		{
			echo '<meta name="twitter:card" content="summary">' . PHP_EOL;
			$logo = $this->logoFilename;
			if ($logo)
			{
				echo '<meta name="twitter:image" content="' . $urlBase . 'shows/logo/' . $this->getYear() . '/' . $logo .  '">' . PHP_EOL;
				echo '<meta property="og:image" content="' . $urlBase . 'shows/logo/' . $this->getYear() . '/' . $logo . '">' . PHP_EOL;
			}
		}

		$fullTitle = htmlspecialchars($this->title) . ' from Tomorrrow Youth Rep';
		echo '<meta name="twitter:title" content="' . $fullTitle . '">' . PHP_EOL;
		echo '<meta property="og:title" content="' . $fullTitle . '">' . PHP_EOL;

		$fullDescription = '';
		if ($this->isPastArchiveState())
		{
			// Past events should be gallery card to show off our images.
			$fullDescription = 'See photos from TYR’s ' . htmlspecialchars($this->title);
		}
		else if ($this->isUpcomingStates())
		{
			$fullDescription = htmlspecialchars($this->title) . ': ' . $this->descriptionBefore;
		}
		echo '<meta name="twitter:description" content="' . $fullDescription . '">' . PHP_EOL;
		echo '<meta property="og:description" content="' . $fullDescription . '">' . PHP_EOL;

		// Could also do twitter:site if have a twitter account; twitter:creator if photographer has twitter account.
	}

}
?>