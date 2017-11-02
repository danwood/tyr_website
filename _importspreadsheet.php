<?php

// LOAD FROM GOOGLE TABLE INTO SQLITE


// Get the database loaded from the Google cache file
require_once('_spreadsheet.php');

$eventAssocArrays = getEventAssocArrays();		// Sorted by BEFORE_ShowFirstDate


$db = new SQLite3('tyr.sqlite3') or die('Unable to open database');

// Clear out the table
	$ret = $db->exec('DELETE FROM EVENTS');
	if(!$ret) {
		echo $db->lastErrorMsg();
		die;
	}


foreach ($eventAssocArrays as $eventAssoc)		// don't use ampersand here, there was a mysterious issue with the penultimate item in the array duplicated.
{
	$id									= $eventAssoc[BEFORE_ID];
	$title								= $eventAssoc[BEFORE_Title];
	$suffix								= $eventAssoc[BEFORE_Suffix];
	$infoIfNoLogo						= $eventAssoc[BEFORE_InfoIfNoLogo];
	$descriptionBefore					= $eventAssoc[BEFORE_DescriptionBefore];
	$logoFilename						= $eventAssoc[BEFORE_LogoFilename];
	$photoFilename						= $eventAssoc[BEFORE_PhotoFilename];

// Get rid of the legacy year embedded in the filenames
	$photoFilename = preg_replace('/^[0-9]+/', '', $photoFilename);

	$photoCredits						= $eventAssoc[BEFORE_PhotoCredits];
	$typeString							= $eventAssoc[BEFORE_Type];
	$signupDetails						= $eventAssoc[BEFORE_SignupDetails];
	$whoCanGo							= $eventAssoc[BEFORE_WhoCanGo];
	$signupAttachment					= $eventAssoc[BEFORE_SignupAttachment];
	$performanceInfo					= $eventAssoc[BEFORE_PerformanceInfo];
	$howTheShowWent						= $eventAssoc[BEFORE_HowTheShowWent];
	$castList							= $eventAssoc[BEFORE_CastList];
	$sharedCast							= (strtolower($eventAssoc[BEFORE_SharedOrSeparateCasts])) == 'shared';
	$tuition							= $eventAssoc[BEFORE_Tuition];
	$ticketURL							= $eventAssoc[BEFORE_TicketURL];
	$photoURL1							= $eventAssoc[BEFORE_PhotoURL1];
	$photoURL2							= $eventAssoc[BEFORE_PhotoURL2];
	$publicityAttachment				= $eventAssoc[BEFORE_PublicityAttachment];
	$auditionLocation					= $eventAssoc[BEFORE_AuditionLocation];
	$auditionPrepare					= $eventAssoc[BEFORE_AuditionPrepare];
	$classDays							= $eventAssoc[BEFORE_ClassDays];
	$startTime							= $eventAssoc[BEFORE_StartTime];
	$endTime							= $eventAssoc[BEFORE_EndTime];
	$googleCalendar						= $eventAssoc[BEFORE_GoogleCalendar];

	$announceDate			= $eventAssoc[BEFORE_AnnounceDate];
	$signupStartDate		= $eventAssoc[BEFORE_SignupStartDate];
	$auditionDateTime1		= $eventAssoc[BEFORE_AuditionDateTime1];
	$auditionDateTime2		= $eventAssoc[BEFORE_AuditionDateTime2];
	$callbackDateTime		= $eventAssoc[BEFORE_CallbackDateTime];
 	$signupEndDate			= $eventAssoc[BEFORE_SignupEndDate];
	$rehearsalStartDate		= $eventAssoc[BEFORE_RehearsalStartDate];
	$ticketSaleDate			= $eventAssoc[BEFORE_TicketSaleDate];
	$showFirstDate			= $eventAssoc[BEFORE_ShowFirstDate];
 	$showLastDate			= $eventAssoc[BEFORE_ShowLastDate];

// Parse these dates into timestamps but then convert non-empty ones into ISO 8601 strings.

	if ($announceDate)		$announceDate			= date('c', strtotime($announceDate));
	if ($signupStartDate)	$signupStartDate		= date('c', strtotime($signupStartDate));
	if ($auditionDateTime1)	$auditionDateTime1		= date('c', strtotime($auditionDateTime1));
	if ($auditionDateTime2)	$auditionDateTime2		= date('c', strtotime($auditionDateTime2));
	if ($callbackDateTime)	$callbackDateTime		= date('c', strtotime($callbackDateTime));
 	if ($signupEndDate)		$signupEndDate			= date('c', strtotime($signupEndDate));
	if ($rehearsalStartDate)$rehearsalStartDate		= date('c', strtotime($rehearsalStartDate));
	if ($ticketSaleDate)	$ticketSaleDate			= date('c', strtotime($ticketSaleDate));
	if ($showFirstDate)		$showFirstDate			= date('c', strtotime($showFirstDate));
 	if ($showLastDate) {
		// Adjust last date to end of day
		$showLastDate = date('c', strtotime(date('Y-m-d',strtotime($showLastDate)).' 23:59:59'));
	}



	$types = array('unknown', 'event announce-only', 'event to archive', 'audition show',
		 'class show', 'backstage camp');
	$type = array_search(strtolower($typeString), $types);

	if ($title == '') continue;		// IGNORE PLACEHOLDER ROWS

	$query = <<<EOD
INSERT INTO events (
  	id,
  	title,
  	suffix,
  	infoIfNoLogo,
  	descriptionBefore,
  	logoFilename,
  	photoFilename,
  	photoCredits,
  	type,
  	signupDetails,
  	whoCanGo,
  	signupAttachment,
  	performanceInfo,
  	howTheShowWent,
  	castList,
  	sharedCast,
  	tuition,
  	ticketURL,
  	photoURL1,
  	photoURL2,
  	publicityAttachment,
  	auditionLocation,
  	auditionPrepare,
  	classDays,
  	startTime,
  	endTime,
  	announceDate,
  	signupStartDate,
  	auditionDateTime1,
  	auditionDateTime2,
  	callbackDateTime,
  	signupEndDate,
  	rehearsalStartDate,
  	ticketSaleDate,
  	showFirstDate,
  	showLastDate)
VALUES (
EOD;


$query .= $id . ", ";
$query .= "'" . $db->escapeString($title) . "', ";
$query .= "'" . $db->escapeString($suffix) . "', ";
$query .= "'" . $db->escapeString($infoIfNoLogo) . "', ";
$query .= "'" . $db->escapeString($descriptionBefore) . "', ";
$query .= "'" . $db->escapeString($logoFilename) . "', ";
$query .= "'" . $db->escapeString($photoFilename) . "', ";
$query .= "'" . $db->escapeString($photoCredits) . "', ";
$query .= (integer)$type . ", ";						// Integer
$query .= "'" . $db->escapeString($signupDetails) . "', ";
$query .= "'" . $db->escapeString($whoCanGo) . "', ";
$query .= "'" . $db->escapeString($signupAttachment) . "', ";
$query .= "'" . $db->escapeString($performanceInfo) . "', ";
$query .= "'" . $db->escapeString($howTheShowWent) . "', ";
$query .= "'" . $db->escapeString($castList) . "', ";
$query .= ($sharedCast ? 1 : 0) . ", ";					// Boolean, so Integer
$query .= "'" . $db->escapeString($tuition) . "', ";
$query .= "'" . $db->escapeString($ticketURL) . "', ";
$query .= "'" . $db->escapeString($photoURL1) . "', ";
$query .= "'" . $db->escapeString($photoURL2) . "', ";
$query .= "'" . $db->escapeString($publicityAttachment) . "', ";
$query .= "'" . $db->escapeString($auditionLocation) . "', ";
$query .= "'" . $db->escapeString($auditionPrepare) . "', ";
$query .= "'" . $db->escapeString($classDays) . "', ";
$query .= "'" . $db->escapeString($startTime) . "', ";
$query .= "'" . $db->escapeString($endTime) . "', ";
$query .= "'" . $db->escapeString($announceDate) . "', ";
$query .= "'" . $db->escapeString($signupStartDate) . "', ";
$query .= "'" . $db->escapeString($auditionDateTime1) . "', ";
$query .= "'" . $db->escapeString($auditionDateTime2) . "', ";
$query .= "'" . $db->escapeString($callbackDateTime) . "', ";
$query .= "'" . $db->escapeString($signupEndDate) . "', ";
$query .= "'" . $db->escapeString($rehearsalStartDate) . "', ";
$query .= "'" . $db->escapeString($ticketSaleDate) . "', ";
$query .= "'" . $db->escapeString($showFirstDate) . "', ";
$query .= "'" . $db->escapeString($showLastDate) . "')";


//echo $query;
//echo "\n";
   	$ret = $db->exec($query);
   	if(!$ret) {
   		echo $db->lastErrorMsg();
   		die;
   	}
}

$db->close();


?>
