<?php

$ALLOW_UNAUTHENTICATED = TRUE;
require_once('_authenticate.php');

if ($authenticated) {
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if (isset($_POST['return']))
		{
			header('Location: ' . $_POST['return']);		// Logged in; go to destination page.
			exit;
		}
	}
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
<form id="the_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

<p>
  <input id="submit" type="submit" value="Logout" />
</p>

</form>

<?php
} else {
?>
<form id="the_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
<p>
Login with password: <input type="text" name="password" />
</p>
<p>
	<input id="return" type="hidden" value="<?php echo htmlspecialchars($_GET['return']); ?>" />
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


