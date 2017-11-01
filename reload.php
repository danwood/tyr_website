<?php

define('GOOGLE_KEY', '0AibPgovp6ncndGd0S3I4MWc2SVR4RE52U3FFLVJsdWc');
date_default_timezone_set('America/Los_Angeles');

// https://docs.google.com/spreadsheet/pub?key=0AibPgovp6ncndGd0S3I4MWc2SVR4RE52U3FFLVJsdWc&single=true&gid=0&output=csv
function retrieveGoogleTable($tableNumber)
{
	global $root;
	$cacheFileName = $root . 'cache/cache.' . $tableNumber . '.csv';

	$url = sprintf('https://docs.google.com/spreadsheet/pub?key=%s&single=true&gid=%d&output=csv', GOOGLE_KEY, $tableNumber);
    $curl = curl_init($url);
	curl_setopt($curl, CURLOPT_FAILONERROR, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);

	$loadedData = curl_exec($curl);
	$returnCode = curl_errno($curl);	// 0 means success.  -999 means couldn't write to file.  Otherwise curl error code.
	if (0 == $returnCode)
	{
		$bytesWritten = file_put_contents($cacheFileName, $loadedData);			// Store in cache!
		if (FALSE === $bytesWritten)
		{
			$returnCode = -999;
		}
	}
	else
	{
		$info = curl_getinfo($curl);
		print_r($info);
	}
	return $returnCode;
}


echo "<p>It's now " . date('r', time()) . "</p>" . PHP_EOL;
echo "<p>Retrieving Google Table 0...</p>\n";
$errCode = retrieveGoogleTable(0);
if (0 == $errCode)
{
	echo "<p>Success!</p>\n";
}
else if (-999 == $errCode)
{
	echo "<p>Retrieved data, but couldn't write to cache file!</p>\n";
}
else
{
	echo "<p>Couldn't get from Google [error $errCode]</p>\n";
}

if (0 == $errCode)
{
	// Only bother rebuilding files if we got our data


	echo "<p><b>Loading from spreadsheet cache into sqlite3 database....</b></p>\n";

	require_once('_importspreadsheet.php');

 	// Files to re-build from PHP into HTML

	$files = array('about.php', 'archives.php', 'donate.php', 'staff.php', 'index.php', 'index.rss.php', 'volunteer.php' );


	foreach($files as $file) {

		$event = NULL;		// don't keep around, since it messes up future page loads as a global variable

		echo "<p>Rebuilding $file...</p>\n";

		$path_parts = pathinfo($file);

		chdir($path_parts['dirname']);
		ob_start();
		include $file;
		$htmlToOutput = ob_get_clean();

		$newfile = $path_parts['filename'] . '.html';
		$bytesWritten = file_put_contents($newfile, $htmlToOutput);

		echo "<p>$bytesWritten bytes written to $newfile.</p>\n";

	}
	echo "<p>Done!</p>";


	echo "<p><a href='/'>Back to home page</a></p>";
}

?>
