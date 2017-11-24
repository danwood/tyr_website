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
$title='Tomorrow Youth Rep — Backstage';
$description='';
include('_head.php');
?>
	<style>
		th { text-align:right; padding:1em;}


	</style>
</head>
<body id="" class="lightgray-block">
	<div class="clearfix outside-sticky-footer">
		<!-- Specify grid system. All boxes must be clearfix. Specify layout direction. -->
		<div class="contain-sticky-footer fullwidth">
			<div class="clearfix">
				<!-- Nested groups of boxes inside; must outdent boxes since they indent for gutters -->
				<div class="before-sticky-footer">

<?php
$fullHeader = FALSE;
include('_header.php'); ?>
					<main>
						<section id="upload" class="clearfix capped-width">
							<div class="inlinebox">
								<h2>Backstage</h2>

								<h3>Manage Events</h3>

<p><span style="color:red">Still under development — not ready for general use yet:</span></p>
<p><a href="edit.php">Add a new event</a> or <a href="db.php">edit existing events</a>.</p>
<p>View website using <a href="<?php echo htmlspecialchars($root); ?>index.php?when=<?php echo date('Y-m-d'); ?>">Time Machine</a>.</p>
<p>When data has changed, <a href="<?php echo htmlspecialchars($root); ?>reload.php">Reload</a> the entire site.</p>


								<h3>Upload files for website</h3>


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


	   			$pathToOriginal = 'shows/' . $typeAndMaybeYear . 'original/' . $currentFileName;
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

<p>
	Before uploading, make sure the files are good web-friendly, unique names. Best idea is the year and a simple name of the event, with no spaces, and all lowercase. For instance, <i>2012narnia4.jpg</i> or <i>2013tollbooth.png</i>.
</p>
<p style="color:red;">Also, do we have clearance/permission to show the childen in the photos?
</p>
<p>
	These file names will be the same names you specify in the spreadsheet.
</p>

<form id="uploader" action="backstage.php" method="post" enctype="multipart/form-data">

<p>
<input class="single" type="radio" name="type" id="logo" value="logo" /> <label for="logo"><b>Logo</b>: please provide a .jpg or .png image</logo>
</p>
<p>
<input class="multi" type="radio" name="type" id="photo" value="photo" /> <label for="photo"><b>Show Photos</b>: please provide <b>up to 20</b> .jpg images at a time.  The file names should have sequential numbers 1, 2, 3, 4 before the ".jpg" extension.
E.g. <i>narnia1.jpg</i>, <i>narnia2.jpg</i>, <i>narnia3.jpg</i>, <i>narnia4.jpg</i>.
These files can be chosen all at once in the file chooser.
The images will be resized (and cropped if needed) to 608x342 pixels.
Ideally, you should pre-crop the photos yourself to have a 16:9 aspect ratio. Since we also present the large sizes, the images should be scaled down to about 2400 pixels wide (since any more is just wasted space). Feel free to optimize the .jpg images before uploading.
The first four images are the most important, and will be rotated in as thumbnails representing the whole show and available for social media sharing. Make sure images 1 through 4 have some neutral space near the top so the show title can be overlaid.
</label>
<select name="year">
<?php
$year = (integer)date('Y');
$month = (integer)date('n');
if ($month == 1) $year -= 1;		// currently near the beginning of the year so assume we are uploading pictures from last year show

for ($x = 2012; $x <= 2021; $x++) {
	echo '<option value="' . $x . '"';
	if ($x == $year) echo ' selected';
	echo '>' . $x . '</option>' . PHP_EOL;
}
?>
</select>
</p>
<p>
<input class="single" type="radio" name="type" id="signup" value="signup" /> <label for="signup"><b>Signup</b> registration attachment: please provide a .pdf file, not a Microsoft Word document!  Also, you can upload .mp3 audio files or .jpg images.</label>
</p>
<p>
<input class="single" type="radio" name="type" id="poster" value="poster" /> <label for="poster"><b>Publicity</b> attachment for downloading: please provide a .pdf or suitably large .jpg image.</label>
</p>
<p>
<input class="single" type="radio" name="type" id="slider_past" value="slider_past" /> <label for="slider_past">Home-page, historical <b>Slider</b> attachment: an 1832 x 822 .jpg image of a notable moment from a past show.</label>
</p>
<p>
<input class="single" type="radio" name="type" id="slider_promo" value="slider_promo" /> <label for="slider_promo"><b>Publicity</b> attachment: an 1832 x 822 .jpg image promoting an upcoming show; it will go away after show is done.</label>
</p>

<p>
  <input style="width:100%;" id="fileinput" type='file' name='file[]' disabled />
</p>
<p>
  <input id="submit" type="submit" value="Upload" disabled /> <span id="status"></span>
</p>

</form>

							</div>
						</section>


<?php
}
?>

						<section id="payment" class="clearfix capped-width">
							<div class="inlinebox">
								<h3>Configure <a href="<?php echo htmlspecialchars($root); ?>pay">Payment Page</a></h3>

<?php
$values = read_config();
// write_config($values);
?>
<form method="POST" action="updateconfig.php">
	<table>
		<tr><td colspan="2"><input type="checkbox" name="payment_glossy_program"
			<?php if ($values['payment_glossy_program']) echo "checked "; ?> /> Glossy Program</td></tr>
		<tr><th>Show Name</th><td><input name="payment_glossy_name"
			value="<?php echo htmlspecialchars($values['payment_glossy_name']) ?>" /></td></tr>

			<tr><td colspan="2"><hr /></td></tr>
		<tr><td colspan="2"><input type="checkbox" name="payment_blackandwhite_program"
			<?php if ($values['payment_blackandwhite_program']) echo "checked "; ?> /> Black &amp; White Program</td></tr>
		<tr><th>Show Name</th><td><input name="payment_blackandwhite_name"
			value="<?php echo htmlspecialchars($values['payment_blackandwhite_name']) ?>" /></td></tr>

			<tr><td colspan="2"><hr /></td></tr>

		<tr><td colspan="2"><input type="checkbox" name="payment_tshirt"
			<?php if ($values['payment_tshirt']) echo "checked "; ?> /> T-Shirt</td></tr>
		<tr><th>Show Name</th><td><input name="payment_tshirt_name"
			value="<?php echo htmlspecialchars($values['payment_tshirt_name']) ?>" /></td></tr>
		<tr><th>Color</th><td><input name="payment_tshirt_color"
			value="<?php echo htmlspecialchars($values['payment_tshirt_color']) ?>" /></td></tr>
		<tr><th>Style</th><td><input type="checkbox" name="payment_tshirt_twosided"
			<?php if ($values['payment_tshirt_twosided']) echo "checked "; ?> /> Two-Sided Design</td></tr>

			<tr><td colspan="2"><hr /></td></tr>

		<tr><th colspan="2"><input type="submit" value="Save Changes" /></th></td>
	</table>
</form>



							</div>
						</section>



					</main>
				</div><!-- end before-sticky-footer -->
			</div><!-- end clearfix -->
		</div><!-- end contain-sticky-footer -->
<?php include('_footer.php'); ?>
	</div>
<?php $includePinterest = FALSE; include('_body.end.php'); ?>
	<script>
		$('.single').click(function() {
			$('#fileinput').removeAttr('multiple');
			$('#fileinput').removeAttr('disabled');
		});
		$('.multi').click(function() {
			$('#fileinput').attr('multiple', 'multiple');
			$('#fileinput').removeAttr('disabled');
		});

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


