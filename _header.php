					<header class="black-block">
						<div class="clearfix capped-width">
							<div class="inlinebox tyr-logo">
								<a class="page-home" href="./"><img class="fullwidth" style="max-width:458px;" src="<?php echo $root; ?>img/logo-transparent-white.png" alt="TYR Logo" /><span class="visuallyhidden">Tomorrow Youth Repertory</span></a>
							</div>
							<div id="header-navmenu" class="navmenu inlinebox icon-menu">
								<span class="visuallyhidden">Menu</span>
							</div>
							<nav class="inlinebox hideablenav">
								<ul class="Main-Menu">
									<li class="page-upcoming">
										<a href="<?php echo htmlspecialchars($root); ?>upcoming.html">Sign Up</a>
									</li>
									<li class="page-archives">
										<a href="<?php echo htmlspecialchars($root); ?>archives.html">Archives</a>
									</li>
									<li class="page-about">
										<a href="<?php echo htmlspecialchars($root); ?>about.html">About Us</a>
									</li>
									<li class="page-staff">
										<a href="<?php echo htmlspecialchars($root); ?>staff.html">Staff</a>
									</li>
									<li class="page-volunteer">
										<a href="<?php echo htmlspecialchars($root); ?>volunteer.html">Volunteer</a>
									</li>
									<li class="page-donate">
										<a href="<?php echo htmlspecialchars($root); ?>donate.html">Donate</a>
									</li>
									<li>
										<a title="RSS Feed" href="<?php echo htmlspecialchars($root); ?>index.rss"><img style="margin-bottom:5px;" src="<?php echo $root; ?>img/RSS.png" width="26" height="26" alt="RSS" /></a>
									</li>
								</ul>
							</nav>
							<p class="inlinebox tyr-blurb">
								Creating a nurturing, innovative and stimulating theatrical experience as a means to enliven and inspire young people.
							</p>
						</div>
<?php if ($fullHeader)
{
?>
						<div class="capped-width slider-holder position-container">
							<ul class="bxslider">
								<li><img src="/shows/slider/footloose1.jpg" alt="Tomorrow Youth Rep Banner image, from Footloose, 2012" title="Footloose, 2012" /></li>

<?php if ($now <= strtotime('2017-01-30T00:00:00-08:00')) { ?>
								<li><img src="/shows/slider/rumors_upcoming.jpg" alt="Neil Simon's Rumors" title="" /></li>
								<li><img src="/shows/slider/drood_upcoming.jpg" alt="The Mystery of Edwin Drood" title="" /></li>
<?php } ?>






							 	<li><img src="/shows/slider/fiddler.jpg" alt="Tomorrow Youth Rep Banner image, from Fiddler on the Roof, 2016" title="Fiddler on the Roof, 2016" /></li>
							 	<li><img src="/shows/slider/hsm2.jpg" alt="Tomorrow Youth Rep Banner image, from High School Musical, 2015" title="High School Musical, 2015" /></li>
							 	<li><img src="/shows/slider/annie3.jpg" alt="Tomorrow Youth Rep Banner image, from Annie, 2014" title="Annie, 2014" /></li>
							 	<li><img src="/shows/slider/beautybeast.jpg" alt="Tomorrow Youth Rep Banner image, from Beauty and the Beast, 2014" title="Beauty and the Beast, 2014" /></li>
							 	<li><img src="/shows/slider/narnia.jpg" alt="Tomorrow Youth Rep Banner image, from Narnia, 2013" title="Narnia, 2013" /></li>
							 	<li><img src="/shows/slider/annie2.jpg" alt="Tomorrow Youth Rep Banner image, from Annie, 2014" title="Annie, 2014" /></li>
							 	<li><img src="/shows/slider/lesmiserables.jpg" alt="Tomorrow Youth Rep Banner image, from Les Misérables, 2013" title="Les Misérables, 2013" /></li>
								<li><img src="/shows/slider/into_the_woods_2016.jpg" alt="Tomorrow Youth Rep Banner image, from Into The Woods, 2016" title="Into The Woods, 2016" /></li>
								<li><img src="/shows/slider/seussical.jpg" alt="Tomorrow Youth Rep Banner image, from Seussical, 2015" title="Seussical, 2015" /></li>
							 	<li><img src="/shows/slider/hsm1.jpg" alt="Tomorrow Youth Rep Banner image, from High School Musical, 2015" title="High School Musical, 2015" /></li>
							 	<li><img src="/shows/slider/alice.jpg" alt="Tomorrow Youth Rep Banner image, from Alice in Wonderland, 2015" title="Alice in Wonderland, 2015" /></li>
							 	<li><img src="/shows/slider/shrek2.jpg" alt="Tomorrow Youth Rep Banner image, from Shrek, 2014" title="Shrek, 2014" /></li>
							 	<li><img src="/shows/slider/oz.jpg" alt="Tomorrow Youth Rep Banner image, from Wizard of Oz, 2014" title="Wizard of Oz, 2014" /></li>
							 	<li><img src="/shows/slider/annie1.jpg" alt="Tomorrow Youth Rep Banner image, from Annie, 2014" title="Annie, 2014" /></li>
							 	<li><img src="/shows/slider/shrek1.jpg" alt="Tomorrow Youth Rep Banner image, from Shrek, 2014" title="Shrek, 2014" /></li>
							 	<li><img src="/shows/slider/footloose2.jpg" alt="Tomorrow Youth Rep Banner image, from Footloose, 2012" title="Footloose, 2012" /></li>
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
