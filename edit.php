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
<link rel="stylesheet" href="<?php echo htmlspecialchars($root); ?>style/timepicki.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/style/font-awesome.min.css">

<style>
textarea { width:100%;}
h3, h4 { margin-top:1em; }
h3 { color:#666;}
.dates_table { width:100%; }
.dates_table th, .dates_table td { padding:15px; }
.date_title { font-weight:bold;}
.date_input > input { width:7em}
.date_explain { font-style:italic;}

.editable {
	background-color:white;
	border:1px solid gray;
	padding:0.5em;
	width:100%;
	resize:both; /* doesn't work???? */
}
.source {
	background:pink;
	width:100%;
    display: block;
    unicode-bidi: embed;
    font-family: monospace;
    white-space: pre-wrap;
    display:none;
}

</style>
<script src="/js/showdown.js"></script>
<!-- jquery early so we can build up web form contents as we load page -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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

<?php
if (isset($_GET['created'])) {
	echo "<p><b style='color:green'>New event has been created. You can fill in more information now.</b></p>";
} else if (isset($_GET['saved'])) {
	echo "<p><b style='color:orange'>Updates have been saved.</b></p>";
}

?>

<div id="pre-select-dates" class="box"></div>

<p>
	<!-- Be sure to SAVE your edits at the bottom of this page. -->
	<span style="color:red;"><b>This is not a fully functioning editor; nothing is saved!</b></span>
</p>

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
function showEditor($sqlColumn, $sqlType, $displayName, $explain = '', $size = SIZE_ONELINE, $isMarkdown = MARKDOWN_FALSE, $isRequired = REQUIRED_FALSE)
{

	global $event, $reflector;

	$class = null;
	$type = 'text';
	if ($sqlType == 'DATETIME') {
		$type = 'text';					// disable native display of date picker since we have our own custom picker
		$class='datepicker';
		$size = SIZE_TINY;

		echo '<tr>';
	}

	if (FALSE !== strpos(strtolower($sqlColumn), 'url')) $type = 'url';		// hack to enforce URL input

	// time but not date
	if (FALSE === strpos(strtolower($sqlColumn), 'date') && FALSE !== strpos(strtolower($sqlColumn), 'time')) {
		$type = 'time';
	}

	if ($sqlType == 'DATETIME') {
		echo '<td class="date_title">' . htmlspecialchars($displayName) . "</td>". PHP_EOL;
		echo '<td class="date_input">';	// prepare for input below
	} else {
		echo "<h4>" . htmlspecialchars($displayName) . "</h4>". PHP_EOL;
		if (!empty($explain)) echo "<p><i>" . htmlspecialchars($explain) . "</i></p>" . PHP_EOL;
	}

	$height = 1;
	$width = 50;
	switch($size) {
		case SIZE_TINY:		$width = 12;	break;
		case SIZE_SMALL:	$width = 20;	break;
		case SIZE_ONELINE:	$width = 50;	break;
		case SIZE_MULTILINE:$height = 12;	break;
		case SIZE_GIANT:	$height = 20;	break;
	}

	$value = NULL;
	$timeValue = NULL;		// fill in just in case
	if ($event) {
		$prop = $reflector->getProperty($sqlColumn);
		$value = $prop->isPrivate() ? $event->{$sqlColumn}() : $event->{$sqlColumn};
		if ($sqlType == 'DATETIME') {
			$timeValue = ($value > 0) ? date('h:i A', $value) : '';
			if ($timeValue == '12:00 AM') $timeValue = '';
			$value = ($value > 0) ? date('n/j/y', $value) : '';
		}
	}

	if ($height == 1) {
		echo '<input type="' . $type . '" size="' . $width . '"';
		echo ' name="' . $sqlColumn . '"';
		if ($type == 'url') echo ' placeholder="http://..."';

		if ($event) {
			echo ' value="' . htmlspecialchars($value) . '"';
		}
		if ($class) echo ' class="' . $class .'"';

		echo ' />'. PHP_EOL;
	}
	else {
		if ($isMarkdown) {

	echo '<textarea class="source" name="' . $sqlColumn . '" id="' . $sqlColumn . '_markdown">' . htmlspecialchars( $event ? $value : 'NONE') . '</textarea>';
			echo '<div class="editable"';
			echo ' id="' . $sqlColumn . '_html"';
			echo 'style="min-height:'.$height.'em;"';
			echo '>'. PHP_EOL;
			echo '</div>'. PHP_EOL;
			if ($event) {
?>
<script>
var converter = new Showdown.converter();
var content = <?php echo json_encode($value); ?>;
var contentHTML = converter.makeHtml(content);
$('#<?php echo htmlspecialchars($sqlColumn); ?>_html').html(contentHTML);
</script>
<?php
			}

		} else {

			echo '<textarea rows="' . $height . '"';
			echo ' name="' . $sqlColumn . '"';
			echo '>' . PHP_EOL;
			if ($event) echo htmlspecialchars($value);
			echo '</textarea>'. PHP_EOL;

		}
	}

	// special case - date AND time.  Do a time input after a date.
	// For submission, we have to recombine!
	if (FALSE !== strpos(strtolower($sqlColumn), 'date') && FALSE !== strpos(strtolower($sqlColumn), 'time'))
	{
		echo '<input type="text" size="' . $width . '"';	// disable native time picker since we have custom picker
		echo ' name="' . $sqlColumn . '_time"';
		echo ' value="' . $timeValue . '"';
		echo ' class="timePicker"';
		echo ' />'. PHP_EOL;
	}

	if ($sqlType == 'DATETIME') {
		echo "</td>". PHP_EOL;
		if (!empty($explain)) echo '<td class="date_explain">' . htmlspecialchars($explain) . "</td>". PHP_EOL;
	}

}
?>

<form id="mainform" action="save.php" method="POST">
<h3>General</h3>
<?php
showEditor('title', 'TEXT',                  'Title', '', SIZE_ONELINE, MARKDOWN_FALSE, REQUIRED_TRUE);
showEditor('suffix', 'TEXT',                 'Suffix', 'must be short!', SIZE_TINY);
showEditor('infoIfNoLogo', 'TEXT',           'Short Blurb', 'Shown only when no logo', SIZE_ONELINE);

if ($event) {

echo '<h3>Recruitment</h3>' . PHP_EOL;

showEditor('descriptionBefore', 'TEXT',      'Recruiting description', 'General blurb used for recruiting show, on the recruitment page', SIZE_MULTILINE, MARKDOWN_TRUE);
//showEditor('logoFilename', 'TEXT',           'logoFilename'
//showEditor('type', 'INTEGER',                'type'

showEditor('signupDetails', 'TEXT',          'Signup details', 'Where classes are, audition preparations, what to expect, etc.', SIZE_MULTILINE, MARKDOWN_TRUE);

showEditor('whoCanGo', 'TEXT',               'Who can go', 'Age or grade range etc.', SIZE_TINY);
//showEditor('signupAttachment', 'TEXT',
showEditor('performanceInfo', 'TEXT',        'Performance Info', 'Details on when and where performances are', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('castList', 'TEXT',               'Cast list', 'Fill this in to show who got cast.  Goes away after rehearsal start date', SIZE_MULTILINE, MARKDOWN_TRUE);
//showEditor('sharedCast', 'BOOLEAN',
showEditor('tuition', 'TEXT',                'Tuition', 'Human-readable dollar amount or amounts', SIZE_ONELINE);

showEditor('auditionLocation', 'TEXT',       'Audition location', 'Where auditions will be held', SIZE_ONELINE);
showEditor('auditionPrepare', 'TEXT',        'Audition preparation', 'What to prepare for auditions', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('classDays', 'TEXT',              'Class days', 'Days of the week the rehearsals/camp/classes are, or maybe specific dates', SIZE_ONELINE);
showEditor('startTime', 'TEXT',              'Start time', 'time, in human-readable format, that auditions/camp/classes start', SIZE_SMALL);
showEditor('endTime', 'TEXT',                'End time', 'time, in human-readable format, that auditions/camp/classes end', SIZE_SMALL);

echo '<h3>Publicity</h3>' . PHP_EOL;

showEditor('ticketURL', 'TEXT',              'Ticket URL', 'URL at Brown Paper Tickets etc. if needed', SIZE_ONELINE);
//showEditor('publicityAttachment', 'TEXT',    'publicityAttachment',


echo '<h3>Archives</h3>' . PHP_EOL;
showEditor('howTheShowWent', 'TEXT',         'How the show went', 'After the show, some text to describe how it went. For people reading details about show from archives', SIZE_MULTILINE, MARKDOWN_TRUE);
//showEditor('photoFilename', 'TEXT',
showEditor('photoCredits', 'TEXT',           'Photo credits', 'Who took the photos after the show/event', SIZE_ONELINE);
showEditor('photoURL1', 'TEXT',              'Photo URL #1', 'URL of a photo album for a show, after the run is over', SIZE_ONELINE);
showEditor('photoURL2', 'TEXT',              'Photo URL #2', 'URL of any second photo album for a show, after the run is over', SIZE_ONELINE);



?>
<h4>Dates</h4>
<table class="dates_table">
<?php

// Note that DATETIME editors show up as rows in a table.

showEditor('announceDate', 'DATETIME',       'Announcement', 'We first want event to appear to the public. Before, hidden. On/After, visible in "later this year"');
showEditor('signupStartDate', 'DATETIME',    'Signup start', 'Announce and make signup possible (Or announce rehearsals). Before, "later this year". After, "coming soon"');
showEditor('auditionDateTime1', 'DATETIME',  'Audition #1', 'Date AND time of audition.');
showEditor('auditionDateTime2', 'DATETIME',  'Audition #2', '(If a second audition)');
showEditor('callbackDateTime', 'DATETIME',   'Callback', 'When callbacks are scheduled, just to help cast families schedule if they get called back');
showEditor('signupEndDate', 'DATETIME',      'Signup last date', 'Deadline for signups.');
showEditor('rehearsalStartDate', 'DATETIME', 'Rehearsal start', 'Rehearsals underway.');
showEditor('ticketSaleDate', 'DATETIME',     'Ticket sale date', 'Tickets now available.  If no tickets for sale, shows a countdown timer to first performance; click for cast details.');

?>
<input type="hidden" name="id" value="<?php echo htmlspecialchars($event->id()); ?>" />
<?php
}
else
{
	echo '<hr /><p>…you can fill in most of the details about this event once it has been initially created…</p><hr />' . PHP_EOL;
}

showEditor('showFirstDate', 'DATETIME',      'Opening/Event date', 'First performance (of any cast). Keep linking to ticket URL if available, otherwise show details. Use approximate date (1st of month)  when it’s in the distant future and date hasn’t been nailed down yet');
showEditor('showLastDate', 'DATETIME',       'Closing/Final date', 'Last performance [if applicable]');
?>
</table>

<p>
	<input type="submit" name="submit" value="<?php if ($event) echo 'Update Event'; else echo 'Create Event'; ?>" />
</p>
</form>


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
<script src="https://cdnjs.cloudflare.com/ajax/libs/rangy/1.3.0/rangy-core.js"></script>
<script src="/js/hallo.js"></script>
<script src="/js/to-markdown.js"></script>
<script src="<?php echo htmlspecialchars($root); ?>js/timepicki.js"></script>

<script>

var date = new Date();
$('.datepicker').datepicker({
	dateFormat: "m/d/y",

});

$('.timePicker').timepicki({step_size_minutes:15, reset: true});

$('.editable').hallo({
	plugins: {
	    'halloformat': {},
	    'halloheadings': {
	        'formatBlocks': ['h4', 'h5']
	    },
	    'hallolists': {
	        "lists": {
	            "ordered": true,
	            "unordered": true,
	        }
	    },
	    'hallojustify': {},
	    'halloreundo': {},
	    'hallolink': {},
 	},
    toolbar: 'halloToolbarFixed'
});

/* USE THIS IF WE DECIDE ON AJAX UPDATING ....

$('.editable').on('hallomodified', function(event, data) {
    alert("New contents are " + data.content + ' ' + event.target);
});

*/

// Adapted from Hallo demo page

var markdownize = function(content) {
var html = content.split("\n").map($.trim).filter(function(line) {
  return line != "";
}).join("\n");
return toMarkdown(html);
};




$( "#mainform" ).submit(function( event ) {

$("input[name*=_time]").each(function(){

	var time = $(this).val();
	if (time != '') {
	    var inputname = ($(this).attr("name"));
	    inputname = inputname.slice(0, -5);

	   	var date = $("input[name="+ inputname + "]").val();

		$("input[name="+ inputname + "]").val(date + " " + time);
	}
});

$(".editable").each(function(){
	var html = $(this).html();
	var markdown = markdownize(html);
	var htmlID = $(this).attr("id");
	var markdownID = htmlID.replace("_html", "_markdown");
	$('#' + markdownID).text(markdown);
});


// let submission go through
});



</script>


</body>
</html>


