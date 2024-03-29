<?php
require_once('_functions.php');
require_once('_classes.php');
require_once('_globals.php');
include('../_private.php'); // for variables
require_once('_Markdown.php');
require_once('_MarkdownExtra.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='';
$title='Tomorrow Youth Rep';
$description='Tomorrow Youth Rep is an educational theater program based in Alameda, CA, offering after-school classes and camps for youths of all experience levels.';
include('_head.php');
?>
	<meta name="google-site-verification" content="a-tUjFrfZNFa6UfCGWDxjrbf7Nx7VhvdMV7meeT7WV0" />
	<style id="inline-styles">
<?php include('index.inline-styles.css.php'); ?>
	</style>
	<style>


/* This element holds injected scripts inside iframes that in some cases may stretch layouts. So, we're just hiding it. */
#fb-root {
  display: none;
}

/* To fill the container and nothing else */
.fb_iframe_widget, .fb_iframe_widget span, .fb_iframe_widget span iframe[style] {
  width: 100% !important;
}

/* Default height */
.like-box { height:258px; }

.datepicker { display:none; }

/* ==========================================================================
   Breakpoints
   ========================================================================== */

@media only screen and (min-width:36em)
{
	.archive-intro  { width:85%;}
	.archive-button { width:15%; }
}

/* Different breakpoints for action */
@media only screen and (min-width:36em) and (max-width:63.99em)
{
	.action { width:50%;}
	.action:nth-child(odd) { clear:left; }
}

@media only screen and (min-width:48em)
{
	.trailer { width:66.66%; margin-left:16.67%; }
}

@media only screen and (min-width:64em)
{
	.action { width:218px;}
	.action.facebook-292 { width:322px; }
	.action h3 { min-height: 2.5em;}
	.like-box { height:350px; }

	.datepicker { z-index:999; display:block; position:absolute; top:0; left:0; width:20%; }	/* only show in full screen for your convenience */
}


@media only screen and (min-width:36em)
{
	.third { width:33.33%; }
	.twothirds { width:66.66%; }
	.half { width:50%; }
}


/*! http://responsiveslides.com v1.55 by @viljamis */

.rslides {
  position: relative;
  list-style: none;
  overflow: hidden;
  width: 100%;
  padding: 0;
  margin: 0;
  }

.rslides li {
  -webkit-backface-visibility: hidden;
  position: absolute;
  display: none;
  width: 100%;
  left: 0;
  top: 0;
  }

.rslides li:first-child {
  position: relative;
  display: block;
  float: left;
  }

.rslides img {
  display: block;
  height: auto;
  float: left;
  width: 100%;
  border: 0;
  }

.caption {
  position: absolute;
  display: block;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 5px 15px;
  text-align: left;
  background: rgba(0, 0, 0, 0.25);
  background: linear-gradient(to right, rgba(0, 0, 0, 0.25) 0%, transparent 50%, transparent 100%);
  color: #fff;
  font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
  display: block;
  font-size: .85em;
}


	</style>
</head>
<body id="page-home">
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
								<input id="date-input" type="date" name="when" value="<?php if (isset($_GET['when']) & !empty($_GET['when'])) { echo $_GET['when']; } else { echo date('Y-m-d'); } ?>" />
								<!-- <input type="submit" value="Reload for this date" /> -->
							</form>
						</div>
<?php
}
$fullHeader = TRUE;
include('_header.php'); ?>
					<main>
<?php
if (isset($special_message_md) && !empty($special_message_md)) {
?>
						<div class="orange-block">
							<section id="actions" class="clearfix capped-width pullbottom">
								<div class="inlinebox nobottom">
									<?php
										$html = Markdown::defaultTransform($special_message_md);
										echo $html;
									?>
								</div>
							</section>
						</div>
<?php
}
?>
<?php include('_index.main.php'); ?>
						<div class="gray-block">
							<section id="actions" class="clearfix capped-width pullbottom">
								<div class="inlinebox nobottom"><h2>Extra Thanks to our Sponsors</h2></div>
								<div> <!-- similar elements together, for nth-child -->

									<div class="inlinebox half">
										<a href="https://www.denhardtproductions.com/"><img style="max-width:100%; padding:20px; background:white" src="img/denhardt.png" alt="Denhardt Productions" /></a>
									</div>
									<div class="inlinebox half">
										<a href="https://www.fruitvaleoptometry.com/"><img style="max-width:100%; padding:20px; background:white" src="img/fruitvale-optometry.png" alt="Fruitvale Optometry - Doctor de los ojos" /></a>
									</div>
									
								</div>
							</section>
						</div>
						<div class="white-block">
							<section id="actions" class="clearfix capped-width pullbottom">
								<div class="inlinebox nobottom"><h2>Get Involved with TYR</h2></div>
									<div> <!-- similar elements together, for nth-child -->
										<div class="inlinebox action">
											<h3>Sign up for shows!</h3>
											<p>
												How and why to sign your kids for upcoming TYR productions. Get the details about upcoming productions here.
											</p>
											<p><a class="button" href="upcoming.<?php echo currentExtension(); ?>">Learn More</a></p>
										</div>
										<div class="inlinebox action">
											<h3>Volunteers Needed</h3>
											<p>
												Our shows are awesome… and part of that is thanks to awesome parent volunteers, helping behind the scenes (or behind the stage). Find out how you can get involved too.
											</p>
											<p><a class="button" href="volunteer.<?php echo currentExtension(); ?>">Learn More</a></p>
										</div>
										<div class="inlinebox action">
											<h3>Donate</h3>
											<p>
												As a non-profit organization, TYR relies on the generosity of donations to keep its programs going and tuition costs reasonable. Your tax-deductible donation, even a small amount, can make a lot of difference.
											</p>
											<p><a class="button" href="donate.<?php echo currentExtension(); ?>">Learn More</a></p>
										</div>
										<div class="inlinebox action facebook-292">
											<h3>TYR on Facebook</h3>
												<iframe class="like-box" src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FTomorrowYouthRep&amp;width=292&amp;height=500&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%;" allowTransparency="true"></iframe>
										</div>
								</div>
							</section>
						</div>
					</main>
				</div><!-- end before-sticky-footer -->
			</div><!-- end clearfix -->
		</div><!-- end contain-sticky-footer -->
<?php include('_footer.php'); ?>
	</div>
<?php $includePinterest = TRUE; include('_body.end.php'); ?>
	<script>
var resizeTimeout;
function resizedw(){
	// Run script to equalize headline/white-box heights, by adjusting only boxes with position:relative as set from media query.
	var maxHeight = 0;
	$('.equalize-show').each(function(){
			$(this).height( 'auto' );	// First set the height to auto to determine its natural height
			maxHeight = Math.max(maxHeight,$(this).height());	// Then calculate the largest height so far
		})
		.each(function(){
			// Then for elements that we want to actually equalize, set to largest height.
			if ('always' === $(this).css('page-break-before')	// Look for invisible attribute that is set by media queries
				&& !$(this).hasClass('photo-card'))
			{
				$(this).height(maxHeight);
			}
		});

	maxHeight = 0;
	$('.equalize-other').each(function(){
			$(this).height( 'auto' );	// First set the height to auto to determine its natural height
			maxHeight = Math.max(maxHeight,$(this).height());	// Then calculate the largest height so far
		})
		.each(function(){
			// Then for elements that we want to actually equalize, set to largest height.
			if ('always' === $(this).css('page-break-before')	// Look for invisible attribute that is set by media queries
				&& !$(this).hasClass('photo-card'))
			{
				$(this).height(maxHeight);
			}
		});

	maxHeight = 0;
	$('.equalize-later').each(function(){
			$(this).height( 'auto' );	// First set the height to auto to determine its natural height
			maxHeight = Math.max(maxHeight,$(this).height());	// Then calculate the largest height so far
		})
		.each(function(){
			// Then for elements that we want to actually equalize, set to largest height.
			if ('always' === $(this).css('page-break-before')	// Look for invisible attribute that is set by media queries
				&& !$(this).hasClass('photo-card'))
			{
				$(this).height(maxHeight);
			}
		});
}

$('#date-input').change(function(event)
 {
  	var s = $(this).val();
    console.log( s );
	var bits = s.split('-');
	console.log(bits);
	var d = new Date(bits[0], bits[1] - 1, bits[2]);
	console.log(d);
	var valid = d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[2]) && d.getFullYear() > 2010 ;
	if (!valid)
	{
		console.log('Not valid: ' + s + ' Year: ' + d.getFullYear() );
	}
	else
	{
		// Send off for some Ajax fun
		console.log('Requesting new content for ' + d);

		$.ajax({
		    type: 'get',
		    url: 'index.ajax.php',
		    data: 'when=' + s,
		    success: function(html) {
				// HTML is both the styles, and the main stuff.  Use the comment at the start of main to know where to split, then populate appropriately.
				var pieces = html.split('<!-- contents of <main> : Do not disturb this comment -->');
				var newCSS = pieces[0];
				var newMain = pieces[1];
				$('#inline-styles').html(newCSS);
				$('main').html(newMain);
				$('header').html('')	// get rid of header just so we can focus on content
				$('#vision').html('')	// get rid of header just so we can focus on content
				$('#about-us').html('')	// get rid of header just so we can focus on content
				resizedw();
			}
		});
	}
});

	</script>
	<script src="<?php echo $root; ?>js/responsiveslides.min.js"></script>
	<script>


$(window).load(function() { resizedw(); });

$(".rslides").responsiveSlides({
  auto: true,             // Boolean: Animate automatically, true or false
  speed: 500,            // Integer: Speed of the transition, in milliseconds
  timeout: 4000,          // Integer: Time between slide transitions, in milliseconds
  pager: false,           // Boolean: Show pager, true or false
  nav: false,             // Boolean: Show navigation, true or false
  random: true,          // Boolean: Randomize the order of the slides, true or false
  pause: true,           // Boolean: Pause on hover, true or false
  pauseControls: true,    // Boolean: Pause when hovering controls, true or false
  prevText: "Previous",   // String: Text for the "previous" button
  nextText: "Next",       // String: Text for the "next" button
  maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
  navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
  manualControls: "",     // Selector: Declare custom pager navigation
  namespace: "rslides",   // String: Change the default namespace used
  before: function(){},   // Function: Before callback
  after: function(){}     // Function: After callback
});


	</script>
</body>
</html>
