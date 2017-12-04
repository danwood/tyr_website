<?php

require_once('_authenticate.php');	// Login required
require_once('_prelude.php');
require_once('phmagick.php');
require_once('_parse_config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='';
$title='Tomorrow Youth Rep — Photo Uploader';
$description='';
include('_head.php');
?>
</head>
<body class="lightgray-block">


<?php

class MyDB extends SQLite3
{
    function __construct()
    {
		$dbPath = $_SERVER['DOCUMENT_ROOT'] . '/db/tyr.sqlite3';

        $this->open($dbPath, SQLITE3_OPEN_READWRITE);
    }
}

$event = Event::getSpecifiedEvent(FALSE);

if (!$event) { echo "ERROR: where is the event?"; die; }

$reflector = null;
if ($event)
{
	$reflector = new ReflectionClass(get_class($event));
}

$errorMessage = NULL;
$currentFilename = NULL;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

	$type = $_POST['type'];
	$year = $_POST['year'];		// for photo uploads
	if (! in_array($type, array('logo', 'photo', 'poster', 'signup', 'slider_past', 'slider_promo')))
	{
    		$errorMessage = "Something was wrong with the file type";
    		goto giveup;
	}

	$uploadedFiles = $_FILES['file'];

	// Get the current value of the property, which may have a number in it
	$propertyName = $_POST['property'];
	$prop = $reflector->getProperty($propertyName);
	$maxFilename = $prop->isPrivate() ? $event->{$propertyName}() : $event->{$propertyName};

	$maxFileValue = 0;
	$matches = array();
	if ((integer) preg_match('/[0-9]+/', $maxFilename, $matches)) {
		$maxFileValue = (integer) $matches[0];
	}

	for($i = 0; $i < count($uploadedFiles['name']); $i++){
	    $image = array(
	        'name' => $uploadedFiles['name'][$i],
	        'type' => $uploadedFiles['type'][$i],
	        'size' => $uploadedFiles['size'][$i],
	        'tmp_name' => $uploadedFiles['tmp_name'][$i],
	        'error' => $uploadedFiles['error'][$i]
	    );

	    $currentFilename = $image['name'];		// global scope, for error message if failure
	    $currentLink = '';
	    $mimeType = $image['type'];

	    // Figure out number embedded in each file name, and compare to number
	    $thisFileValue = 0;
	    if (preg_match('/[0-9]+/', $currentFilename, $matches)) {

			$thisFileValue = (integer) $matches[0];
		}
	    if ($thisFileValue >= $maxFileValue) {
	    	$maxFileValue = $thisFileValue;
	    	$maxFilename = $currentFilename;
	    }

		$showsTypeAndYearSlash = 'shows/' . $type . '/' . $year . '/';

	    if (0 === strpos($mimeType, 'image/') )		// seems to be an image
	    {
	    	// Let large images go through unchanged

	    	if ($type == 'poster' || $type == 'signup' || $type == 'slider_past' || $type == 'slider_promo')
	    	{
		    	$tmp_name = $image['tmp_name'];
				$moved = move_uploaded_file($tmp_name, $showsTypeAndYearSlash . $currentFilename);
				if (!$moved)
				{
		    		$errorMessage = "Could not move upload";
		    		goto giveup;
				}
				$currentLink = $showsTypeAndYearSlash . $currentFilename;
	   		}
	   		else	// Want to shrink!  … logo, photo
	   		{
	   			$pathToOriginal = $showsTypeAndYearSlash . 'original/' . $currentFilename;
		    	$tmp_name = $image['tmp_name'];
error_log("move '$tmp_name' to '$pathToOriginal'");
				$moved = move_uploaded_file($tmp_name, $pathToOriginal);
				if (!$moved)
				{
					$currentFilename = $pathToOriginal;	// for error message
		    		$errorMessage = "Could not move original image";
		    		goto giveup;
				}
	   			$pathToSized = $showsTypeAndYearSlash . $currentFilename;

	   			$put = file_put_contents($pathToSized, 'Hi there');

	   			// Photos: We want 608x342.  Tight JPEG compression.
				if ($type == 'photo')
				{
					$phMagick = new phMagick($pathToOriginal, $pathToSized);
					$phMagick->debug = TRUE;
					$phMagick->setImageQuality(75);			// Used to be 50, but since I may be optimizing, go ahead and get a better quality
					$phMagick->resizeExactly(608,342);
					// error_log(print_r($phMagick->getLog(), 1));
				}
				else 	// logo, we want 544 wide.
				{
					$phMagick = new phMagick($pathToOriginal, $pathToSized);
					$phMagick->setImageQuality(75);			// Used to be 50, but since I may be optimizing, go ahead and get a better quality
					$phMagick->resize(544);
				}
				$currentLink = $pathToSized;

	   		}
	    }
	    else if ($mimeType == 'application/pdf' && ($type == 'signup' || $type == 'poster'))		// seems to be an PDF, and correct type
	    {
	    	$tmp_name = $image['tmp_name'];
			$fp = fopen($tmp_name, 'r');
			$data = fread($fp, 5);
			fclose($fp);
			if ('%PDF-' != $data)
			{
	    		$errorMessage = "Something was wrong with the contents of the PDF file";
	    		goto giveup;
			}

			$moved = move_uploaded_file($tmp_name, $showsTypeAndYearSlash . $currentFilename);
			if (!$moved)
			{
				echo "tmp_name = " . $tmp_name;
				echo "dir = " . $showsTypeAndYearSlash;
				echo "name = " . $currentFilename;
	    		$errorMessage = "Could not move upload";
	    		goto giveup;
			}
			$currentLink = $showsTypeAndYearSlash . $currentFilename;
	    }
	    else if ($mimeType == 'audio/mpeg' && $type == 'signup')		// seems to be an MP3, and correct type
	    {
	    	$tmp_name = $image['tmp_name'];
			$fp = fopen($tmp_name, 'r');
			$data = fread($fp, 3);
			fclose($fp);
			if ('ID3' != $data)
			{
	    		$errorMessage = "Something was wrong with the contents of this .mp3 file";
	    		goto giveup;
			}

			$moved = move_uploaded_file($tmp_name, $showsTypeAndYearSlash . $currentFilename);
			if (!$moved)
			{
				echo "tmp_name = " . $tmp_name;
				echo "dir = " . $showsTypeAndYearSlash;
				echo "name = " . $currentFilename;
	    		$errorMessage = "Could not move upload";
	    		goto giveup;
			}
			$currentLink = $showsTypeAndYearSlash . $currentFilename;
	    }
	    else
	    {
	    	$errorMessage = "Couldn't use file ($mimeType)";
	    	goto giveup;
	    }
	    echo '<p>Moved "<a target="_BLANK" href="' . $currentLink . '">' . $currentFilename . '"</a> into place.</p>' . PHP_EOL;


	}

	// NOW SAVE FILE NAME TO DATABASE

	$db = new MyDB();
	$id = $_POST['id'];

	$query = 'update events set ' . $propertyName . ' = ';
	$query .= "'" . SQLite3::escapeString($maxFilename) . "'";
	$query .= ' where id=' . $id;

	$ret = $db->query($query);
	if(!$ret) {
		echo $db->lastErrorMsg();
		die;
	}
	$db->close();

giveup:
	if ($errorMessage)
	{
		echo '<p style="color:red;">' . htmlspecialchars($errorMessage);
		if ($currentFilename)
		{
			echo ': "' . htmlspecialchars($currentFilename) . '"';
		}
		echo "</p>" . PHP_EOL;
		echo "<pre>\n";
		print_r($uploadedFiles);
		echo "\n</pre>\n";
	}

	if (isset($_GET['multiple'])) { echo '<p><a href="backstage.php">Upload some more</a></p>'; }
}
else	// input form
{
	$propertyName = $_GET['property'];
	$prop = $reflector->getProperty($propertyName);
	$maxFilename = $prop->isPrivate() ? $event->{$propertyName}() : $event->{$propertyName};
?>

<form id="uploader" action="/edit_uploader.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>" />
<input type="hidden" name="type" value="<?php echo htmlspecialchars($_GET['type']); ?>" />
<input type="hidden" name="year" value="<?php echo htmlspecialchars($_GET['year']); ?>" />
<input type="hidden" name="property" value="<?php echo htmlspecialchars($_GET['property']); ?>" />
<?php
	if (!empty($maxFilename)) {
?>
	<p>Currently set to: <?php echo htmlspecialchars($maxFilename); ?></p>
<?php
	}
?>
<p>
  <input id="fileinput" <?php
if (isset($_GET['multiple'])) { echo 'multiple="multiple" '; }
?>type='file' name='file[]' enabled />

  <input id="submit" type="submit" value="Upload" disabled /> <span id="status"></span>
</p>
</form>

<script src="<?php echo htmlspecialchars($root); ?>js/jquery-1.12.4.min.js"></script>
<script>
	$("#fileinput").change(function (){
		$('#submit').removeAttr('disabled');
	});

	$("#uploader").submit(function (){
		$('#submit').attr('disabled', 'disabled');
		$('#status').text('Uploading...');
	});
</script>

<?php
}
?>
</body>
</html>
