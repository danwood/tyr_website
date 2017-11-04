<?php

require_once('_authenticate.php');
require_once('_prelude.php');



$inputs = $_POST;
unset($inputs['submit']);

class MyDB extends SQLite3
{
    function __construct()
    {
		$dbPath = $_SERVER['DOCUMENT_ROOT'] . 'tyr.sqlite3';

        $this->open($dbPath, SQLITE3_OPEN_READWRITE);
    }
}

$db = new MyDB();

if (isset($_POST['id'])) {

	$id = $_POST['id'];
	unset($inputs['id']);

	$query = 'select * from events where id=' . $id;

	$ret = $db->query($query, true);
	if(!$ret) {
		echo $db->lastErrorMsg();
		die;
	}
	while ($row = $ret->fetchArray(SQLITE3_ASSOC) ){

		print_r($row);
		$event = new Event($row);		// Copy the event, work with that.
	}

	$query = 'update event set ';
	foreach ($inputs as $key => $value) {
		$query .= $key . '=';
		$valuesList .= "'" . $value . "',";
	}
	$query = substr($query, 0, -1);	// take out last ,
	$query = ' where id=' . $id;
}
else
{
	$valuesList = '';
	$query = 'insert into events (';
	foreach ($inputs as $key => $value) {
		$query .= $key . ',';
		$valuesList .= "'" . $value . "',";
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

	header('Location: /edit.php?id=' . $id);
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
