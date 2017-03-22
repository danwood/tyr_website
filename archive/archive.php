<?php

include '../_Markdown.php';
include '../_MarkdownExtra.php';

// http://michelf.ca/projects/php-markdown/configuration/


$base='';
$root='../';	// Needed for prelude since we aren't at top level directory

require_once('../_prelude.php');

$event = Event::getSpecifiedEvent(TRUE);	// must be archive

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

$title='Tomorrow Youth Rep — ' . $event->title();
$description='Tomorrow Youth Rep is an educational theater program based in Alameda, CA, offering after-school classes and camps for youths of all experience levels.';

include('../_head.php');
?>
	<style>


.suffix { color:#ddd;}

p.credits
{
	text-align:right;
	font-size:80%;
}

@media only screen and (min-width:48em)
{
	.archive-photo { width:50%; }
}
	</style>
	<link rel="stylesheet" type="text/css" href="../colorbox.css">
</head>
<body id="page-event">
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
						<div class="white-block">
							<section id="event" class="clearfix capped-width pullbottom">
								<div class="inlinebox nobottom">
									<h2>
										<?php echo htmlspecialchars($event->title()); ?>
										<span class="suffix"><?php echo htmlspecialchars($event->suffix()); ?></span>
									</h2>
								</div>
								<div> <!-- similar elements together, for nth-child -->








<?php

	$numberOfImagesForPinterest = 0;	// set below
	// Output card type and other metadata based on presence of photo[s], logo, or none
	$photoFilename = $event->photoFilename();
	if ($photoFilename)
	{
		$numberOfImagesForPinterest = 1;
		$matches = $event->matchesFromPhotoFilename();
		$photoCount = 1;
		// Look for ending number, e.g. narnia3.jpg.  If so, that means we should 1 through n, so RANDOMLY pick one of them.
		if ($matches)
		{
			$photoCount = $matches[2];
			$base = $matches[1];
			$extension = $matches[3];
			$numberOfImagesForPinterest = $photoCount;
			for ($i = 0 ; $i < $photoCount ; $i++)
			{
				// Look for movie
				$movieFile =  $base . ($i+1) . '.mp4';
				$movieInstead = (file_exists('../shows/photo/' . $movieFile));

?>
									<div class="inlinebox archive-photo<?php if (!$movieInstead) echo ' enlargable';?>">
<?php
if ($movieInstead)
{
?>
										<video class="full-block" controls="controls" poster="<?php echo $root . 'photo/' . $base . ($i+1) . '.' . $extension; ?>">
											<source src="<?php echo $root; ?>shows/photo/<?php echo $movieFile; ?>" />
										</video>

<?php
}
else
{
?>
										<img class="full-block" src="<?php echo $root . 'shows/photo/' . $base . ($i+1) . '.' . $extension; ?>"
											alt="<?php echo htmlspecialchars($event->title() . ' photo ' . ($i+1)); ?>">


<?php
	if (file_exists('..shows//photo/original.' . $base . ($i+1) . '.' . $extension ))
	{
?>
											<a href="<?php echo $root . 'shows/photo/original.' . $base . ($i+1) . '.' . $extension; ?>"
												title="<?php echo htmlspecialchars($event->title()); ?>"
												rel="enclosure"></a>

<?php
	}
	else
	{
?>
											<a href="<?php echo $root . 'shows/photo/' . $base . ($i+1) . '.' . $extension; ?>"
												title="<?php echo htmlspecialchars($event->title()); ?>"
												rel="enclosure"></a>

<?php
	}
}
?>
									</div>
<?php
			}
			$photoCredits = $event->photoCredits;
			if ($photoCredits)
			{
?>
									<div class="inlinebox">
										<p class="credits">Photo Credits: <?php echo htmlspecialchars($photoCredits); ?></p>
									</div>
<?php
			}
		}
		else
		{
?>
									<div class="inlinebox archive-photo">
										<img class="full-block" src="<?php echo $root; ?>shows/photo/<?php echo $photoFilename; ?> ">
									</div>
<?php
		}
	}
	else
	{
		$logo = $event->logoFilename;
		if ($logo)
		{
			$numberOfImagesForPinterest = 1;
?>
									<div class="inlinebox archive-photo">
										<img class="full-block" src="<?php echo $root; ?>logo/<?php echo $logo; ?> ">
									</div>
<?php
		}
	}
?>
									<div class="inlinebox">
<?php
$event->outputSocialSharing($numberOfImagesForPinterest, FALSE);
?>
									</div>
									<div class="inlinebox">
<?php

$html = Markdown::defaultTransform($event->howTheShowWent);
echo $html;
echo "<br /><br />\n";

$multiDate = (!empty($event->showLastDate) && $event->showFirstDate != $event->showLastDate);
echo '<p>' . ($multiDate ? 'Dates' : 'Date') . ': ' . htmlspecialchars(date('F j', ($event->showFirstDate)));
if ($multiDate)
{
	echo ' to ' . htmlspecialchars(date('F j', ($event->showLastDate)));
}
echo htmlspecialchars(date(', Y', ($event->showFirstDate)));
echo '</p>' . PHP_EOL;
if (!empty($event->photoURL1))
{
	echo '<p><a href="' . htmlspecialchars($event->photoURL1) . '">More photos</a>';

	if (!empty($event->photoURL2))
	{
		echo ' and <a href="' . htmlspecialchars($event->photoURL2) . '">even more photos</a>';
	}
	echo '</p>' . PHP_EOL;
}





?>
									</div>















								</div>	<!-- similar elements -->
							</section>
						</div>
					</main>
				</div><!-- end before-sticky-footer -->
			</div><!-- end clearfix -->
		</div><!-- end contain-sticky-footer -->
<?php include('../_footer.php'); ?>
	</div>
<?php $includePinterest = TRUE; include('../_body.end.php'); ?>

		<script charset="utf-8" src="../js/jquery.colorbox.min.js"></script>
		<script>
			var pixelsWide = $(window).width()  * window.devicePixelRatio;
			var pixelsHigh = $(window).height() * window.devicePixelRatio;
			$('.enlargable').colorbox({
					href: function(){ return $(this).find("a[rel~='enclosure']").attr('href'); },
					title: function(){ return $(this).find("a[rel~='enclosure']").attr('title'); },
					photo: false,
					rel: 'gridItem',
					opacity: '0.50',
					transition: 'elastic',
					loop: false,
					slideshow: true,
					slideshowAuto: false,
					slideshowSpeed: 5000,
					slideshowStart: 'Slideshow',
					slideshowStop: 'Stop',
					current: '{current} of {total}',
					previous: 'Previous',
					next: 'Next',
					close: 'Close',
					xhrError: 'This content failed to load.',
					imgError: 'This image failed to load.',
					scale: true,
					maxWidth: '90%',
					maxHeight: '90%',
			});
		</script>


</body>
</html>
