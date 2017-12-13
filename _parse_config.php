<?php

// Finds all of the assignments in the file -- they must be either TRUE, FALSE, or a single-quoted string


function read_config()
{
	$configfile = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '../_private.php');

	$lines = explode("\n", $configfile);

	$values = array();

	foreach ($lines as $line) {

		$matches = array();
		$matched = preg_match('/\s*\$([A-Za-z0-9_]+)\s*=\s*(.+);/', $line, $matches);
		if ($matched) {

			$key = $matches[1];
			$value = $matches[2];

			if ($value == 'TRUE') $value = TRUE;
			else if ($value == 'FALSE') $value = FALSE;
			else $value = substr(stripcslashes($value), 1, -1);				// take out quotes

			$values[$key] = $value;

		}

	}
	return $values;
}

function write_config($newValues)
{
	$configfile = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '../_private.php');

	$output = '';

	$needsNewline = FALSE;

	$lines = explode("\n", $configfile);

	$values = array();

	foreach ($lines as $line) {

		if ($needsNewline) {		// insert newline except for first time
			$output .= "\n";
		}
		$needsNewline = TRUE;

		$matches = array();
		$matched = preg_match('/\s*\$([A-Za-z0-9_]+)\s*=\s*(.+);/', $line, $matches);
		if ($matched) {

			$key = $matches[1];
			$value = $matches[2];

			if ($value == 'TRUE') $value = TRUE;
			else if ($value == 'FALSE') $value = FALSE;
			else $value = substr($value, 1, -1);				// take out quotes

			$values[$key] = $value;

			if (isset($newValues[$key])) {

				$value = $newValues[$key];
				$newStatement = '$' . $key . ' = ';
				if ($value === TRUE) $newStatement .= 'TRUE';
				else if ($value === FALSE) $newStatement .= 'FALSE';
				else $newStatement .= "'" . addslashes($value) . "'";
				$newStatement .= ";";

				$output .= $newStatement;
			}
			else {
				// write the line back out as-is, since we didn't find it
				$output .= $line;
			}
		}
		else
		{
			// write the line back out as-is
			$output .= $line;
		}
	}
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . '../_private.php', $output);
}

?>