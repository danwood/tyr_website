<?php
require_once('_authenticate.php');	// Login required
require_once('../_functions.php');
require_once('../_classes.php');
require_once('../_globals.php');

require_once('../_phmagick.php');
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

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die;
}


$type = $_POST['type'];
$year = $_POST['year'];		// for photo uploads

if ($year == 1969) { echo "1969"; die; }

if (! in_array($type, array('logo', 'photo', 'poster', 'signup', 'recruiting', 'slider_past', 'slider_promo')))
{
		$errorMessage = "Something was wrong with the file type";
		goto giveup;
}

$uploadedFiles = $_FILES['file'];

// REALLY COMPLICATED LOGIC FOR UPLOADING A BATCH OF MULTIPLE PHOTOS ALL AT ONCE …
//
//
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
    if ($thisFileValue >= $maxFileValue || count($uploadedFiles['name']) == 1) {	// ALWAYS USE GIVEN FILENAME IF JUST ONE
    	$maxFileValue = $thisFileValue;
    	$maxFilename = $currentFilename;
    }

	$showsTypeAndYearSlash = 'shows/' . $type . '/' . $year . '/';
	$fullPathShowsTypeAndYearSlash = $root . $showsTypeAndYearSlash;

    if (0 === strpos($mimeType, 'image/') )		// seems to be an image
    {
    	// Let large images go through unchanged

    	if ($type == 'poster' || $type == 'signup' || $type == 'slider_past' || $type == 'slider_promo')
    	{
	    	$tmp_name = $image['tmp_name'];
	    	@mkdir($fullPathShowsTypeAndYearSlash, 0777, TRUE);
			$moved = move_uploaded_file($tmp_name, $fullPathShowsTypeAndYearSlash . $currentFilename);
			if (!$moved)
			{
	    		$errorMessage = "Could not move upload";
	    		goto giveup;
			}
			$currentLink = $showsTypeAndYearSlash . $currentFilename;
   		}
   		else	// Want to shrink!  … logo, photo
   		{
   			$originalDirectory = $fullPathShowsTypeAndYearSlash . 'original/';
   			@mkdir($originalDirectory, 0777, TRUE);
   			$pathToOriginal = $originalDirectory . $currentFilename;
	    	$tmp_name = $image['tmp_name'];
			$moved = move_uploaded_file($tmp_name, $pathToOriginal);
			if (!$moved)
			{
				$currentFilename = $pathToOriginal;	// for error message
	    		$errorMessage = "Could not move original image";
	    		goto giveup;
			}
   			$pathToSized = $showsTypeAndYearSlash . $currentFilename;
   			$fullPathToSized = $root . $pathToSized;

   			$put = file_put_contents($fullPathToSized, 'ImageMagick did not work');	// 24 bytes long

   			// Photos: We want 608x342.  Tight JPEG compression.
			if ($type == 'photo' || $type == 'recruiting')
			{
				$phMagick = new phMagick($pathToOriginal, $fullPathToSized);
				$phMagick->debug = TRUE;
				$phMagick->setImageQuality(75);			// Used to be 50, but since I may be optimizing, go ahead and get a better quality
				$phMagick->resizeExactly(608,342);
				error_log(print_r($phMagick->getLog(), 1));
			}
			else 	// logo, we want 544 wide.
			{
				$phMagick = new phMagick($pathToOriginal, $fullPathToSized);
				$phMagick->setImageQuality(75);			// Used to be 50, but since I may be optimizing, go ahead and get a better quality
				$phMagick->resize(544);
				error_log(print_r($phMagick->getLog(), 1));
			}
			$currentLink = $pathToSized;

			$fileSize = filesize($fullPathToSized);
			if ($fileSize < 50) {						// tiny file means just our placeholder contents
    			$errorMessage = "Somehow ImageMagic didn't convert the file you uploaded";
    			goto giveup;
    		}
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
		@mkdir($fullPathShowsTypeAndYearSlash, 0777, TRUE);
		$moved = move_uploaded_file($tmp_name, $fullPathShowsTypeAndYearSlash . $currentFilename);
		if (!$moved)
		{
			echo "tmp_name = " . $tmp_name;
			echo "dir = " . $fullPathShowsTypeAndYearSlash;
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
		@mkdir($fullPathShowsTypeAndYearSlash, 0777, TRUE);
		$moved = move_uploaded_file($tmp_name, $fullPathShowsTypeAndYearSlash . $currentFilename);
		if (!$moved)
		{
			echo "tmp_name = " . $tmp_name;
			echo "dir = " . $fullPathShowsTypeAndYearSlash;
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
    echo '<p>Moved "<a target="_BLANK" href="' . $root . $currentLink . '">' . $currentFilename . '"</a> into place.</p>' . PHP_EOL;


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

$db->backup_data();

// include('../_reload.php');	// not a function, and not called from a function, so all globals work right.

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
?>
</body>
</html>
