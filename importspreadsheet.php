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

	require_once('_importspreadsheet.php');


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


