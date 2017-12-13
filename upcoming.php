<?php
require_once('_functions.php');
require_once('_classes.php');
require_once('_globals.php');

include '_Markdown.php';
include '_MarkdownExtra.php';

// http://michelf.ca/projects/php-markdown/configuration/

$event = Event::getSpecifiedEvent(FALSE);		// want an upcoming event

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='';

$title = $event ? 'Tomorrow Youth Rep Upcoming: ' . $event->title() : 'Tomorrow Youth Rep Upcoming Shows and Events';
if ($event)
{
	$description='Find out about upcoming shows and events, like "' . $event->title() . ',"" put on by TYR in Alameda, CA';
}
else
{
	$description='Find out about upcoming shows and events put on by Tomorrow Youth Repertory in Alameda, California.';
}
include('_head.php');
?>
	<style>

.prefix, .suffix { color:#ddd;}
.info { margin-bottom:80px;}
ul { margin-bottom:1em;}

@media only screen and (min-width:36em) and (max-width:47.99em)
{
	.card, .info { width:50%; }
}

@media only screen and (min-width:48em)
{
	.card { width:33.33%;}
	.info { width:66.67%;}
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
<body id="page-upcoming">
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
include('_header.php'); ?>
					<main>
						<section class="clearfix capped-width pullbottom">
							<div class="inlinebox">
								<h2>Sign your kids up for TYR!</h2>
<p>
	Tomorrow Youth Repertory classes are a fantastic way for your children to learn new skills, and to build on their current abilities.  But just as importantly, they are a wonderful opportunity to make new friends, and to learn the value of team-work.  Tomorrow Youth Repertory classes emphasize community building, and teach young actors to appreciate that everyone around them is valuable and important.  We strive to create a welcoming environment in which boys and girls from differing backgrounds and levels of experience can come together and learn to interact positively — and have a lot of fun in the process!
</p>
<p>
	We have camps and classes year-round — ranging from acting and vocal classes to full-on productions.  We strive to be constantly providing opportunities for every experience level.  Take a look at what’s coming up:
</p>
<p>
	We offer need-based scholarships for all our programs.  Please see our <a href="#scholarship">Scholarship Policy</a> below.
</p>
<p>
	For questions about registration, please email <a href="programs@tomorrowyouthrep.org">programs@tomorrowyouthrep.org</a>.
</p>
							</div>
							<div class="inlinebox third down">
								<div class="bigger-right">
									<img style="-webkit-transform: rotate(3deg); transform: rotate(3deg);" class="snapshot fullwidth" alt="Amy Marie warms up students with a game of 'zip zap zop'" src="img/misc-warmup-game.jpg" />
								</div>
							</div>
							<div class="inlinebox third front">
								<img style="-webkit-transform: rotate(-2deg); transform: rotate(-2deg);" class="snapshot fullwidth" alt="Rob overwhelmed by boys during a break" src="img/misc-rob-and-boys.jpg" />
							</div>
							<div class="inlinebox third down">
								<div class="bigger-left">
									<img style="-webkit-transform: rotate(-10deg); transform: rotate(-10deg);" class="snapshot fullwidth" alt="having fun for the camera" src="img/misc-crazy-fun.jpg" />
								</div>
							</div>
							<div class="inlinebox nobottom"><h2>Upcoming TYR Events</h2></div>
							<div class="inlinebox">
<?php
foreach ($currentShows as $event)
{
	echo '<div class="clearfix outdented">' . PHP_EOL;
	echo '<div class="inlinebox card" id="THECARD_' . $event->id() . '">' . PHP_EOL;
	$event->outputEventCard(FALSE, FALSE);
	echo "</div>\n";
	echo '<div class="inlinebox info" id="THECARD_' . $event->id() . '_info">' . PHP_EOL;
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

	echo "</div>\n";
	echo "</div>\n";

}


foreach ($currentOther as $event)
{
	echo '<div class="clearfix outdented">' . PHP_EOL;
	echo '<div class="inlinebox card" id="THECARD_' . $event->id() . '">' . PHP_EOL;
	$event->outputEventCard(FALSE, FALSE);
	echo "</div>\n";
	echo '<div class="inlinebox info" id="THECARD_' . $event->id() . '_info">' . PHP_EOL;
	$event->outputEventCurrentBlurb();
	echo "</div>\n";
	echo "</div>\n";
}
?>

							</div>
						</section>
						<section class="clearfix capped-width pullbottom">
<h3 id="scholarship">Scholarship Policy</h3>
<p>
Tomorrow Youth Repertory offers limited need-based scholarships for all of our programs.  We believe that a child should not be excluded from participating in TYR due to financial hardship.  The Scholarship application can be obtained by emailing us at <a href="mailto:programs@tomorrowyouthrep.org">programs@tomorrowyouthrep.org</a>.  Please note that the completed scholarship application must be submitted prior to start of the first class/rehearsal or, in the case of our audition-only productions, at the time the performer accepts a role.
</p>
<p>
If you are interested in applying for a scholarship, we recommend that you register for your class online using the ACTIVE registration program first.  You should use the "SCHOLARSHIP" Coupon Code during check out.  You will be asked to submit a 10% deposit to hold your spot in the class.
</p>
<p>
If you have any questions, please contact <a href="mailto:programs@tomorrowyouthrep.org">programs@tomorrowyouthrep.org</a>.
</p>
							<div class="inlinebox" style="text-align:center; margin-top:20px;">
								Keep up with upcoming shows via <a href="http://www.facebook.com/TomorrowYouthRep">Facebook</a>&nbsp;
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FTomorrowYouthRep&amp;width=90&amp;height=21&amp;colorscheme=light&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px; margin-bottom:-6px" allowTransparency="true"></iframe>
								and our email&nbsp;newsletter:
								<form style="display:inline" action="http://tomorrowyouthrep.us7.list-manage.com/subscribe/post?u=7bb3cec11974d7013061a676a&amp;id=8a1e91d946" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
									<input placeholder="Your email address" style="width:11em" type="email" name="EMAIL" class="required email" id="mce-EMAIL">&nbsp;<input type="submit" value="Subscribe" id="mc-embedded-subscribe" class="button" />
								</form>
							</div>

							<div class="inlinebox third down front">
								<img style="-webkit-transform: rotate(5deg); transform: rotate(5deg);" class="snapshot fullwidth" alt="Staging a sequence from a musical number in Phantom Tollbooth" src="img/misc-staging.jpg" />
							</div>
							<div class="inlinebox third">
								<div class="bigger-left bigger-right">
									<img style="-webkit-transform: rotate(-2deg); transform: rotate(-2deg);" class="snapshot fullwidth" alt="Kids introducting themselves at the start of a class" src="img/misc-stand-up.jpg" />
								</div>
							</div>
							<div class="inlinebox third down front">
								<img style="-webkit-transform: rotate(8deg); transform: rotate(8deg);" class="snapshot fullwidth" alt="Tyler works the lights" src="img/misc-lights.jpg" />
							</div>

						</section>
					</main>
				</div><!-- end before-sticky-footer -->
			</div><!-- end clearfix -->
		</div><!-- end contain-sticky-footer -->
<?php include('_footer.php'); ?>
	</div>
<?php $includePinterest = TRUE; include('_body.end.php'); ?>
<script>
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

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

$(window).load(function() {
  var id = getParameterByName('id');
	if (id.length) $('html, body').animate({ scrollTop: $('#THECARD_' + id).offset().top }, 500);
});


	</script>
</body>
</html>
