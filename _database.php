<?php

date_default_timezone_set('America/Los_Angeles');

// Sheet numbers
define('EVENTS
define('CASTS
define('PERFORMANCES
define('LOCATIONS
define('CAMPS






// ** = Markdown format:  http://daringfireball.net/projects/markdown/syntax
// [FILE] = Name of file we will put into special shared dropbox for easy publishing to server


// ID										// Used to key other tables into this master table
// Title									// Title for display
// Suffix									// suffix like "jr", probably in smaller font or something
// InfoIfNoLogo								// Small blurb to show if no logo, also shown below title main card/signup card
// DescriptionBefore						// General blurb used for recruiting show, on the recruitment page. Several paragraphs is fine. **
// LogoFilename								// An image with the name of the show in it; we won't display show title!  FILE
// PhotoFilename							// Photo of performance or publicity photo like Les Mis, shown WITH title. Supercedes above when available.
// PhotoCredits								// Human-readable list of people who took the photos we feature in column above
// Type										// 'Audition Show', 'Class Show', or 'Event to Archive' or 'Event Announce-Only'  It had better be one of these?
// SignupDetails							// Where classes are, audition preparations, what to expect, etc. **
// WhoCanGo									// Tiny description to show on card. Just a few words -- make sure it fits on various window sizes!
// SignupAttachment							// name of file in attachments directory, should be downloadable from signup details page.
// PerformanceInfo							// Details on when and where performances are.  **

// HowTheShowWent							// After the show, some text to describe how it went. For people reading details about show from archives **
// CastList									// Fill this in to show who got cast.  Goes away after rehearsal start date **

// SharedOrSeparateCasts					// 'Shared' (multiple casts rehearse together) or 'Separate' (casts rehearse separately, e.g. schools)
// Tuition									// human-readable dollars
// TicketURL								// URL to buy tickets (otherwise free show?)
// PhotoURL1								// URL of a photo album for a show, after the run is over
// PhotoURL2								// URL of a second photo album for a show, after the run is over
// PublicityAttachment						// downloadable PDF that parents can print out for a show that is ready for ticketing
// AuditionLocation							// WHERE auditions will be held
// AuditionPrepare							// WHAT to prepare for auditions **

// ClassDays								// Days of the week the rehearsals/camp/classes are, or maybe specific dates
// StartTime								// time, in human-readable format, that auditions/camp/classes start
// EndTime									// time, in human-readable format, that auditions/camp/classes end

// GoogleCalendar							// URL of google calendar … for linking or embedding

											// When... (In order they should be happening)
//
// AnnounceDate								// We first want event to appear to the public. Before, hidden. On/After, visible in "later this year"
// SignupStartDate							// Announce and make signup possible (Or announce rehearsals). Before, "later this year". After, "coming soon"
// AuditionDateTime1						// (If audition) date AND time of audition. Before, announce this (and second) dates. After, only second date
// AuditionDateTime2						// (If a second audition) ""   -- After, "rehearsals starting soon" [Assume cast notified by email]
// CallbackDateTime							// When callbacks are scheduled, just to help cast families schedule if they get called back [Assume cast notified by email]

// SignupEndDate							// Deadline for signups. (Before, "sign up soon" countdown. Afterward, "rehearsals starting soon")
// RehearsalStartDate						// Rehearsals underway. After, "rehearsals in progress", no action for this show.
// TicketSaleDate							// Tickets now available.  If no tickets for sale, shows a countdown timer to first performance; click for cast details.
// ShowFirstDate							// First performance (of any cast). Keep linking to ticket URL if available, otherwise show details.
// 											// Use approximate date (1st of month) when it's in the distant future and date hasn't been nailed down yet
// ShowLastDate								// Last performance [if applicable] Before this, show countdown to last performance. After this, show moves to past events & archives!


/*


Additional fields we might want to add

Should we post the cast list
Is there a performance

Date that cast list is expected to be posted
Date that cast list is re-scheduled to be posted


Rename ticket sale date to publicize date


GET RID OF shared/separate

GET RID OF google calendar

Season or general timeframe description for upcoming shows & event - NOT a date, but just text.


 */



// Returns array of event associative arrays

function getEventAssocArrays($fetchNow = FALSE)
{
	$result = array();

	$db = new SQLite3('tyr.sqlite3') or die('Unable to open database');

	$query = 'select * from events';

   	$ret = $db->query($query);
   	if(!$ret) {
   		echo $db->lastErrorMsg();
   		die;
   	}
   	while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
   		$result[] = $row;
	}
	$db->close();
	return $result;
}

?>
