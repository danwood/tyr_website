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
$title='Tomorrow Youth Rep — Backstage';
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


foreach ($eventAssocArrays as $originalEventAssocArray)		// don't use ampersand here, there was a mysterious issue with the penultimate item in the array duplicated.
{



	$id = $eventAssoc[BEFORE_ID];
	$title = $eventAssoc[BEFORE_Title];
	$suffix = $eventAssoc[BEFORE_Suffix];
	$infoIfNoLogo = $eventAssoc[BEFORE_InfoIfNoLogo];
	$descriptionBefore = $eventAssoc[BEFORE_DescriptionBefore];
	$logoFilename = $eventAssoc[BEFORE_LogoFilename];
	$photoFilename = $eventAssoc[BEFORE_PhotoFilename];
	$photoCredits = $eventAssoc[BEFORE_PhotoCredits];
	$type = $eventAssoc[BEFORE_Type];
	$signupDetails = $eventAssoc[BEFORE_SignupDetails];
	$whoCanGo = $eventAssoc[BEFORE_WhoCanGo];
	$signupAttachment = $eventAssoc[BEFORE_SignupAttachment];
	$performanceInfo = $eventAssoc[BEFORE_PerformanceInfo];

	$howTheShowWent = $eventAssoc[BEFORE_HowTheShowWent];
	$castList = $eventAssoc[BEFORE_CastList];

	$tuition = $eventAssoc[BEFORE_Tuition];
	$ticketURL = $eventAssoc[BEFORE_TicketURL];
	$photoURL1 = $eventAssoc[BEFORE_PhotoURL1];
	$photoURL2 = $eventAssoc[BEFORE_PhotoURL2];
	$publicityAttachment = $eventAssoc[BEFORE_PublicityAttachment];
	$auditionLocation = $eventAssoc[BEFORE_AuditionLocation];
	$auditionPrepare = $eventAssoc[BEFORE_AuditionPrepare];

	$classDays = $eventAssoc[BEFORE_ClassDays];
	$startTime = $eventAssoc[BEFORE_StartTime];
	$endTime = $eventAssoc[BEFORE_EndTime];

	$googleCalendar = $eventAssoc[BEFORE_GoogleCalendar];

	$announceDate			= strtotime($eventAssoc[BEFORE_AnnounceDate]);
	$signupStartDate		= strtotime($eventAssoc[BEFORE_SignupStartDate]);
	$auditionDateTime1		= strtotime($eventAssoc[BEFORE_AuditionDateTime1]);
	$auditionDateTime2		= strtotime($eventAssoc[BEFORE_AuditionDateTime2]);
	$callbackDateTime		= strtotime($eventAssoc[BEFORE_CallbackDateTime]);
	$signupEndDate			= strtotime($eventAssoc[BEFORE_SignupEndDate]);
	$rehearsalStartDate		= strtotime($eventAssoc[BEFORE_RehearsalStartDate]);
	$ticketSaleDate			= strtotime($eventAssoc[BEFORE_TicketSaleDate]);
	$showFirstDate			= strtotime($eventAssoc[BEFORE_ShowFirstDate]);
	$showLastDate			= strtotime($eventAssoc[BEFORE_ShowLastDate]);




}


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


