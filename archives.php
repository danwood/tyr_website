<?php
require_once('_functions.php');
require_once('_classes.php');
require_once('_globals.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='';
$title='Tomorrow Youth Rep — Archives';
$description='Past shows and events from Tomorrow Youth Repertory in Alameda, California';
include('_head.php');
?>
	<style id="inline-styles">
<?php include('index.inline-styles.css.php'); ?>
	</style>
</head>
<body id="page-archives" class="blue-block">
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
						<section id="archives" class="clearfix capped-width">
							<div class="inlinebox"><h2>The Archives: TYR Shows &amp; Events</h2>
							<p>
								More pictures can be found on our <a href="http://instagram.com/tomorrowyouthrep">Instagram</a> page and our <a href="https://www.facebook.com/TomorrowYouthRep">Facebook</a> page. And be sure to check out our <a href="https://www.youtube.com/playlist?list=PLdiplfjeZiDs7jcakTcxwcuX68aer19Hd">YouTube channel</a> to see some videos as well!
							</p>
							</div>
							<div> <!-- similar elements together, for nth-child -->
<?php
$lastYearShown = 0;
foreach ($pastEvents as $event)
{
	$year = $event->getYear();
	if ($year != $lastYearShown)
	{
		$lastYearShown = $year;
		echo '<h3 style="clear:both">' . $year . '</h3>';
	}
echo '<div class="inlinebox past" id="THECARD_' . $event->id . '">' . PHP_EOL;
$event->outputEventCard();
echo "</div>\n";
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


