<?php
require_once('_authenticate.php');	// Login required
require_once('_functions.php');
require_once('_classes.php');
require_once('_globals.php');

require_once('phmagick.php');
require_once('_parse_config.php');

$values = read_config();

// Since "off" checkboxes are not included here, and checked items are a string "on" then this needs some merging.

foreach ($values as $key => $value) {


	if ($value === TRUE || $value === FALSE) {
		$values[$key] = (isset($_POST[$key]) && $_POST[$key] == 'on');
	}
	else {
		if (isset($_POST[$key])) $values[$key] = $_POST[$key];
	}
}

write_config($values);

header('Location: /backstage.php');

?>