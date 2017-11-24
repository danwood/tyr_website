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

$errorMessage = NULL;
$currentFileName = NULL;

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

	for($i = 0; $i < count($uploadedFiles['name']); $i++){
	    $image = array(
	        'name' => $uploadedFiles['name'][$i],
	        'type' => $uploadedFiles['type'][$i],
	        'size' => $uploadedFiles['size'][$i],
	        'tmp_name' => $uploadedFiles['tmp_name'][$i],
	        'error' => $uploadedFiles['error'][$i]
	    );

	    $currentFileName = $image['name'];		// global scope, for error message if failure
	    $currentLink = '';
	    $mimeType = $image['type'];

	    if (0 === strpos($mimeType, 'image/') )		// seems to be an image
	    {
	    	// Let large images go through unchanged

	    	if ($type == 'poster' || $type == 'signup' || $type == 'slider_past' || $type == 'slider_promo')
	    	{
		    	$tmp_name = $image['tmp_name'];
				$moved = move_uploaded_file($tmp_name, 'shows/' . $type . '/' . $currentFileName);
				if (!$moved)
				{
		    		$errorMessage = "Could not move upload";
		    		goto giveup;
				}
				$currentLink = 'shows/' . $type . '/' . $currentFileName;
	   		}
	   		else	// Want to shrink!  … logo, photo
	   		{
	   			// But first copy in original
	   			$typeAndMaybeYear = $type . '/';
	   			if ($type == 'photo') {
	   				$typeAndMaybeYear .= $year . '/';
	   			}


	   			$pathToOriginal = 'shows/' . $typeAndMaybeYear . '/original/' . $currentFileName;
		    	$tmp_name = $image['tmp_name'];
				$moved = move_uploaded_file($tmp_name, $pathToOriginal);
				if (!$moved)
				{
					$currentFileName = $pathToOriginal;	// for error message
		    		$errorMessage = "Could not move original image";
		    		goto giveup;
				}
	   			$pathToSized = 'shows/' . $typeAndMaybeYear . $currentFileName;

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

			$moved = move_uploaded_file($tmp_name, 'shows/' . $type . '/' . $currentFileName);
			if (!$moved)
			{
				echo "tmp_name = " . $tmp_name;
				echo "dir = " . 'shows/' . $type;
				echo "name = " . $currentFileName;
	    		$errorMessage = "Could not move upload";
	    		goto giveup;
			}
			$currentLink = 'shows/' . $type . '/' . $currentFileName;
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

			$moved = move_uploaded_file($tmp_name, 'shows/' . $type . '/' . $currentFileName);
			if (!$moved)
			{
				echo "tmp_name = " . $tmp_name;
				echo "dir = " . 'shows/' . $type;
				echo "name = " . $currentFileName;
	    		$errorMessage = "Could not move upload";
	    		goto giveup;
			}
			$currentLink = 'shows/' . $type . '/' . $currentFileName;
	    }
	    else
	    {
	    	$errorMessage = "Couldn't use file ($mimeType)";
	    	goto giveup;
	    }
	    echo '<p>Moved "<a href="' . $currentLink . '">' . $currentFileName . '"</a> into place.</p>' . PHP_EOL;
	    echo '<p><img style-"max-width:100px;" src="' . $currentLink . '" />' . PHP_EOL;

	}

giveup:
	if ($errorMessage)
	{
		echo '<p style="color:red;">' . htmlspecialchars($errorMessage);
		if ($currentFileName)
		{
			echo ': "' . htmlspecialchars($currentFileName) . '"';
		}
		echo "</p>" . PHP_EOL;
		echo "<pre>\n";
		print_r($uploadedFiles);
		echo "\n</pre>\n";
	}
?>
	<p><a href="backstage.php">Upload some more</a></p>
<?php
}
else	// input form
{
?>

<form id="uploader" action="/edit_photouploader.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>" />
<input type="hidden" name="type" value="<?php echo htmlspecialchars($_GET['type']); ?>" />
<input type="hidden" name="year" value="<?php echo htmlspecialchars($_GET['year']); ?>" />
<p>
  <input style="width:100%;" id="fileinput" <?php
if (isset($_GET['multiple'])) { echo 'multiple="multiple" '; }
?>type='file' name='file[]' enabled />
</p>
<p>
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
