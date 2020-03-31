<?php
require_once('_authenticate.php');	// Login required
require_once('../_functions.php');
require_once('../_classes.php');
require_once('../_globals.php');

require_once('../_parse_config.php');

$globals = read_config();
$values = Array();

// Since "off" checkboxes are not included here, and checked items are a string "on" then this needs some merging.

foreach ($_POST as $key => $value) {

	if ( $value == 'on' ) {

		$values[$key] = TRUE;
	}
	else {
		$values[$key] = $_POST[$key];
	}
}

write_config($values);

header('Location: /backstage/');

?>