<?php
require_once('_authenticate.php');	// Login required
require_once('../_functions.php');
require_once('../_classes.php');
require_once('../_globals.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	echo "Error: must be loaded as part of a form submission, not loaded separately.";
	die;
}

$inputs = $_POST;
unset($inputs['submit']);

if (   empty($inputs['type'])
	|| empty($inputs['title'])
	|| empty($inputs['season'])
	|| (empty($inputs['showFirstDate']) && empty($inputs['showLastDate']))


	)
{
?>
	<h1>Insufficient Information!</h1>
	<p>You must specify an event type, show title, dates, and season!
	</p>
	<p>
		Please go back with your browser and correct this.
	</p>
<?php
	die;
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

	header("Location: /backstage/edit.php?saved=$id&id=$id");
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

	header("Location: /backstage/edit.php?created=$id&id=$id");
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
$db->backup_data();

include('../_reload.php');	// not a function, and not called from a function, so all globals work right.

?>
