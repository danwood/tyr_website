<?php
require_once('../_authenticate.php');	// Login required
require_once('../_functions.php');
require_once('../_classes.php');
require_once('../_globals.php');

require_once('../_phmagick.php');
require_once('../_parse_config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='../';	// Needed for prelude since we aren't at top level directory
$title='Tomorrow Youth Rep — Photo Uploader';
$description='';
include('../_head.php');
?>
</head>
<body class="lightgray-block">


<?php

$event = Event::getSpecifiedEvent(FALSE);

if (!$event) { echo "ERROR: where is the event?"; die; }

$reflector = null;
if ($event)
{
	$reflector = new ReflectionClass(get_class($event));
}

$errorMessage = NULL;
$currentFilename = NULL;



$propertyName = $_GET['property'];
$prop = $reflector->getProperty($propertyName);
$maxFilename = $prop->isPrivate() ? $event->{$propertyName}() : $event->{$propertyName};

$imagePath = '';
if (!empty($maxFilename)) {
	$imagePath = 'shows/' . $_GET['type'] . '/' . $_GET['year'] . '/' . $maxFilename;
?>
<div style="width:100%; height:100%; background-image:url('<?php echo $root . htmlspecialchars($imagePath); ?>'); background-repeat:no-repeat; background-position:right top; background-size:contain">
<?php
} else {
?>
	<div>
<?php
}
?>
<p>Currently set to: <a target="_BLANK" href="<?php echo $root . htmlspecialchars($imagePath); ?>"><?php echo htmlspecialchars($maxFilename); ?></a>
	<?php if (isset($_GET['multiple'])) { echo " (last one in a series)"; } ?>
</p>

<form id="uploader" action="edit_upload.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>" />
<input type="hidden" name="type" value="<?php echo htmlspecialchars($_GET['type']); ?>" />
<input type="hidden" name="year" value="<?php echo htmlspecialchars($_GET['year']); ?>" />
<input type="hidden" name="property" value="<?php echo htmlspecialchars($_GET['property']); ?>" />
<p>
  <input id="fileinput" <?php
if (isset($_GET['multiple'])) { echo 'multiple="multiple" '; }
?>type='file' name='file[]' enabled />

  <input id="submit" type="submit" value="Upload" disabled /> <span id="status"></span>
</p>
</form>
</div>

<script src="<?php echo $root; ?>js/jquery-1.12.4.min.js"></script>
<script>
	$("#fileinput").change(function (){
		$('#submit').removeAttr('disabled');
	});

	$("#uploader").submit(function (){
		$('#submit').attr('disabled', 'disabled');
		$('#status').text('Uploading...');
	});
</script>

</body>
</html>
