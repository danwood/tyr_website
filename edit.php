<?php

require_once('_authenticate.php');
require_once('_prelude.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='';
$title='Tomorrow Youth Rep — Edit Event';
$description='';
include('_head.php');

$event = Event::getSpecifiedEvent(FALSE);
$reflector = null;
if ($event)
{
	$reflector = new ReflectionClass(get_class($event));
}

/* DON'T USE FULLCALENDAR FOR NOW

//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/fullcalendar.min.css
//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/fullcalendar.print.css

<link rel="stylesheet" href="<?php echo htmlspecialchars($root); ?>js/fullcalendar/fullcalendar.min.css" />
<link rel="stylesheet" href="<?php echo htmlspecialchars($root); ?>js/fullcalendar/fullcalendar.print.css" />
*/
?>
<link rel="stylesheet" href="<?php echo htmlspecialchars($root); ?>style/mdp.css" />
<link rel="stylesheet" href="<?php echo htmlspecialchars($root); ?>style/timepicki.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
textarea { width:100%;}
h4 { margin-top:1em; }

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



<div id="pre-select-dates" class="box"></div>



<?php

define('SIZE_TINY',     0);
define('SIZE_SMALL',     1);
define('SIZE_ONELINE',     2);
define('SIZE_MULTILINE',     3);
define('SIZE_GIANT',     4);

define('MARKDOWN_TRUE',  TRUE);
define('REQUIRED_TRUE',  TRUE);
define('SHORT_FALSE',    FALSE);
define('MARKDOWN_FALSE', FALSE);
define('REQUIRED_FALSE', FALSE);

/*



If this doesn't work out, I can go back and look at this list: http://www.hongkiat.com/blog/useful-calendar-date-picker-scripts-for-web-developers/


 */
function showEditor($sqlColumn, $sqlType, $displayName, $explain = '', $size = SIZE_ONELINE, $isMarkdown = MARKDOWN_FALSE, $isRequired = REQUIRED_FALSE) {

	global $event, $reflector;

	$class = null;
	$type = 'text';
	if ($sqlType == 'DATETIME') {
		$type = 'text';					// disable native display of date picker since we have our own custom picker
		$class='datepicker';
		$size = SIZE_TINY;
	}

	if (FALSE !== strpos(strtolower($sqlColumn), 'url')) $type = 'url';		// hack to enforce URL input

	// time but not date
	if (FALSE === strpos(strtolower($sqlColumn), 'date') && FALSE !== strpos(strtolower($sqlColumn), 'time')) {
		$type = 'time';
	}

	echo "<h4>" . htmlspecialchars($displayName) . "</h4>". PHP_EOL;
	if (!empty($explain)) echo "<p><i>" . htmlspecialchars($explain) . "</i></p>" . PHP_EOL;

	$height = 1;
	$width = 50;
	switch($size) {
		case SIZE_TINY:		$width = 12;	break;
		case SIZE_SMALL:	$width = 20;	break;
		case SIZE_ONELINE:	$width = 50;	break;
		case SIZE_MULTILINE:$height = 12;	break;
		case SIZE_GIANT:	$height = 20;	break;
	}
	if ($height == 1) {
		echo '<input type="' . $type . '" size="' . $width . '"';
		echo ' name="' . $sqlColumn . '"';
		if ($type == 'url') echo ' placeholder="http://..."';

		if ($event) {
			$prop = $reflector->getProperty($sqlColumn);
    		$value = $prop->isPrivate() ? $event->{$sqlColumn}() : $event->{$sqlColumn};
    		if ($sqlType == 'DATETIME') {
    			$value = ($value > 0) ? $value = date('n/j/y', $value) : '';
    		}
			echo ' value="' . htmlspecialchars($value) . '"';
		}
		if ($class) echo ' class="' . $class .'"';

		echo ' />'. PHP_EOL;
	}
	else {
		echo '<textarea rows="' . $height . '"';
		echo ' name="' . $sqlColumn . '"';
		echo '></textarea>'. PHP_EOL;
	}

	// special case - datetime.  Do a time input after a date.
	if (FALSE !== strpos(strtolower($sqlColumn), 'date') && FALSE !== strpos(strtolower($sqlColumn), 'time'))
	{
		echo '<input type="text" size="' . $width . '"';	// disable native time picker since we have custom picker
		echo ' name="' . $sqlColumn . '_time"';
		echo ' class="timePicker"';
		echo ' />'. PHP_EOL;
	}


}




showEditor('title', 'TEXT',                  'Title', '', SIZE_ONELINE, MARKDOWN_FALSE, REQUIRED_TRUE);
showEditor('suffix', 'TEXT',                 'Suffix', 'must be short!', SIZE_TINY);
showEditor('infoIfNoLogo', 'TEXT',           'Longer title', 'Shown only when no logo', SIZE_SMALL);
showEditor('descriptionBefore', 'TEXT',      'Recruiting description', 'General blurb used for recruiting show, on the recruitment page', SIZE_MULTILINE, MARKDOWN_TRUE);
//showEditor('logoFilename', 'TEXT',           'logoFilename'
//showEditor('photoFilename', 'TEXT',
showEditor('photoCredits', 'TEXT',           'Photo Credits', 'Who took the photos after the show/event', SIZE_ONELINE);
//showEditor('type', 'INTEGER',                'type'

showEditor('signupDetails', 'TEXT',          'Signup Details', 'Where classes are, audition preparations, what to expect, etc.', SIZE_MULTILINE, MARKDOWN_TRUE);

showEditor('whoCanGo', 'TEXT',               'Who Can Go', 'Age or grade range etc.', SIZE_TINY);
//showEditor('signupAttachment', 'TEXT',
showEditor('performanceInfo', 'TEXT',        'Performance Info', 'Details on when and where performances are', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('howTheShowWent', 'TEXT',         'howTheShowWent', 'After the show, some text to describe how it went. For people reading details about show from archives', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('castList', 'TEXT',               'castList', 'Fill this in to show who got cast.  Goes away after rehearsal start date', SIZE_MULTILINE, MARKDOWN_TRUE);
//showEditor('sharedCast', 'BOOLEAN',
showEditor('tuition', 'TEXT',                'Tuition', 'Human-readable dollar amount or amounts', SIZE_ONELINE);

showEditor('ticketURL', 'TEXT',              'ticketURL', 'URL at Brown Paper Tickets etc. if needed', SIZE_ONELINE);
showEditor('photoURL1', 'TEXT',              'photoURL1', 'URL of a photo album for a show, after the run is over', SIZE_ONELINE);
showEditor('photoURL2', 'TEXT',              'photoURL2', 'URL of any second photo album for a show, after the run is over', SIZE_ONELINE);
//showEditor('publicityAttachment', 'TEXT',    'publicityAttachment',
showEditor('auditionLocation', 'TEXT',       'auditionLocation', 'Where auditions will be held', SIZE_ONELINE);
showEditor('auditionPrepare', 'TEXT',        'auditionPrepare', 'What to prepare for auditions', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('classDays', 'TEXT',              'classDays', 'Days of the week the rehearsals/camp/classes are, or maybe specific dates', SIZE_ONELINE);
showEditor('startTime', 'TEXT',              'startTime', 'time, in human-readable format, that auditions/camp/classes start', SIZE_SMALL);
showEditor('endTime', 'TEXT',                'endTime', 'time, in human-readable format, that auditions/camp/classes end', SIZE_SMALL);



showEditor('announceDate', 'DATETIME',       'announceDate', 'We first want event to appear to the public. Before, hidden. On/After, visible in "later this year"');
showEditor('signupStartDate', 'DATETIME',    'signupStartDate', 'Announce and make signup possible (Or announce rehearsals). Before, "later this year". After, "coming soon"');
showEditor('auditionDateTime1', 'DATETIME',  'auditionDateTime1', 'If audition) date AND time of audition. Before, announce this (and second) dates. After, only second date');
showEditor('auditionDateTime2', 'DATETIME',  'auditionDateTime2', '(If a second audition) ""   -- After, "rehearsals starting soon" [Assume cast notified by email]');
showEditor('callbackDateTime', 'DATETIME',   'callbackDateTime', 'When callbacks are scheduled, just to help cast families schedule if they get called back [Assume cast notified by email]');
showEditor('signupEndDate', 'DATETIME',      'signupEndDate', 'Deadline for signups. (Before, "sign up soon" countdown. Afterward, "rehearsals starting soon")');
showEditor('rehearsalStartDate', 'DATETIME', 'rehearsalStartDate', 'Rehearsals underway. After, "rehearsals in progress", no action for this show.');
showEditor('ticketSaleDate', 'DATETIME',     'ticketSaleDate', 'Tickets now available.  If no tickets for sale, shows a countdown timer to first performance; click for cast details.');


// Convert showFirstDate, showLastDate into eventDateRange

showEditor('showFirstDate', 'DATETIME',      'showFirstDate', 'First performance (of any cast). Keep linking to ticket URL if available, otherwise show details. Use approximate date (1st of month)  when it’s in the distant future and date hasn’t been nailed down yet');
showEditor('showLastDate', 'DATETIME',       'showLastDate', 'Last performance [if applicable] Before this, show countdown to last performance. After this, show moves to past events & archives!');


?>





							</div>
						</section>
					</main>
				</div><!-- end before-sticky-footer -->
			</div><!-- end clearfix -->
		</div><!-- end contain-sticky-footer -->
<?php include('_footer.php'); ?>
	</div>
<?php $includePinterest = FALSE; include('_body.end.php'); ?>

<?php
/* DON'T USE FULLCALENDAR FOR NOW

<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>!window.jQuery && document.write('<script src="<?php echo htmlspecialchars($root); ?>js/moment.min.js"><\/script>')</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.1/fullcalendar.min.js"></script>
<script>!window.jQuery && document.write('<script src="<?php echo htmlspecialchars($root); ?>js/fullcalendar/fullcalendar.min.js"><\/script>')</script>

<script>

    $('#calendar').fullCalendar({
        // put your options and callbacks here
    })
</script>

*/
?>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script>window.jQuery.ui || document.write('<script src="<?php echo htmlspecialchars($root); ?>js/jquery-ui-1.12.1.js"><\/script>')</script>
<script src="<?php echo htmlspecialchars($root); ?>js/timepicki.js"></script>

<script>

var date = new Date();
$('.datepicker').datepicker({
	dateFormat: "m/d/y",

});

$('.timePicker').timepicki();

</script>

</body>
</html>


