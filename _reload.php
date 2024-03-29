<?php

// This is included, not a function, so that all the globals can work in global scope.
require_once('_functions.php');
require_once('_classes.php');

require_once('_globals.php');		// This should rebuild the globals, so we don't have OLD data.

// Set this global so that we get the right file extension on links to main pages.
$isRebuilding = true;


// Files to re-build from PHP into HTML

$ignore = array("index.rss.php", "phpliteadmin.config.php", "phpliteadmin.php", "ApacheError.php",
	"reload.php", "index.inline-styles.css.php", "index.ajax.php", "payment.php");

$all = scandir($_SERVER["DOCUMENT_ROOT"]);

foreach($all as $file) {

	// We want PHP files that aren't ignored, or start with . or _
	if (startsWith($file, '.')
		|| startsWith($file, '_')
		|| !endsWith($file, '.php')
		|| in_array($file, $ignore) ) {
		continue;
	}

echo $file . "<br>";

	$event = NULL;		// don't keep around, since it messes up future page loads as a global variable

	$path_parts = pathinfo($file);

	chdir($path_parts['dirname']);
	ob_start();
	error_log("_reload.php including: $file");
	include $file;
	$htmlToOutput = ob_get_clean();

	$newfile = $path_parts['filename'] . '.html';
	$bytesWritten = file_put_contents($newfile, $htmlToOutput);
	if (!$bytesWritten) {
		print("Unable to write to $newfile");
		error_log("Unable to write to $newfile");
	}
}
$isRebuilding = false;		// probably not needed since request is surely done by this point, but just in case.

?>