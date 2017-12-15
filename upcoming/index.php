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

$title = $event ? 'Tomorrow Youth Rep Upcoming: ' . $event->title() : 'Tomorrow Youth Rep Upcoming Shows and Events';
if ($event)
{
	$description='Find out about upcoming shows and events, like "' . $event->title() . ',"" put on by TYR in Alameda, CA';
}
else
{
	$description='Find out about upcoming shows and events put on by Tomorrow Youth Repertory in Alameda, California.';
}
include('../_head.php');
?>
	<style>

.prefix, .suffix { color:#ddd;}
.info { margin-bottom:80px;}
ul { margin-bottom:1em;}
.card { margin-bottom:1em;}

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
							<div class="inlinebox nobottom"><h2>Upcoming TYR Shows, Classes, Camps</h2></div>
								<div class="clearfix">
									<div class="inlinebox card">
<?php
	$event->outputEventCard(FALSE, FALSE);
?>
									</div>
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
						<section class="clearfix inlinebox capped-width pullbottom">
							<p>
								<a href="./#scholarship">TYR Scholarship Policy</a>
							</p>
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
