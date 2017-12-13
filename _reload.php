<?php

// This is included, not a function, so that all the globals can work in global scope.
require_once('_functions.php');
require_once('_classes.php');

include('_globals.php');		// This should rebuild the globals, so we don't have OLD data.

// Set this global so that we get the right file extension on links to main pages.
$isRebuilding = true;

// Files to re-build from PHP into HTML

$files = array('about.php', 'archives.php', 'donate.php', 'staff.php', 'index.php', 'index.rss.php', 'volunteer.php' );

foreach($files as $file) {

	$event = NULL;		// don't keep around, since it messes up future page loads as a global variable

	$path_parts = pathinfo($file);

	chdir($path_parts['dirname']);
	ob_start();
	include $file;
	$htmlToOutput = ob_get_clean();

	$newfile = $path_parts['filename'] . '.html';
	$bytesWritten = file_put_contents($newfile, $htmlToOutput);
	if (!$bytesWritten) {
		error_log("Unable to write to $newfile");
	}
}
$isRebuilding = false;		// probably not needed since request is surely done by this point, but just in case.

?>