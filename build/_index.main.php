<!-- contents of <main> : Do not disturb this comment -->
<?php
	if (isset($_GET['when']))
{
?>
						<div style="position:absolute: bottom:0; right:0;">
							<p><span style="background:yellow; padding:4px;"><?php echo date('F j Y', $now); ?></span></p>
						</div>
<?php
}
?>
						<div class="white-block">
							<section id="coming-up" class="clearfix capped-width">
								<div class="inlinebox" id="about-us">
									<p>
										Tomorrow Youth Rep is an educational theater program based in Alameda, CA, offering after-school classes and camps for youths of all experience levels.
										&nbsp;&nbsp; <a href="about.<?php echo currentExtension(); ?>">More about us</a>

									</p>
									<p>
											<form action="https://www.paypal.com/donate" method="post" target="_top">
<input type="hidden" name="hosted_button_id" value="D8XJ49D3PDQN6" />
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>
									</p>
								</div>
<?php
if (count($currentShows) > 0)
{
?>
								<div class="inlinebox">
									<h2>Upcoming Shows</h2>
									<div>
<?php

	$showVideo = FALSE;

	foreach ($currentShows as $event)
	{
		// FIXME: Have a way to show video on Romeo and Juliet, anything else with a video

		echo '<div class="inlinebox current-show" id="THECARD_' . $event->id . '">' . PHP_EOL;
		$event->outputEventCard(TRUE, TRUE);
		echo "</div>\n";
	}
?>

									</div>
								</div>
<?php
	if ($showVideo)
	{
?>
								<div class="inlinebox trailer">
									<div class='youtube-container'>
										<iframe src='http://www.youtube.com/embed/BrZqrqSj7b0' frameborder='0' allowfullscreen></iframe>
									</div>
									<p>Romeo and Juliet Trailer</p>
								</div>
<?php
	}
}
if (count($currentOther) > 0)
{
?>
								<div class="inlinebox">
									<h2>TYR Camps &amp; Other Programs</h2>
									<div>
<?php

	foreach ($currentOther as $event)
	{
if ($staging) error_log("... Current ... " . $event->title);
		echo '<div class="inlinebox current-event" id="THECARD_' . $event->id . '">' . PHP_EOL;
		$event->outputEventCard(TRUE, TRUE);
		echo "</div>\n";
	}
?>
									</div>
								</div>
<?php
}
?>
							</section>
						</div>
						<div class="lightgray-block">
							<section id="later" class="clearfix capped-width pullbottom">
<?php
if (count($laterEvents) > 0)
{
?>
								<div class="inlinebox nobottom"><h2>Later This Year</h2></div>
								<div> <!-- similar elements together, for nth-child -->
<?php
foreach ($laterEvents as $event)
{
	echo '<div class="inlinebox later" id="THECARD_' . $event->id . '">' . PHP_EOL;
	$event->outputEventCard(FALSE);
	echo "</div>\n";
}
?>
								</div>
<?php
}
?>
								<div class="inlinebox nobottom" id="mc_embed_signup" style="text-align:center; margin-top:20px;">
									Keep up using <a href="https://twitter.com/tomyouthrep">Twitter</a>,
									<a href="http://www.facebook.com/TomorrowYouthRep">Facebook</a>&nbsp;<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FTomorrowYouthRep&amp;width=90&amp;height=21&amp;colorscheme=light&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px; margin-bottom:-6px" allowTransparency="true"></iframe>
									…and our <a href="http://eepurl.com/dM4Ynw">email&nbsp;newsletter.</a>

								</div>
							</section>
						</div>

						<div class="blue-block">
							<section id="recent" class="clearfix capped-width">
								<div class="inlinebox nobottom"><h2>Recent Shows &amp; Events</h2></div>
<?php
// First indicate recent shows that don't have an image yet
$noImageYetArray = array();
$indexOfFirstWithPhoto = 0;
foreach ($pastEvents as $event)
{
	if (!$event->shouldShowPhoto()) {
		$noImageYetArray[] = $event;
	}
	else {
		break;		// Stop as soon as we hit
	}
	$indexOfFirstWithPhoto++;
}
if (count($noImageYetArray)) {
?>
								<div class="inlinebox">
									<p style="padding:0.5em 0"><i>Images coming soon:</i>

<?php
	$hasOutputYet = FALSE;
	foreach($noImageYetArray as $noImageYetEvent) {
		if ($hasOutputYet) {
			echo ', ';
		}
		$hasOutputYet = TRUE;
		echo htmlspecialchars($noImageYetEvent->title) . ' <i>(' . htmlspecialchars($noImageYetEvent->getCardLowerRightText()) . ')</i>';
	}
?>
										</p>
								</div>
<?php
}
?>
								<div> <!-- similar elements together, for nth-child -->
<?php
$mostRecentEvents = array_slice($pastEvents, $indexOfFirstWithPhoto, NUMBER_OF_PAST_TO_SHOW);
foreach ($mostRecentEvents as $event)
{
	echo '<div class="inlinebox past-nine" id="THECARD_' . $event->id . '">' . PHP_EOL;
	$event->outputEventCard();
	echo "</div>\n";
}
?>
								</div>
<?php
// Slice one less -- so the last one above gets repeated, so we can selectively show it if it got hidden above (when 2-up display)
$lessRecentEvents = array_slice($pastEvents, $indexOfFirstWithPhoto+NUMBER_OF_PAST_TO_SHOW-1, NUMBER_ADDITIONAL_PAST_TITLES);
if (count($lessRecentEvents))
{
?>
								<div class="inlinebox nobottom archive-intro">
									<p style="padding:0.5em 0">Earlier:
<?php
$index = 0;
foreach ($lessRecentEvents as $event)
{
	if (0 == $index) { echo '<span class="two-up-only">'; }
	echo '<a href="' . $root . 'archive/' . $event->nameCode() . '">' . PHP_EOL;
	$title = $event->title;
	echo htmlspecialchars($title);
	echo "</a>, \n";
	if (0 == $index) { echo '</span>'; }
	$index++;
}



					// LATER:  APPEND:    and more
?>
										...</p>
								</div>
<?php
}
?>
								<div class="inlinebox nobottom archive-button">
									<p style="float:right;"><a class="button" href="archives.<?php echo currentExtension(); ?>" style="display:block">Archives</a></p>
								</div>
							</section>
						</div>



