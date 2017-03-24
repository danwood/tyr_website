<?php

error_reporting(E_ALL);
date_default_timezone_set('America/Los_Angeles');
$authenticated = FALSE;
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Page loaded from form submission; login or logout.
	if (isset($_POST['password']))
	{
		// if password matches, login by setting local variable and session variable.

		$password = trim($_POST['password']);
		$authenticated = $_SESSION['authenticated'] = ($password == 'XXX');
	}
	else
	{
		// no password given; log out, resetting local variable and session variable.
		$authenticated = $_SESSION['authenticated'] = 0;
	}
}
else
{
	// Standard page load; get value of $authenticated from session variable.
	$authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] = 1;
}

require_once('_prelude.php');
require_once('phmagick.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='';
$title='Tomorrow Youth Rep — Import the Google table';
$description='';
include('_head.php');
?>
	<style>



	</style>
</head>
<body id="" class="lightgray-block">
	<div class="clearfix outside-sticky-footer">
		<!-- Specify grid system. All boxes must be clearfix. Specify layout direction. -->
		<div class="contain-sticky-footer fullwidth">
			<div class="clearfix">
				<!-- Nested groups of boxes inside; must outdent boxes since they indent for gutters -->
				<div class="before-sticky-footer">

<?php
$fullHeader = FALSE;
include('_header.php'); ?>
					<main>
						<section id="volunteer" class="clearfix capped-width">
							<div class="inlinebox">

<?php
if ($authenticated) {


// LOAD FROM GOOGLE TABLE INTO SQLITE


// Get the database loaded from the Google cache file
require_once('_database.php');

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
 	if ($showLastDate)		$showLastDate			= date('c', strtotime($showLastDate));


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


echo $query;
echo "\n";
   	$ret = $db->exec($query);
   	if(!$ret) {
   		echo $db->lastErrorMsg();
   		die;
   	}
}

$db->close();


?>




















<form id="uploader" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

<p>
  <input id="submit" type="submit" value="Logout" />
</p>

</form>

<?php
} else {
?>
<form id="uploader" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
<p>
Login with password: <input type="text" name="password" />
</p>
<p>
	<input id="submit" type="submit" value="Login" />
</p>

</form>

<?php
}
?>


							</div>
						</section>
					</main>
				</div><!-- end before-sticky-footer -->
			</div><!-- end clearfix -->
		</div><!-- end contain-sticky-footer -->
<?php include('_footer.php'); ?>
	</div>
<?php $includePinterest = FALSE; include('_body.end.php'); ?>
</body>
</html>


