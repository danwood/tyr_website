<?php

date_default_timezone_set('America/Los_Angeles');

// https://docs.google.com/spreadsheet/pub?key=0AibPgovp6ncndGd0S3I4MWc2SVR4RE52U3FFLVJsdWc&single=true&gid=0&output=csv
//
//

// Sheet numbers
define('EVENTS', 0);
define('CASTS', 2);
define('PERFORMANCES', 3);
define('LOCATIONS', 4);
define('CAMPS', 5);


function parse_csv ($csv_string, $delimiter = ",", $skip_empty_lines = true, $trim_fields = true)
{
    return array_map(
        function ($line) use ($delimiter, $trim_fields) {
            return array_map(
                function ($field) {
                    return str_replace('!!Q!!', '"', urldecode($field));	// took out utf8_decode wrapping around urldecode
                },
                $trim_fields ? array_map('trim', explode($delimiter, $line)) : explode($delimiter, $line)
            );
        },
        preg_split(
            $skip_empty_lines ? ($trim_fields ? '/( *\R)+/s' : '/\R+/s') : '/\R/s',
            preg_replace_callback(
                '/"(.*?)"/s',
                function ($field) {
                    return urlencode($field[1]);	// took out utf8_encode around field[1]
                },
                $enc = preg_replace('/(?<!")""/', '!!Q!!', $csv_string)
            )
        )
    );
}

function getGoogleTable($tableNumber, $fetchNow = FALSE)
{
	global $root;
	if ($fetchNow)
	{
		error_log("fetching google table $tableNumber RIGHT NOW");
	}
	$result = '';
	$cacheFileName = $root . 'cache/cache.' . $tableNumber . '.csv';
	$result = file_get_contents($cacheFileName);

//	error_log('Contents of file = ' . $result);
	$resultArray = parse_csv($result, ',', FALSE);

//	error_log('Parsed table = ' . print_r($resultArray, 1));
	return $resultArray;
}



// ** = Markdown format:  http://daringfireball.net/projects/markdown/syntax
// [FILE] = Name of file we will put into special shared dropbox for easy publishing to server

// TODO: THESE ARE SILLY TO ALL BE "BEFORE_"
//
//
define('BEFORE_ID', 0);										// Used to key other tables into this master table
define('BEFORE_Title', 1);									// Title for display
define('BEFORE_Suffix', 2);									// suffix like "jr", probably in smaller font or something
define('BEFORE_InfoIfNoLogo', 3);							// Small blurb to show if no logo, also shown below title main card/signup card
define('BEFORE_DescriptionBefore', 4);						// General blurb used for recruiting show, on the recruitment page. Several paragraphs is fine. **
define('BEFORE_LogoFilename', 5);							// An image with the name of the show in it; we won't display show title!  FILE
define('BEFORE_PhotoFilename', 6);							// Photo of performance or publicity photo like Les Mis, shown WITH title. Supercedes above when available.
define('BEFORE_PhotoCredits', 7);							// Human-readable list of people who took the photos we feature in column above
define('BEFORE_Type', 8);									// 'Audition Show', 'Class Show', or 'Event to Archive' or 'Event Announce-Only'  It had better be one of these?
define('BEFORE_SignupDetails', 9);							// Where classes are, audition preparations, what to expect, etc. **
define('BEFORE_WhoCanGo', 10);								// Tiny description to show on card. Just a few words -- make sure it fits on various window sizes!
define('BEFORE_SignupAttachment', 11);						// name of file in attachments directory, should be downloadable from signup details page.
define('BEFORE_PerformanceInfo', 12);						// Details on when and where performances are.  **

define('BEFORE_HowTheShowWent', 13);							// After the show, some text to describe how it went. For people reading details about show from archives **
define('BEFORE_CastList', 14);								// Fill this in to show who got cast.  Goes away after rehearsal start date **

define('BEFORE_SharedOrSeparateCasts', 15);					// 'Shared' (multiple casts rehearse together) or 'Separate' (casts rehearse separately, e.g. schools)
define('BEFORE_Tuition', 16);								// human-readable dollars
define('BEFORE_TicketURL', 17);								// URL to buy tickets (otherwise free show?)
define('BEFORE_PhotoURL1', 18);								// URL of a photo album for a show, after the run is over
define('BEFORE_PhotoURL2', 19);								// URL of a second photo album for a show, after the run is over
define('BEFORE_PublicityAttachment', 20);					// downloadable PDF that parents can print out for a show that is ready for ticketing
define('BEFORE_AuditionLocation', 21);						// WHERE auditions will be held
define('BEFORE_AuditionPrepare', 22);						// WHAT to prepare for auditions **

define('BEFORE_ClassDays', 23);								// Days of the week the rehearsals/camp/classes are, or maybe specific dates
define('BEFORE_StartTime', 24);								// time, in human-readable format, that auditions/camp/classes start
define('BEFORE_EndTime', 25);								// time, in human-readable format, that auditions/camp/classes end

define('BEFORE_GoogleCalendar', 26);							// URL of google calendar … for linking or embedding

// EXPANSION

// When... (In order they should be happening)
define('BEFORE_AnnounceDate', 31);							// We first want event to appear to the public. Before, hidden. On/After, visible in "later this year"
define('BEFORE_SignupStartDate', 32);						// Announce and make signup possible (Or announce rehearsals). Before, "later this year". After, "coming soon"
define('BEFORE_AuditionDateTime1', 33);						// (If audition) date AND time of audition. Before, announce this (and second) dates. After, only second date
define('BEFORE_AuditionDateTime2', 34);						// (If a second audition) ""   -- After, "rehearsals starting soon" [Assume cast notified by email]
define('BEFORE_CallbackDateTime', 35);						// When callbacks are scheduled, just to help cast families schedule if they get called back [Assume cast notified by email]

define('BEFORE_SignupEndDate', 36);							// Deadline for signups. (Before, "sign up soon" countdown. Afterward, "rehearsals starting soon")
define('BEFORE_RehearsalStartDate', 37);						// Rehearsals underway. After, "rehearsals in progress", no action for this show.
define('BEFORE_TicketSaleDate', 38);							// Tickets now available.  If no tickets for sale, shows a countdown timer to first performance; click for cast details.
define('BEFORE_ShowFirstDate', 39);							// First performance (of any cast). Keep linking to ticket URL if available, otherwise show details.
															// Use approximate date (1st of month) when it's in the distant future and date hasn't been nailed down yet
define('BEFORE_ShowLastDate', 40);							// Last performance [if applicable] Before this, show countdown to last performance. After this, show moves to past events & archives!


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
	$result = getGoogleTable(EVENTS, $fetchNow);

	$headers = $result[0];

	$expectedHeaders = array('ID','Title','Suffix','InfoIfNoLogo','DescriptionBefore','LogoFilename',
		'PhotoFilename', 'PhotoCredits',
		'Type','SignupDetails','WhoCanGo', 'SignupAttachment', 'PerformanceInfo', 'HowTheShowWent',
		'CastList','SharedOrSeparateCasts','Tuition','TicketURL','PhotoURL1', 'PhotoURL2', 'PublicityAttachment',
		'AuditionLocation','AuditionPrepare','ClassDays','StartTime','EndTime',
		'GoogleCalendar', '','','','',
		'AnnounceDate',
		'SignupStartDate','AuditionDateTime1','AuditionDateTime2','CallbackDateTime','SignupEndDate',
		'RehearsalStartDate','TicketSaleDate','ShowFirstDate','ShowLastDate');


	if ($headers != $expectedHeaders)
	{
		error_log("Something's wrong with the data table. Expected " . print_r($expectedHeaders, 1) . " got " . print_r($headers, 1));
//		die;
	}





	$result = array_slice($result, 2);	// skip first two

	return $result;
}



?>
