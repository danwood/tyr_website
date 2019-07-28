<?php

error_reporting(E_ALL);
date_default_timezone_set('America/Los_Angeles');

// For 4 & 5 letter months, use full month name, not 3 letters.  'M' converted to 'F' for those.
function smartDate($format, $timestamp = NULL )
{
	if (is_null($timestamp)) $timestamp = time();
	$whereM = strpos($format, 'M');
	if (FALSE !== $whereM)
	{
		if (strlen(date('F', $timestamp)) <= 5)
		{
			$format[$whereM] = 'F';
		}
	}
	return date($format, $timestamp);
}

function encodeAmpersand($s)
{
	$s = str_replace('&', '%26', $s);
	$s = str_replace('"', '%22', $s);
	return $s;
}

// e.g March 1 - 2  or March 31 - April 1 or if identical, just the one date.

function smartDateRange($timestamp1, $timestamp2, $separator = ' - ', $isFullMonth = FALSE)
{
	$monthFormat = $isFullMonth ? 'F' : 'M';

	$result = smartDate($monthFormat . ' j', $timestamp1);
	if ($timestamp1 != $timestamp2)
	{
		$result .= $separator;
		$month1 = smartDate($monthFormat, $timestamp1);
		$month2 = smartDate($monthFormat, $timestamp2);
		$day2 = date('j', $timestamp2);
		if ($month1 != $month2)
		{
			$result .= $month2;
			$result .= ' ';
		}
		$result .= $day2;
	}
	return $result;
}

// Be able to navigate both
function currentExtension() {
	global $isRebuilding;

	if (isset($isRebuilding) && $isRebuilding) {
		// We are in the process of building the .html files, so the extension is html
		$result = "html";
	}
	else {
		$result = "php";

		// If navigating with PHP and time machine 'when' parameter, then keep the query string.
		if ( isset($_GET['when']) && !empty($_GET['when']) ) {
			$result .= '?' . $_SERVER['QUERY_STRING'];
		}
		else	// no "when" parameter so link will go to HTML actually
		{
			$result = "html";
		}
	}
	return $result;
}
function currentIndexPath($absolute = FALSE) {

	global $isRebuilding;

	$slashOrEmpty = $absolute ? '/' : '';

	if (isset($isRebuilding) && $isRebuilding) {
		// We are in the process of building the .html files, so the extension is html
		$result = $slashOrEmpty;
	}
	else {
		$result = $slashOrEmpty . "index.php";

		// If navigating with PHP and time machine 'when' parameter, then keep the query string.
		if ( isset($_GET['when']) && !empty($_GET['when']) ) {
			$result .= '?' . $_SERVER['QUERY_STRING'];
		}
		else	// no "when" parameter so link will go to HTML actually
		{
			$result = $slashOrEmpty;
		}
	}
	return $result;
}

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function endsWith($string, $test) {
    $strlen = strlen($string);
    $testlen = strlen($test);
    if ($testlen > $strlen) return false;
    return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
}

function dateTo8601($value) {
	if (!$value) return '';
	$time = strtotime($value);
	$value = date('c', $time);
	return $value;
}

function datetimeTo8601($value) {
	if (!$value) return '';
	$time = strtotime($value);
	$value = date('c', $time);
	return $value;
}

?>