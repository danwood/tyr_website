<?php

require_once('_authenticate.php');
require_once('_prelude.php');
require_once('phmagick.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='';
$title='Tomorrow Youth Rep — Database';
$description='';
include('_head.php');
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
include('_header.php'); ?>
					<main>
						<section id="volunteer" class="clearfix capped-width">
							<div class="inlinebox">


<p>&#10133; <a href="new.php"><b>Add a show or event</b></a></p>
<?php

function outputList($eventArray, $headline)
{
	if (count($eventArray)) {
		echo '<h3>' . htmlspecialchars($headline) . '</h3>' . PHP_EOL;
		echo '<div class="columnar">' . PHP_EOL;
		foreach ($eventArray as $event)
		{
			echo '<p><a href="edit.php?event=' . $event->id() . '">' . htmlspecialchars($event->title()) . '</a></p>' . PHP_EOL;
		}
		echo '</div>' . PHP_EOL;
	}
}

outputList($hiddenEvents, 'Unpublished Events');
outputList($currentShows, 'Upcoming Shows');
outputList($currentOther, 'Upcoming Events');
outputList($laterEvents, 'Later This Year');

echo '<h3>Archives</h3>';

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
	if ($event->isPastEvent()) {
		echo '<b>';
	}
	echo '<a href="edit.php?event=' . $event->id() . '">' . htmlspecialchars($event->title()) . '</a>';
	if ($event->isPastEvent()) {
		echo '</b>';
	}
	echo '</p>' . PHP_EOL;
}
echo '</div>' . PHP_EOL; 	// close out previous columnar div
?>
<p><i>Boldfaced titles are shown in the archives</i></p>






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


