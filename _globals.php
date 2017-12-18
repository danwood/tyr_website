<?php

error_reporting(E_ALL);
date_default_timezone_set('America/Los_Angeles');

/*

Later, try to get the RSS to just call functions here.

Better build in years, into the paths (archive/2014/) and such.  Break down image direcotries by year so directories don't get full.


 */

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
// Type										// 0=unknown, 1='Event Announce-Only', 3='Audition Show', 4='Class Show', or 2='Event to Archive' 5=backstage camp
// SignupDetails							// Where classes are, audition preparations, what to expect, etc. **
// WhoCanGo									// Tiny description to show on card. Just a few words -- make sure it fits on various window sizes!
// SignupAttachment							// name of file in attachments directory, should be downloadable from signup details page.
// PerformanceInfo							// Details on when and where performances are.  **

// HowTheShowWent							// After the show, some text to describe how it went. For people reading details about show from archives **
// CastList									// Fill this in to show who got cast.  Goes away after rehearsal start date **

// SharedCast								// 'Shared' (multiple casts rehearse together) or 'Separate' (casts rehearse separately, e.g. schools)
// Tuition									// human-readable dollars
// TicketURL								// URL to buy tickets (otherwise free show?)
// PhotoURLs								// URL of photo albums for a show, after the run is over.  Can have space then description for hyperlink.
// VideoURLs								// Similar but YouTube style URLs.
// PublicityAttachment						// downloadable PDF that parents can print out for a show that is ready for ticketing
// AuditionLocation							// WHERE auditions will be held
// AuditionPrepare							// WHAT to prepare for auditions **

// ClassDays								// Days of the week the rehearsals/camp/classes are, or maybe specific dates
// StartTime								// time, in human-readable format, that auditions/camp/classes start
// EndTime									// time, in human-readable format, that auditions/camp/classes end

// googleCalendarURL						// URL of google calendar … for linking or embedding

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


Season or general timeframe description for upcoming shows & event - NOT a date, but just text.
 */


define ('TYPE_UNKNOWN', 0);
define ('TYPE_EVENT_ANNOUNCE_ONLY', 1);
define ('TYPE_EVENT_ARCHIVE', 2);
define ('TYPE_AUDITION_SHOW', 3);
define ('TYPE_CLASS_SHOW', 4);
define ('TYPE_BACKSTAGE_CAMP', 5);
define ('TYPE_COMBO_SHOW', 6);		// Audition + Class ensemble show
define ('TYPE_GROUP', 7);		// Grouping for auditions.  Not archived.



define ('NUMBER_OF_PAST_TO_SHOW', 9);
define ('NUMBER_ADDITIONAL_PAST_TITLES', 3);
define ('MAX_NUMBER_TO_SHOW_ON_ARCHIVES', 9);


define('STATE_UNANNOUNCED',					0);			// It's before announcement date
define('STATE_PAST_ARCHIVE',				98);		// Show is in the past; display in archive sections
define('STATE_PAST_HIDE',					99);		// Show is in the past; don't show.

// We need numbers because we are doing range calculations!

define('announceDate',        1);
define('signupStartDate',     2);
define('auditionDateTime1',   3);
define('auditionDateTime2',   4);
define('callbackDateTime',    5);
define('signupEndDate',       6);
define('rehearsalStartDate',  7);
define('ticketSaleDate',      8);
define('showFirstDate',       9);
define('showLastDate',        10);




// GLOBALS:  $now, $root, $staging, $urlBase

$urlBase = 'http://' . $_SERVER['HTTP_HOST'] . '/';

//error_log('=============================================================================================');
//error_log('urlBase = ' . $urlBase);
//error_log('referer = ' . $_SERVER['HTTP_REFERER']);

$staging = ($_SERVER['HTTP_HOST'] == 'staging.tomorrowyouthrep.org');
$staging |= ($_SERVER['HTTP_HOST'] == 'localhost');

$now = time();
if (isset($_GET['when']))
{
	$when = $_GET['when'];
	if ($when) $now = strtotime($when);
}

// Note:  $root is defined on each page.  though maybe it could be calculated by its request URL path?

// Analyze events.  These are going to be sorted in order of performance, meaning oldest first. Though maybe that doesn't matter.

// GLOBAL - Arrays of Event objects.

$events = array();		// Master list of all

$pastEvents = array();
$allPastEvents = array();
$currentShows = array();
$currentOther = array();
$laterEvents = array();
$hiddenEvents = array();
$unannouncedEvents = array();

$sliderRecords = array();	// build this up as we find slider past & promo info

$dbPath = $_SERVER['DOCUMENT_ROOT'] . '/db/tyr.sqlite3';
$db = new SQLite3($dbPath) or die('Unable to open database');

$query = 'select * from events';

$ret = $db->query($query);
if(!$ret) {
	echo $db->lastErrorMsg();
	die;
}
while ($row = $ret->fetchArray(SQLITE3_ASSOC) ){


	$event = new Event($row);		// Copy the event, work with that.

	$events[] = $event;

	if (!$row['announceDate'])
	{
		$hiddenEvents[] = $event;
	}
	else if ($event->isHiddenOrVisiblePastEvent())
	{
		$allPastEvents[] = $event;	// Save all past events even if hidden
		if ($event->isPastEvent())
		{
			$pastEvents[] = $event;	// Usually we use just the archival events though
		}
		else
		{
//			if ($staging) { error_log("Not including hidden past event " . $event->id() . ' ' . $event->title()); }
		}
	}
	else if ($event->isComingSoonEvent())
	{
		$laterEvents[] = $event;
	}
	else if ($event->isUpcomingEvent())
	{
		if ($event->isBackstageCamp())
		{
			$currentOther[] = $event;
		}
		else
		{
			$currentShows[] = $event;
		}
	}
	else	// not announced yet
	{
		$unannouncedEvents[] = $event;
	}

	if (!empty($event->sliderArchiveFilename) && $event->isPastEvent()) {
		$path = 'slider_past/' . $event->getYear() . '/' . $event->sliderArchiveFilename;
		$sliderInfo = array(
			'filename' => $path,
			'year' => $event->getYear(),
			'title' => $event->title(),
			'caption' => $event->title(),
			'link' => $event->link()
			);
		$sliderRecords[] = $sliderInfo;
	}
	if (!empty($event->sliderPromoFilename) && $event ->isUpcomingEvent()) {
		$path = 'slider_promo/' . $event->getYear() . '/' . $event->sliderPromoFilename;
		$sliderInfo = array(
			'filename' => $path,
			'year' => $event->getYear(),
			'title' => $event->title(),
			'link' => $event->linkOrTicketURL()
			);
		// Put promo at the START of the array ... not really important if we are randomizing.
		array_unshift($sliderRecords, $sliderInfo);

		// Put an EXTRA copy of each promo in the list so it will show up twice as often when randomizing
		$sliderRecords[] = $sliderInfo;

	}

	// Some way to sort these, or un-sort them, randomly each time?

}
$db->close();

usort($currentShows,	 array('Event', 'eventForwardCompare'));
usort($currentOther,	 array('Event', 'eventForwardCompare'));
usort($laterEvents,		 array('Event', 'eventForwardCompare'));
usort($unannouncedEvents,array('Event', 'eventForwardCompare'));

usort($pastEvents,		array('Event', 'eventReverseCompare'));		// We want past events showing most-recent first
usort($allPastEvents,	array('Event', 'eventReverseCompare'));		// We want past events showing most-recent first

// if ($staging)
// {
// 	error_log(count($currentShows) . " current shows!");

// 	foreach ($currentShows as $show)		// don't use ampersand here, there was a mysterious issue with the penultimate item in the array duplicated.
// 	{
// 		error_log($show->title() . ' ' . date(DATE_RSS, $show->showFirstDate) . ' ' . date(DATE_RSS, $show->showLastDate));
// 	}

// 	error_log(count($currentOther) . " current others!");
// 	error_log(count($laterEvents) . " later events");
// 	error_log(count($pastEvents) . " past events");
// 	error_log(count($unannouncedEvents) . " unannounced events");

// 	error_log(count($events) . " ALL events");

// }

$event = NULL;		// Clear out; don't need big list.

?>
