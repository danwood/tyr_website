<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
					<header class="black-block">
						<div class="clearfix capped-width">
							<div class="inlinebox tyr-logo">
								<a class="page-home" href="<?php echo currentIndexPath(TRUE); ?>"><img class="fullwidth" style="max-width:458px;" src="<?php echo $root; ?>img/logo-transparent-white.png" alt="TYR Logo" /><span class="visuallyhidden">Tomorrow Youth Repertory</span></a>
							</div>
							<div id="header-navmenu" class="navmenu inlinebox icon-menu">
								<span class="visuallyhidden">Menu</span>
							</div>
							<nav class="inlinebox hideablenav">
								<ul class="Main-Menu">
									<li class="page-upcoming">
										<a href="<?php echo $root; ?>upcoming.<?php echo currentExtension(); ?>">Sign Up</a>
									</li>
									<li class="page-archives">
										<a href="<?php echo $root; ?>archives.<?php echo currentExtension(); ?>">Archives</a>
									</li>
									<li class="page-about">
										<a href="<?php echo $root; ?>about.<?php echo currentExtension(); ?>">About Us</a>
									</li>
									<li class="page-staff">
										<a href="<?php echo $root; ?>staff.<?php echo currentExtension(); ?>">Staff</a>
									</li>
									<li class="page-volunteer">
										<a href="<?php echo $root; ?>volunteer.<?php echo currentExtension(); ?>">Volunteer</a>
									</li>
									<li class="page-donate">
										<a href="<?php echo $root; ?>donate.<?php echo currentExtension(); ?>">Donate</a>
									</li>
									<!--
									<li>
										<a title="RSS Feed" href="<?php echo $root; ?>index.rss"><img style="margin-bottom:5px;" src="<?php echo $root; ?>img/RSS.png" width="26" height="26" alt="RSS" /></a>
									</li>
									-->
								</ul>
							</nav>
							<p class="inlinebox tyr-blurb">
								Creating a nurturing, innovative and stimulating theatrical experience as a means to enliven and inspire young people.
							</p>
						</div>
<?php if ($fullHeader)
{
?>
						<div class="slider-holder">
							<ul class="rslides">
<?php
foreach ($sliderRecords as $sliderRecord) {
?>
								<li>
<?php
	// Link image if no caption. Otherwise we will link caption.
	if (isset($sliderRecord['link']) && !isset($sliderRecord['caption'])) { echo '<a href="' . $sliderRecord['link'] . '">'; }
?>
								<img
									src="<?php echo $root; ?>shows/<?php echo htmlspecialchars($sliderRecord['filename']); ?>"
									alt="Tomorrow Youth Rep Banner image, from <?php echo htmlspecialchars($sliderRecord['title']); ?>, <?php echo htmlspecialchars($sliderRecord['year']); ?>"
									title="<?php echo htmlspecialchars($sliderRecord['title']); ?>, <?php echo htmlspecialchars($sliderRecord['year']); ?>" />
<?php
	if (isset($sliderRecord['link'])) { echo '</a>'; }

	if (isset($sliderRecord['caption'])) {
?>
									<p class="caption">
<?php
	if (isset($sliderRecord['link']) && isset($sliderRecord['caption'])) { echo '<a href="' . $sliderRecord['link'] . '">'; }
	echo htmlspecialchars($sliderRecord['title']); ?>, <?php echo htmlspecialchars($sliderRecord['year']);
	if (isset($sliderRecord['link']) && isset($sliderRecord['caption'])) { echo '</a>'; }
?>
									</p>
<?php
	}
?>								</li>
<?php
}
?>

<?php /*
		not sure why video isn't working any more. It's not gettting real dimensions.

								<li>
									<div class="video">
										<div class='youtube-container glowing'>

											<iframe src='http://www.youtube.com/embed/Txn4FK8_6YQ?showinfo=0&amp;rel=0' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
										</div>
									</div>
								</li>
*/ ?>

							</ul>
						</div>
						<div class="capped-width clearfix">
							<div class="inlinebox">
								<p>
									Our Vision:
	Tomorrow Youth Repertory strives for a truly community-centered experience— theater made for the community, by the community. We believe in the power of theater to transform our community and ourselves, to promote in all of us a freedom of creativity, confidence, teamwork, and patience.
								</p>
							</div>
						</div>
<?php
}
?>
					</header>
