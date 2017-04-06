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
?>
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

function showEditor($sqlColumn, $sqlType, $displayName, $explain = '', $size = SIZE_ONELINE, $isMarkdown = MARKDOWN_FALSE, $isRequired = REQUIRED_FALSE) {



}

// Tuition									// human-readable dollars
// TicketURL								// URL to buy tickets (otherwise free show?)
// PhotoURL1								// URL of a photo album for a show, after the run is over
// PhotoURL2								// URL of a second photo album for a show, after the run is over
// PublicityAttachment						// downloadable PDF that parents can print out for a show that is ready for ticketing
// AuditionLocation							// WHERE auditions will be held
// AuditionPrepare							// WHAT to prepare for auditions **

// ClassDays								// Days of the week the rehearsals/camp/classes are, or maybe specific dates
// StartTime								// time, in human-readable format, that auditions/camp/classes start
// EndTime									// time, in human-readable format, that auditions/camp/classes end



showEditor('title', 'TEXT',                  'Title', '', SIZE_ONELINE, MARKDOWN_FALSE, REQUIRED_TRUE);
showEditor('suffix', 'TEXT',                 'Suffix', 'must be short!', SIZE_TINY);
showEditor('infoIfNoLogo', 'TEXT',           'Longer title', 'Shown only when no logo', SIZE_SMALL);
showEditor('descriptionBefore', 'TEXT',      'Recruiting description', 'General blurb used for recruiting show, on the recruitment page', SIZE_MULTILINE, MARKDOWN_TRUE);
//showEditor('logoFilename', 'TEXT',           'logoFilename'
//showEditor('photoFilename', 'TEXT',
showEditor('photoCredits', 'TEXT',           'Photo Credits', 'Who took the photos after the show/event', SIZE_ONELINE)
//showEditor('type', 'INTEGER',                'type'
showEditor('signupDetails', 'TEXT',          'Signup Details', 'Where classes are, audition preparations, what to expect, etc.', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('whoCanGo', 'TEXT',               'Who Can Go', 'Age or grade range etc.', SIZE_TINY);
//showEditor('signupAttachment', 'TEXT',
showEditor('performanceInfo', 'TEXT',        'Performance Info', 'Details on when and where performances are', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('howTheShowWent', 'TEXT',         'howTheShowWent', 'After the show, some text to describe how it went. For people reading details about show from archives', SIZE_MULTILINE, MARKDOWN_TRUE);
showEditor('castList', 'TEXT',               'castList', 'Fill this in to show who got cast.  Goes away after rehearsal start date', SIZE_MULTILINE, MARKDOWN_TRUE);
//showEditor('sharedCast', 'BOOLEAN',
showEditor('tuition', 'TEXT',                'Tuition', 'Human-readable dollar amount or amounts', SIZE_ONELINE);
/*
showEditor('ticketURL', 'TEXT',              'ticketURL',
showEditor('photoURL1', 'TEXT',              'photoURL1',
showEditor('photoURL2', 'TEXT',              'photoURL2',
showEditor('publicityAttachment', 'TEXT',    'publicityAttachment',
showEditor('auditionLocation', 'TEXT',       'auditionLocation', 'T
showEditor('auditionPrepare', 'TEXT',        'auditionPrepare', 'TE
showEditor('classDays', 'TEXT',              'classDays',
showEditor('startTime', 'TEXT',              'startTime',
showEditor('endTime', 'TEXT',                'endTime',
showEditor('announceDate', 'DATETIME',       'announceDate', 'DATET
showEditor('signupStartDate', 'DATETIME',    'signupStartDate', 'DA
showEditor('auditionDateTime1', 'DATETIME',  'auditionDateTime1', '
showEditor('auditionDateTime2', 'DATETIME',  'auditionDateTime2', '
showEditor('callbackDateTime', 'DATETIME',   'callbackDateTime', 'D
showEditor('signupEndDate', 'DATETIME',      'signupEndDate', 'DATE
showEditor('rehearsalStartDate', 'DATETIME', 'rehearsalStartDate',
showEditor('ticketSaleDate', 'DATETIME',     'ticketSaleDate', 'DAT
showEditor('showFirstDate', 'DATETIME',      'showFirstDate', 'DATE
showEditor('showLastDate', 'DATETIME',       'showLastDate', 'DATET
*/

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


