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
?>
<link rel="stylesheet" href="<?php echo htmlspecialchars($root); ?>style/timepicki.css" />
<link rel="stylesheet" href="<?php echo htmlspecialchars($root); ?>style/jquery-ui.min.css">
<link rel="stylesheet" href="<?php echo htmlspecialchars($root); ?>style/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo htmlspecialchars($root); ?>wymeditor/skins/seamless/skin.css">


<style>
#mainform { width:842px;} /* Try to match the wymeditor stuff */
.wym_area_main { background-color:white;}
.wym_skin_seamless .wym_dropdown h2 { line-height:1.0; margin-bottom:0 !important;}
textarea { width:100%; min-height:150px;}
h3, h4 { margin-top:1em; }
h3 { color:#000; background-color:#F88; padding:0.3em 0.2em;}
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
}
.source {
	background:pink;
	width:100%;
    unicode-bidi: embed;
    font-family: monospace;
    white-space: pre-wrap;
    display: none;
}
a.wym_wymeditor_link { display:none !important;}
.wym_classes { display:none !important;}
iframe.uploader { width:100%; height:100px; }
.extension { color:purple;}

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

$editorInitializationScript = '';	// We will add to this script every time we show an editor.

function showEditor($sqlColumn, $sqlType, $displayName, $explain = '', $size = SIZE_ONELINE, $isMarkdown = MARKDOWN_FALSE, $isRequired = REQUIRED_FALSE)
{

	global $event, $reflector, $editorInitializationScript;

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
	$timeValue = '';		// fill in just in case
	$hourValue = $miniValue = $meriValue = NULL;

	if ($event) {
		$prop = $reflector->getProperty($sqlColumn);
		$value = $prop->isPrivate() ? $event->{$sqlColumn}() : $event->{$sqlColumn};
		if ($sqlType == 'DATETIME') {
			if ($value  >0) {
				$timeValue = date('h:i A', $value);
				$hourValue = date('h', $value);
				$miniValue = date('i', $value);
				$meriValue = date('A', $value);
			}
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

			// Source markdown, normally hidden
			echo '<textarea class="source" name="' . $sqlColumn . '" id="' . $sqlColumn . '_markdown">' . htmlspecialchars( $event ? $value : 'NONE') . '</textarea>' . PHP_EOL;

			// Editor
			echo '<div class="wymeditor_container"';
			echo ' id="' . $sqlColumn . '_container"';
			echo '>'. PHP_EOL;
			if ($event) {

				// Some script to append to end of file later
				// Wrap the output in the textarea since jquery escapes html tags in textarea
				ob_start();
				if ($value) {
?>
content = <?php echo json_encode($value); ?>;
contentHTML = converter.makeHtml(content);
<?php
				}
?>
contentHTML = '<textarea class="wymeditor" id="<?php echo htmlspecialchars($sqlColumn); ?>_html">'
<?php
if ($value) {
?>
	+ contentHTML
<?php
}
?>
	+ '</textarea>';
$('#<?php echo htmlspecialchars($sqlColumn); ?>_container').html(contentHTML);
<?php
				$editorInitializationScript .= ob_get_clean();
			}
			echo '</div>'. PHP_EOL;

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

// Crazy way we have to initialize the time picker by data attributes instead of it just parsing the value
// of the input!
		if (!empty($hourValue)) {
			echo  ' data-timepicki-tim="' . $hourValue  . '"';
			echo ' data-timepicki-mini="' . $miniValue  . '"';
			echo ' data-timepicki-meri="' . $meriValue  . '"';
		}

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
showEditor('prefix', 'TEXT',                 'Prefix', 'e.g. "William Shakespeare’s"', SIZE_TINY);
showEditor('title', 'TEXT',                  'Title', '', SIZE_ONELINE, MARKDOWN_FALSE, REQUIRED_TRUE);
showEditor('suffix', 'TEXT',                 'Suffix', 'must be short!', SIZE_TINY);
showEditor('infoIfNoLogo', 'TEXT',           'Short Blurb', 'Shown only when no logo', SIZE_ONELINE);

if ($event) {

echo '<h3>General Information</h3>' . PHP_EOL;

showEditor('storyOverview', 'TEXT',      	 'Plot overview', 'Teaser plot of story', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('venue', 'TEXT',                  'Venue', 'Theatre etc. of performances', SIZE_ONELINE, MARKDOWN_FALSE, REQUIRED_TRUE);
showEditor('venueAddress', 'TEXT',            'Address of venue', 'Address of venue, for publicizing event', SIZE_ONELINE, MARKDOWN_FALSE, REQUIRED_TRUE);
showEditor('credits', 'TEXT',      	 		 'Credits', 'Director, book, special arrangements etc.', SIZE_MULTILINE, MARKDOWN_TRUE);

echo '<h3>Recruitment</h3>' . PHP_EOL;

showEditor('descriptionBefore', 'TEXT',      'Recruiting description', 'General blurb used for recruiting show. GOES AWAY after signups are done', SIZE_MULTILINE, MARKDOWN_TRUE);
?>
<h4>Logo File</h4>
<p>File should be about 3:2 aspect ratio like an old TV, 544 pixels wide (or wider).  Please have a simple web-friendly name (letters and numbers, no spaces). Can be <span class="extension">.jpg</span> or <span class="extension">.png</span> file.
</p>
<iframe class="uploader" src="edit_uploader.php?id=<?php echo htmlspecialchars($event->id()); ?>&amp;year=<?php echo htmlspecialchars(date('Y', $event->showFirstDate)); ?>&amp;type=logo&amp;property=logoFilename"></iframe>
<h4>Type of Event</h4>
<select name="type">
	<option value="0">-- PLEASE CHOOSE --</option>
	<option value="1" <?php if ($event->type == 1) { echo 'selected '; } ?>>Event: Announce Only (not in archives)</option>
	<option value="2" <?php if ($event->type == 2) { echo 'selected '; } ?>>Event to archive</option>
	<option value="3" <?php if ($event->type == 3) { echo 'selected '; } ?>>Audition Show</option>
	<option value="4" <?php if ($event->type == 4) { echo 'selected '; } ?>>Class Show</option>
	<option value="5" <?php if ($event->type == 5) { echo 'selected '; } ?>>Backstage Camp</option>
</select>

<?php

//showEditor('type', 'INTEGER',                'type'

showEditor('signupDetails', 'TEXT',          'Signup details', 'Where classes are, audition preparations, what to expect, etc.', SIZE_MULTILINE, MARKDOWN_TRUE);

showEditor('whoCanGo', 'TEXT',               'Who can go', 'Age or grade range etc.', SIZE_TINY);

?>
<h4>Signup Attachment</h4>
<p>Something that parents can download to help them sign their kids up. Please have a simple web-friendly name (letters and numbers, no spaces). Can be <span class="extension">.jpg</span>, <span class="extension">.png</span>, <span class="extension">.pdf</span>, or <span class="extension">.mp3</span> file.
</p>
<iframe class="uploader" src="edit_uploader.php?id=<?php echo htmlspecialchars($event->id()); ?>&amp;year=<?php echo htmlspecialchars(date('Y', $event->showFirstDate)); ?>&amp;type=signup&amp;property=signupAttachment"></iframe>
<?php

showEditor('performanceInfo', 'TEXT',        'Performance Info', 'Details on when and where performances are', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('castList', 'TEXT',               'Cast list', 'Fill this in to show who got cast.  Goes away after rehearsal start date', SIZE_MULTILINE, MARKDOWN_TRUE);
//showEditor('sharedCast', 'BOOLEAN',
showEditor('tuition', 'TEXT',                'Tuition', 'Human-readable dollar amount or amounts', SIZE_ONELINE);

showEditor('auditionLocation', 'TEXT',       'Audition location', 'Where auditions will be held', SIZE_ONELINE);
showEditor('auditionPrepare', 'TEXT',        'Audition preparation', 'What to prepare for auditions', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('classDays', 'TEXT',              'Class days', 'Days of the week the rehearsals/camp/classes are, or maybe specific dates', SIZE_ONELINE);
showEditor('startTime', 'TEXT',              'Start time', 'time, in human-readable format, that auditions/camp/classes start', SIZE_SMALL);
showEditor('endTime', 'TEXT',                'End time', 'time, in human-readable format, that auditions/camp/classes end', SIZE_SMALL);

showEditor('rehearsalInfo', 'TEXT',          'Rehearsal info', 'Info about rehearsals visible during recruitment and rehearsals', SIZE_MULTILINE, MARKDOWN_TRUE);


echo '<h3>Publicity</h3>' . PHP_EOL;

showEditor('ticketURL', 'TEXT',              'Ticket URL', 'URL at Brown Paper Tickets etc. if needed', SIZE_ONELINE);
?>
<h4>Publicity Attachment</h4>
<p>Usually a poster that people can print out and display or email. Please have a simple web-friendly name (letters and numbers, no spaces). Can be <span class="extension">.jpg</span> or <span class="extension">.png</span> or <span class="extension">.pdf</span> file.
</p>
<iframe class="uploader" src="edit_uploader.php?id=<?php echo htmlspecialchars($event->id()); ?>&amp;year=<?php echo htmlspecialchars(date('Y', $event->showFirstDate)); ?>&amp;type=poster&amp;property=publicityAttachment"></iframe>
<?php

echo '<h3>Archives</h3>' . PHP_EOL;
showEditor('howTheShowWent', 'TEXT',         'How the show went', 'After the show, some text to describe how it went. For people reading details about show from archives', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('directorQuote', 'TEXT',         'Director’s Notes', 'Quote from director in the first person', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('photoCredits', 'TEXT',           'Photo credits', 'Who took the photos after the show/event', SIZE_ONELINE);
showEditor('photoURLs', 'TEXT',              'Photo URLs', 'URLs of a photo album for a show, after the run is over. One per line. Can be followed by a space and link text', SIZE_MULTILINE);
showEditor('videoURLs', 'TEXT',              'Video URLs', 'URLs of videos for the show', SIZE_MULTILINE);



?>

<h4>Show Photos</h4>
<div style="font-size:80%">

<p>Please provide <b>up to 20</b> (at a time) <span class="extension">.jpg</span> images at a time.  Make sure the files are good web-friendly, unique names. The file names should have sequential numbers 1, 2, 3, 4 before the "<span class="extension">.jpg</span>" extension.
E.g. <i>narnia1.jpg</i>, <i>narnia2.jpg</i>, <i>narnia3.jpg</i>, <i>narnia4.jpg</i>.
These files can be chosen all at once in the file chooser.
The images will be resized (and cropped if needed) to 608x342 pixels.
Ideally, you should pre-crop the photos yourself to have a 16:9 aspect ratio. Since we also present the large sizes, the images should be scaled down to about 2400 pixels wide (since any more is just wasted space). Feel free to optimize the images before uploading.
The first four images are the most important, and will be rotated in as thumbnails representing the whole show and available for social media sharing. Make sure images 1 through 4 have some neutral space near the top so the show title can be overlaid.
<span style="color:red;">Do we have clearance/permission to show the childen in the photos?</span>
</p>
</div>

<iframe class="uploader" src="edit_uploader.php?id=<?php echo htmlspecialchars($event->id()); ?>&amp;year=<?php echo htmlspecialchars(date('Y', $event->showFirstDate)); ?>&amp;type=photo&amp;multiple=multiple&amp;property=photoFilename"></iframe>

<h3>Dates</h3>
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

<script src="<?php echo htmlspecialchars($root); ?>js/showdown.js"></script>
<script src="<?php echo htmlspecialchars($root); ?>js/jquery-1.12.4.min.js"></script>
<script src="<?php echo htmlspecialchars($root); ?>js/jquery-ui-1.12.1.min.js"></script>
<script src="<?php echo htmlspecialchars($root); ?>js/rangy-core.js"></script>
<script src="<?php echo htmlspecialchars($root); ?>js/to-markdown.js"></script>
<script src="<?php echo htmlspecialchars($root); ?>js/timepicki.js"></script>
<script src="<?php echo htmlspecialchars($root); ?>wymeditor/jquery.wymeditor.min.js"></script>

<script>

var date = new Date();
$('.datepicker').datepicker({
	dateFormat: "m/d/y",

});

$('.timePicker').timepicki({
	step_size_minutes:15,
	reset: true
});

// Initialize all wymeditor blocks.
//
// First, replay the script I accumulated.
var converter = new Showdown.converter();
var content, contentHTML;
<?php echo $editorInitializationScript; ?>

var options = {
	skin: 'seamless',

    toolsItems: [
            {
                'name': 'Bold',
                'title': 'Strong',
                'css': 'wym_tools_strong'
            },
            {
                'name': 'Italic',
                'title': 'Emphasis',
                'css': 'wym_tools_emphasis'
            },
            {
                'name': 'InsertOrderedList',
                'title': 'Ordered_List',
                'css': 'wym_tools_ordered_list'
            },
            {
                'name': 'InsertUnorderedList',
                'title': 'Unordered_List',
                'css': 'wym_tools_unordered_list'
            },
            {
                'name': 'Undo',
                'title': 'Undo',
                'css': 'wym_tools_undo'
            },
            {
                'name': 'Redo',
                'title': 'Redo',
                'css': 'wym_tools_redo'
            },
            {
                'name': 'CreateLink',
                'title': 'Link',
                'css': 'wym_tools_link wym_opens_dialog'
            },
            {
                'name': 'Unlink',
                'title': 'Unlink',
                'css': 'wym_tools_unlink'
            },
        ],

    containersItems: [
            {'name': 'P', 'title': 'Paragraph', 'css': 'wym_containers_p'},
            {'name': 'H4', 'title': 'Heading_4', 'css': 'wym_containers_h4'},
            {'name': 'H5', 'title': 'Heading_5', 'css': 'wym_containers_h5'},
            {'name': 'H6', 'title': 'Heading_6', 'css': 'wym_containers_h6'},
            {'name': 'BLOCKQUOTE', 'title': 'Blockquote',
                'css': 'wym_containers_blockquote'},
        ],
    // We already included the seamless skin's javascript so that we could
    // use this constant
    iframeHtml: WYMeditor.SKINS.seamless.OPTS.iframeHtml

};
$('.wymeditor').wymeditor(options);


/* USE THIS IF WE DECIDE ON AJAX UPDATING ....

$('.editable').on('hallomodified', function(event, data) {
    alert("New contents are " + data.content + ' ' + event.target);
});

*/

// Support function to convert HTML to markdown

var markdownize = function(content) {
var html = content.split("\n").map($.trim).filter(function(line) {
  return line != "";
}).join("\n");
return toMarkdown(html);
};

// Function to call on form submission

$( "#mainform" ).submit(function( event ) {

	// Convert separate time and date fields to single time/date

	$("input[name*=_time]").each(function(){

		var time = $(this).val();
		if (time != '') {
		    var inputname = ($(this).attr("name"));
		    inputname = inputname.slice(0, -5);

		   	var date = $("input[name="+ inputname + "]").val();

			$("input[name="+ inputname + "]").val(date + " " + time);
		}
	});

	$(".wymeditor").each(function(){

		// Convert latest HTML contents to markdown for submission
		var textArea = $(this)[0];
		var myWym = $.getWymeditorByTextarea(textArea);
		if (myWym) {
		    var html = myWym.html();
			var markdown = markdownize(html);
			var htmlID = $(this).attr("id");
			var markdownID = htmlID.replace("_html", "_markdown");
			$('#' + markdownID).text(markdown);
		}



	});

	// let submission go through
});

</script>
</body>
</html>


