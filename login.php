<?php
$ALLOW_UNAUTHENTICATED = TRUE;
require_once('_authenticate.php');

require_once('_functions.php');
require_once('_classes.php');
require_once('_globals.php');

$return = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (isset($_POST['return']))
	{
		$return = $_POST['return'];
	}
	if ($authenticated && !empty($return))
	{
		header('Location: ' . $return);		// Logged in; go to destination page.
		exit;
	}
}
else
{
	if (isset($_GET['return'])) $return = $_GET['return'];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='';
$title='Tomorrow Youth Rep — Login';
$description='';
include('_head.php');
?>
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
?>
<form id="the_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

<p>
  <input id="logout" type="submit" value="Logout" />
</p>

</form>

<?php
} else {
?>
<form id="the_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<p>
Login with password: <input type="text" name="password" />
</p>
<p>
	<input id="return" name="return" type="hidden" value="<?php echo htmlspecialchars($return); ?>" />
	<input id="login" type="submit" value="Login" />
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


