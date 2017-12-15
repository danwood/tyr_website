<?php
require_once('../_functions.php');
require_once('../_classes.php');
require_once('../_globals.php');

include '../_Markdown.php';
include '../_MarkdownExtra.php';

// http://michelf.ca/projects/php-markdown/configuration/

$event = Event::getSpecifiedEvent(FALSE);

if (!$event)
{
	echo "unknown ID: " . $_GET['id'];
	die;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='../';

$title = 'Tomorrow Youth Rep Upcoming: ' . $event->title();
$description='Find out about "' . $event->title() . ',"" put on by TYR in Alameda, CA';

include('../_head.php');
?>
	<style>

.prefix, .suffix { color:#ddd;}
.info { margin-bottom:80px;}
ul { margin-bottom:1em;}
.card { margin-bottom:1em;}
.similar-photo-background { background-color:black;}

.similar-photo { width:50%;}

@media only screen and (min-width:36em) and (max-width:47.99em)
{
	.card { width:50%; margin-left:25%; }
}

@media only screen and (min-width:48em)
{
	.card { width:33.33%; margin-left:33.33%;}
}

@media only screen and (min-width:36em)
{
	.third { width:33.33%; }
	.down { margin-top:5em;}
	.bigger-left{ margin-left:-25%}
	.bigger-right{ margin-right:-25%;}
	.front { page-break-before:always; position:relative; }
	.similar-photo { width:25%;}
}

	</style>
</head>
<body>
	<div class="clearfix outside-sticky-footer">
		<!-- Specify grid system. All boxes must be clearfix. Specify layout direction. -->
		<div class="contain-sticky-footer fullwidth">
			<div class="clearfix">
				<!-- Nested groups of boxes inside; must outdent boxes since they indent for gutters -->
				<div class="before-sticky-footer">
<?php
	if (isset($_GET['when']))
{
?>
						<div class="datepicker">
							<form action="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>" method="get">
								<input id="date-input" type="date" name="when" value="<?php if (isset($_GET['when'])) { echo $_GET['when']; } else { echo date('Y-m-d'); } ?>" />
								<!-- <input type="submit" value="Reload for this date" /> -->
							</form>
						</div>
<?php
}
$fullHeader = FALSE;
include('../_header.php'); ?>
					<main>
						<section class="clearfix capped-width pullbottom">
								<div class="clearfix">
									<div class="inlinebox card">
<?php
	$event->outputEventCard(FALSE, FALSE);
?>
									</div>
								</div>
						</section>
<?php
if ($event->similarEventID) {

	$startIndex = 0; $stopIndex = 4;

	$similarEvent = Event::getEventByID($event->similarEventID);
	$photoFilename = $similarEvent->photoFilename();
	if ($photoFilename)
	{
		$numberOfImagesForPinterest = 1;
		$matches = $similarEvent->matchesFromPhotoFilename();
		$photoCount = 1;
		// Look for ending number, e.g. narnia3.jpg.  If so, that means we should 1 through n, so RANDOMLY pick one of them.
		if ($matches)
		{
?>
						<div class="similar-photo-background">
<?php
			$photoCount = $matches[2];
			$base = $matches[1];
			$extension = $matches[3];
			$numberOfImagesForPinterest = $photoCount;

			for ($i = $startIndex ; $i < $photoCount ; $i++)
			{
				// Look for movie
				$movieFile =  $base . ($i+1) . '.mp4';
				$movieInstead = (file_exists($root . 'shows/photo/'  . $similarEvent->getYear() . '/' .  $movieFile));
				if ($movieInstead) continue;		// don't show movie here

				echo '<img class="similar-photo" src="' . $root . 'shows/photo/' . $similarEvent->getYear() . '/' . $base . ($i+1) . '.' . $extension . '" ';
				echo 'alt="' . htmlspecialchars($similarEvent->title() . ' photo ' . ($i+1)) . '">';
				if ($i+1 >= $stopIndex) {
					echo PHP_EOL;
					break;
				}
			}
?>
						</div>
<?php
		}
	}
}
?>


						<section class="clearfix capped-width pullbottom">
								<div class="clearfix">
									<div class="inlinebox info">
<?php
	$event->outputEventCurrentBlurb();

	// Special case for Romeo and Juliet
	if ($event->id() == 510)
	{
?>
<div class='youtube-container'>
	<iframe src='http://www.youtube.com/embed/BrZqrqSj7b0' frameborder='0' allowfullscreen></iframe>
</div>
<?php
}
?>
									</div>
								</div>
						</section>
<?php
if ($event->similarEventID) {

	$startIndex = 4; $stopIndex = 8;

	$similarEvent = Event::getEventByID($event->similarEventID);
	$photoFilename = $similarEvent->photoFilename();
	if ($photoFilename)
	{
		$numberOfImagesForPinterest = 1;
		$matches = $similarEvent->matchesFromPhotoFilename();
		$photoCount = 1;
		// Look for ending number, e.g. narnia3.jpg.  If so, that means we should 1 through n, so RANDOMLY pick one of them.
		if ($matches)
		{
?>
						<div class="similar-photo-background">
<?php
			$photoCount = $matches[2];
			$base = $matches[1];
			$extension = $matches[3];
			$numberOfImagesForPinterest = $photoCount;

			for ($i = $startIndex ; $i < $photoCount ; $i++)
			{
				// Look for movie
				$movieFile =  $base . ($i+1) . '.mp4';
				$movieInstead = (file_exists($root . 'shows/photo/'  . $similarEvent->getYear() . '/' .  $movieFile));
				if ($movieInstead) continue;		// don't show movie here

				echo '<img class="similar-photo" src="' . $root . 'shows/photo/' . $similarEvent->getYear() . '/' . $base . ($i+1) . '.' . $extension . '" ';
				echo 'alt="' . htmlspecialchars($similarEvent->title() . ' photo ' . ($i+1)) . '">';
				if ($i+1 >= $stopIndex) {
					echo PHP_EOL;
					break;
				}
			}
?>
						</div>
						<div class="inlinebox">
							<p>Photos from TYR's <?php echo htmlspecialchars($similarEvent->getYear()); ?> production of <a href="<?php echo htmlspecialchars($similarEvent->link()); ?>"><?php echo htmlspecialchars($similarEvent->title()); ?></a></p>
						</div>
<?php
		}
	}
}
?>

						<section class="clearfix capped-width pullbottom">
							<div class="inlinebox">
								<p>
									<a href="./#scholarship">TYR Scholarship Policy</a>
								</p>
							</div>
						</section>
					</main>
				</div><!-- end before-sticky-footer -->
			</div><!-- end clearfix -->
		</div><!-- end contain-sticky-footer -->
<?php include('../_footer.php'); ?>
	</div>
<?php $includePinterest = TRUE; include('../_body.end.php'); ?>
</body>
</html>
