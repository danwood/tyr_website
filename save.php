<?php

require_once('_authenticate.php');
require_once('_prelude.php');



$inputs = $_POST;
unset($inputs['submit']);

function endswith($string, $test) {
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



$db = new MyDB();

if (isset($_POST['id'])) {

	$id = $_POST['id'];
	unset($inputs['id']);

	$query = 'select * from events where id=' . $id;

	$ret = $db->query($query);
	if(!$ret) {
		echo $db->lastErrorMsg();
		die;
	}
	while ($row = $ret->fetchArray(SQLITE3_ASSOC) ){

		$event = new Event($row);		// Copy the event, work with that.
	}

	$query = 'update events set ';
	foreach ($inputs as $key => $value) {
		$value = trim($value);
		if (!endswith($key, '_time')) {
			$query .= $key . '=';

			if (endswith($key, 'Date')) {
				$value = dateTo8601($value);
			} else if (endswith($key, 'DateTime') || endswith(substr($key,0,-1), 'DateTime')) {
				$value = datetimeTo8601($value);
			}
			$query .= "'" . SQLite3::escapeString($value) . "',";
		}
	}
	$query = substr($query, 0, -1);	// take out last ,
	$query .= ' where id=' . $id;

	$ret = $db->query($query);
	if(!$ret) {
		echo $db->lastErrorMsg();
		die;
	}

	header("Location: /edit.php?saved=$id&id=$id");
}
else
{
	$valuesList = '';
	$query = 'insert into events (';
	foreach ($inputs as $key => $value) {
		if (!endswith($key, '_time')) {
			$query .= $key . ',';

			if (endswith($key, 'Date')) {
				$value = dateTo8601($value);
			} else if (endswith($key, 'DateTime') || endswith(substr($key,0,-1), 'DateTime')) {
				$value = datetimeTo8601($value);
			}

			$valuesList .= "'" . SQLite3::escapeString($value) . "',";
		}
	}
	$query = substr($query, 0, -1);	// take out last ,
	$query .= ') values(';
	$query .= $valuesList;
	$query = substr($query, 0, -1);	// take out last ,
	$query .= ')';

	$ret = $db->query($query);
	if(!$ret) {
		echo $db->lastErrorMsg();
		die;
	}
	$id = $db->lastInsertRowID();

	header("Location: /edit.php?created=$id&id=$id");
}


/*

$reflector = new ReflectionClass($event);
print_r($reflector);


foreach ($inputs as $key => $value) {

	$prop = $reflector->getProperty($key);
	$value = $prop->isPrivate() ? $event->{$key}() : $event->{$key};


}
*/


$db->close();
$db->backup();
