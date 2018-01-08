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
$title='About Tomorrow Youth Rep';
$description='About Tomorrow Youth Repertory which runs several weekly theater production classes every fall and spring, at a variety of locations in Alameda, CA';
include('_head.php');
?>
	<style>

figure { position:relative; }
figcaption { font-size:60%; }
.thumbnail {
	width:76px;
	}

.person {
	font-variant:small-caps;
	font-weight:bold;
}
.title {
	font-style:italic;
	color:gray;
}

@media only screen and (min-width:36em)
{
	.rotated { width:100%; position:absolute; padding:2px 0; text-align:left; bottom:0; left:100%; -webkit-transform: rotate(-90deg); -webkit-transform-origin:1% 0%;}
}
@media only screen and (min-width:48em)
{
}

	</style>
</head>
<body id="page-about" class="orange-block">
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
						<section id="about" class="clearfix capped-width">
							<div class="inlinebox">
								<h2>About Tomorrow Youth Rep</h2>

								<p>
								Tomorrow Youth Repertory was started in the summer of 2011 when Jordan Best, Amy Marie Haven, and Tyler Null met to discuss joining forces to offer weekly youth theater classes and productions.  Operating for the first year as a sub-program of Alameda Children’s Musical Theater, and then becoming an independent non-profit in 2012, Tomorrow Youth Rep has been tireless in its pursuit of youth theater opportunities, offering multiple classes and camps to serve all experience levels, and serving hundreds of students.
								   Tomorrow Youth Repertory prides itself on its ability to offer a full theater experience for young actors, and for providing individual attention for every student — whether they have been acting and singing for ten years, or they’ve never been on stage before in their life.
								</p>
								<p>
									<img class="snapshot centered large-block" alt="Amy Marie with a big circle of kids at a rehearsal" src="<?php echo htmlspecialchars($root); ?>img/misc-big-circle.jpg" />
								</p>

							</div>
						</section>
						<section id="whatwedo" class="clearfix capped-width">
							<div class="inlinebox">
								<h3 style="clear:both">What We Do</h3>
								<p>
								 	<img style="-webkit-transform: rotate(3deg); transform: rotate(3deg);" class="snapshot floated opposite large-block" alt="rehearsing an action sequence in a Shrek production" src="<?php echo htmlspecialchars($root); ?>img/shrek-rehearsal-square.jpg" />
								  Tomorrow Youth Repertory currently runs several weekly theater production classes every fall and spring, at a variety of locations in Alameda, CA.  Many classes begin just as school lets out, and TYR is an excellent activity that keeps kids both entertained and challenged.  Most of our classes are associated with a production, and at the end of the class term (generally somewhere around 10-12 weeks) the kids get to perform their show for friends and family, with lights, sets, costumes, and the full magic of theater.
								</p>
								<p>
								 TYR also offers some more challenging ‘by-audition-only’ classes, as well as daily classes during the summer.
								</p>
								<p>
								  Plus, TYR offers theater tech classes, for those who want to learn the backstage arts!
								</p>
															<h3 style="clear:both">How We Do it</h3>
								<p>
									<img style="-webkit-transform: rotate(-3deg); transform: rotate(-3deg);" class="snapshot floated small-block" alt="Breakout session; 3 kids work on a scene" src="<?php echo htmlspecialchars($root); ?>img/misc-script-rehearsal.jpg" />
								   We believe very strongly in supplying every student with the challenges they need to grow, and the support to meet those challenges.  Unless the class is listed as “audition only”, every student enrolled in a TYR class is guaranteed a part, and we approach theater as a “team sport.”  We reject the idea of ‘stars’ and ‘supporting players’, and teach kids that to succeed at anything, you must support your peers, just as you’d wish for them to do for you.  Our staff and instructors work very hard to ensure that every student is given the opportunity to shine on stage, regardless of what role they are assigned, and that every student understands that they are all in this together.
								</p>
								<p>
									<img class="snapshot floated medium-block opposite" alt="Tyler getting kids ready to go on stage" src="<?php echo htmlspecialchars($root); ?>img/misc-tyler-conducting.jpg" />
									By partnering with some creative forces, such as TonyaMarie of <a href="http://gypsycatstudios.com/">Gypsy Cat Studios</a> and some dynamite parent and teen <a href="volunteer.<?php echo htmlspecialchars(currentExtension()); ?>">volunteers</a>, we are one of the few youth theater programs that is committed to providing a full theater experience for our students.  We don’t just help kids learn to act and sing, we want them to feel the true magic of the artform.  And for this reason we put great effort into the sets, costumes, and other elements of theater that make these shows come alive.  We believe we have some of the very best designers in the area, and we are so proud to be able to offer this level of quality to our students.
								</p>

								<p style="clear:all">
									TYR is a 501(c)(3) non-profit organization.  <a href="donate.<?php echo htmlspecialchars(currentExtension()); ?>">Donations</a> are tax-deductible. The current board of directors of TYR are:
								</p>
								<ul>
									<li>Howard Clowes</li>
									<li>Alisha Woo</li>
									<li>Amy Marie Haven</li>
									<li>Jordan Best</li>
									<li>Tyler Null</li>
									<li>Page Barnes</li>
									<li>Julia Bruce</li>
								</ul>
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


