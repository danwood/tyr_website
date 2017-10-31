<?php

require_once('_authenticate.php');	// Login required
require_once('_prelude.php');
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

header('Location: /reload.php');

?>