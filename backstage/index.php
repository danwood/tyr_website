<?php
require_once('_authenticate.php');	// Login required
require_once('../_functions.php');
require_once('../_classes.php');
require_once('../_globals.php');

require_once('../_parse_config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='../';	// Needed for prelude since we aren't at top level directory
$title='Tomorrow Youth Rep — Backstage';
$description='';
include('../_head.php');
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
include('../_header.php'); ?>
					<main>
						<section id="upload" class="clearfix capped-width">
							<div class="inlinebox">
								<h2>Backstage</h2>

								<h3>Manage Events</h3>

<p><a href="edit.php">Add a new event</a> or <a href="db.php">edit existing events</a>.</p>
<p>View website using <a href="<?php echo $root; ?>index.php?when=<?php echo date('Y-m-d'); ?>">Time Machine</a>.</p>

<p>Advanced: <a href="<?php echo $root; ?>phpliteadmin.php">Direct database admin</a> (requires separate password).</p>

<p>Advanced: <a href="<?php echo $root; ?>reload.php">Rebuild the web pages</a> (needed after changing the HTML).</p>

						<section id="payment" class="clearfix capped-width">
							<div class="inlinebox">
								<h3>Configure <a href="<?php echo $root; ?>pay">Payment Page</a></h3>

<?php
$values = read_config();
// write_config($values);
?>
<form method="POST" action="updateconfig.php">
	<table>
		<tr><td colspan="2"><input type="checkbox" name="payment_tuition"
			<?php if ($values['payment_tuition']) echo "checked "; ?> /> Tuition button #1</td></tr>
		<tr><th>Show Name</th><td><input name="payment_tuition_name"
			value="<?php echo htmlspecialchars($values['payment_tuition_name']) ?>" /></td></tr>

		<tr><td colspan="2"><input type="checkbox" name="payment_tuition_2"
			<?php if ($values['payment_tuition_2']) echo "checked "; ?> /> Tuition button #2 (split-level)</td></tr>
		<tr><th>Show Name</th><td><input name="payment_tuition_name_2"
			value="<?php echo htmlspecialchars($values['payment_tuition_name_2']) ?>" /></td></tr>

			<tr><td colspan="2"><hr /></td></tr>

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
			<?php if ($values['payment_tshirt']) echo "checked "; ?> /> T-Shirt (Mainstage)</td></tr>
		<tr><th>Show Name</th><td><input name="payment_tshirt_name"
			value="<?php echo htmlspecialchars($values['payment_tshirt_name']) ?>" /></td></tr>
		<tr><th>Color</th><td><input name="payment_tshirt_color"
			value="<?php echo htmlspecialchars($values['payment_tshirt_color']) ?>" /></td></tr>
		<tr><th>Style</th><td><input type="checkbox" name="payment_tshirt_twosided"
			<?php if ($values['payment_tshirt_twosided']) echo "checked "; ?> /> Two-Sided Design</td></tr>

			<tr><td colspan="2"><hr /></td></tr>

		<tr><td colspan="2"><input type="checkbox" name="payment_tshirt2"
			<?php if ($values['payment_tshirt2']) echo "checked "; ?> /> T-Shirt (All-experiences)</td></tr>
		<tr><th>Show Name</th><td><input name="payment_tshirt2_name"
			value="<?php echo htmlspecialchars($values['payment_tshirt2_name']) ?>" /></td></tr>
		<tr><th>Color</th><td><input name="payment_tshirt2_color"
			value="<?php echo htmlspecialchars($values['payment_tshirt2_color']) ?>" /></td></tr>
		<tr><th>Style</th><td><input type="checkbox" name="payment_tshirt2twosided"
			<?php if ($values['payment_tshirt2_twosided']) echo "checked "; ?> /> Two-Sided Design</td></tr>

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
<?php include('../_footer.php'); ?>
	</div>
<?php $includePinterest = FALSE; include('../_body.end.php'); ?>
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


