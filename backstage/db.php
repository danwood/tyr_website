<?php
require_once('_authenticate.php');	// Login required
require_once('../_functions.php');
require_once('../_classes.php');
require_once('../_globals.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='../';	// Needed for prelude since we aren't at top level directory
$title='Tomorrow Youth Rep — Database';
$description='';
include('../_head.php');
?>
	<style>
	h3, h4 { margin-top:20px; }

	@media only screen and (min-width:36em) {
		.columnar {
		    -webkit-column-count: 2; /* Chrome, Safari, Opera */
		    -moz-column-count: 2; /* Firefox */
		    column-count: 2;
		}
}

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
include('../_header.php'); ?>
					<main>
						<section id="volunteer" class="clearfix capped-width">
							<div class="inlinebox">


<p><a href="../">« Backstage</a></p>
<p>&#10133; <a href="edit.php"><b>Add a show or event</b></a></p>
<?php

function outputList($eventArray, $headline)
{
	if (count($eventArray)) {
		echo '<h3>' . htmlspecialchars($headline) . '</h3>' . PHP_EOL;
		echo '<div class="columnar">' . PHP_EOL;
		foreach ($eventArray as $event)
		{
			echo '<p><a href="edit.php?id=' . $event->id . '">' . htmlspecialchars($event->title);
			if (empty($event->title)) {
				echo '[UNTITLED]';				// Make sure that untitled events can be seen here!
			}
			echo '</a></p>' . PHP_EOL;
		}
		echo '</div>' . PHP_EOL;
	}
}

outputList($hiddenEvents, 'Unpublished Events');
outputList($unannouncedEvents, 'Unannounced Events');
outputList($currentShows, 'Upcoming Shows');
outputList($currentOther, 'Upcoming Events');
outputList($laterEvents, 'Later This Year');

echo '<h3>Past Events</h3>';
echo '<p><i>Boldfaced titles are shown in the archives</i></p>';

$lastYearShown = 0;
foreach ($allPastEvents as $event)
{
	$year = $event->getYear();
	if ($year != $lastYearShown)
	{
		if ($lastYearShown != 0) {
			echo '</div>' . PHP_EOL; 	// close out previous columnar div
		}
		$lastYearShown = $year;
		echo '<h4>' . $year . '</h4>' . PHP_EOL;
		echo '<div class="columnar">' . PHP_EOL;
	}
	echo '<p>';
	if ($event->isPastArchiveState()) {
		echo '<b>';
	}
	echo '<a href="edit.php?id=' . $event->id . '">' . htmlspecialchars($event->title) . '</a>';
	if ($event->isPastArchiveState()) {
		echo '</b>';
	}
	echo '</p>' . PHP_EOL;
}
echo '</div>' . PHP_EOL; 	// close out previous columnar div
?>






							</div>
						</section>
					</main>
				</div><!-- end before-sticky-footer -->
			</div><!-- end clearfix -->
		</div><!-- end contain-sticky-footer -->
<?php include('../_footer.php'); ?>
	</div>
<?php $includePinterest = FALSE; include('../_body.end.php'); ?>
</body>
</html>


