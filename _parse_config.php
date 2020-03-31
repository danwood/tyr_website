<?php

// Finds all of the assignments in the file -- they must be either TRUE, FALSE, or a single-quoted string


// This only really works if it's one-liners, not good for multi-line expressions.

function read_config()
{
	return $GLOBALS;
	/*
	$configfile = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/../_private.php');

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
	*/
}

function write_config($newValues)
{
	$configfile = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/../_private.php');

	$output = '';

	// pass through until (including) a line like this:
	// =================================================================================
	// then dump out the newValues array.


	$needsNewline = FALSE;

	$lines = explode("\n", $configfile);

	$values = array();

	foreach ($lines as $line) {

		if ($needsNewline) {		// insert newline except for first time
			$output .= "\n";
		}
		$needsNewline = TRUE;

		$matches = array();
		$matched = preg_match('/\s*\/\/\s=========+/', $line, $matches);
		if ($matched) {

			$output .= $line . "\n\n";		// add that line to the output

			// Now output the values

			foreach ($newValues as $key => $value) {

				$newStatement = '$' . $key . ' = ';
				if ($value === TRUE) $newStatement .= 'TRUE';
				else if ($value === FALSE) $newStatement .= 'FALSE';	// Unlikely since FALSE doesn't carry through a POST
				else $newStatement .= "'" . str_replace("'","\'",$value) . "'";	// escape the single-quotes
				$newStatement .= ";";

				$output .= $newStatement . "\n\n";
			}

			break;		// don't need to parse the input anymore
		}
		else
		{
			// write the line back out as-is
			$output .= $line;
		}
	}

	file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/../_private.php', $output);
}

?>