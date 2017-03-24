<?php

$authenticated = FALSE;

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (isset($_POST['password']))
	{
		$password = trim(strtolower($_POST['password']));
		$authenticated = ($password == 'XXX');
		if ($authenticated)
		{
			$_SESSION['authenticated'] = 1;
		}
	}
	else
	{
		$authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] = 1;
	}
}
else
{
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


