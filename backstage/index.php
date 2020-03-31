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
		input[type=text] { width:100%; }

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
		<?php for ($i = 1 ; $i <= 3 ; $i++) { ?>

		<tr>
			<td>
				<input type="checkbox" class="hiding-checkbox" data-target="tuition-row-<?php echo $i; ?>" name="payment_tuition_<?php echo $i; ?>"
				<?php if (isset($values['payment_tuition_' . $i]) && $values['payment_tuition_' . $i]) echo "checked "; ?> /> Tuition button #<?php echo $i; ?>
			</td>
		</tr>
		<tr class="tuition-row-<?php echo $i; ?>">
			<th>Show/Class Name</th>
			<td><input type="text" name="payment_tuition_name_<?php echo $i; ?>"
			value="<?php echo htmlspecialchars($values['payment_tuition_name_' . $i]) ?>" /></td>
		</tr>

		<tr class="tuition-row-<?php echo $i; ?>">
			<th style="vertical-align: top">PayPal code block</th>
			<td>
				<textarea rows="12" cols="60" name="payment_tuition_code_<?php echo $i; ?>"><?php echo htmlspecialchars($values['payment_tuition_code_' . $i]) ?></textarea>
			</td>
		</tr>

		<?php } ?>


		<tr><td colspan="2"><hr /></td></tr>

		<tr><td><input type="checkbox" name="payment_glossy_program"
			<?php if (isset($values['payment_glossy_program']) && $values['payment_glossy_program']) echo "checked "; ?> /> Glossy Program</td></tr>
		<tr><th>Show Name</th><td><input type="text" name="payment_glossy_name"
			value="<?php echo htmlspecialchars($values['payment_glossy_name']) ?>" /></td></tr>

			<tr><td><hr /></td></tr>
			
		<tr><td><input type="checkbox" name="payment_blackandwhite_program"
			<?php if (isset($values['payment_blackandwhite_program']) && $values['payment_blackandwhite_program']) echo "checked "; ?> /> Black &amp; White Program</td></tr>
		<tr><th>Show Name</th><td><input type="text" name="payment_blackandwhite_name"
			value="<?php echo htmlspecialchars($values['payment_blackandwhite_name']) ?>" /></td></tr>

			<tr><td colspan="2"><hr /></td></tr>


		<tr><td><input type="checkbox" class="hiding-checkbox" data-target="tshirt-row-1" name="payment_tshirt"
			<?php if (isset($values['payment_tshirt']) && $values['payment_tshirt']) echo "checked "; ?> /> T-Shirt (Mainstage)</td></tr>
		<tr class="tshirt-row-1"><th>Show Name</th><td><input type="text" name="payment_tshirt_name"
			value="<?php echo htmlspecialchars($values['payment_tshirt_name']) ?>" /></td></tr>
		<tr class="tshirt-row-1"><th>Color</th><td><input type="text" name="payment_tshirt_color"
			value="<?php echo htmlspecialchars($values['payment_tshirt_color']) ?>" /></td></tr>
		<tr class="tshirt-row-1"><th>Style</th><td><input type="checkbox" name="payment_tshirt_twosided"
			<?php if (isset($values['payment_tshirt_twosided']) && $values['payment_tshirt_twosided']) echo "checked "; ?> /> Two-Sided Design</td></tr>

			<tr><td colspan="2"><hr /></td></tr>

		<tr><td><input type="checkbox" class="hiding-checkbox" data-target="tshirt-row-2" name="payment_tshirt2"
			<?php if (isset($values['payment_tshirt2']) && $values['payment_tshirt2']) echo "checked "; ?> /> T-Shirt (All-experiences)</td></tr>
		<tr class="tshirt-row-2"><th>Show Name</th><td><input type="text" name="payment_tshirt2_name"
			value="<?php echo htmlspecialchars($values['payment_tshirt2_name']) ?>" /></td></tr>
		<tr class="tshirt-row-2"><th>Color</th><td><input type="text" name="payment_tshirt2_color"
			value="<?php echo htmlspecialchars($values['payment_tshirt2_color']) ?>" /></td></tr>
		<tr class="tshirt-row-2"><th>Style</th><td><input type="checkbox" name="payment_tshirt2_twosided"
			<?php if (isset($values['payment_tshirt2_twosided']) && $values['payment_tshirt2_twosided']) echo "checked "; ?> /> Two-Sided Design</td></tr>

			<tr><td colspan="2"><hr /></td></tr>

		<tr><th><input type="submit" value="Save Changes" /></th></td>
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


		// Show/hide rows related to checkbox

		$( ".hiding-checkbox" ).click(function( event ) {
			var targetID = $(this).data('target');
			if ($(this).prop("checked") == true) {
				$('.' + targetID).show('slow');
			} else {
				$('.' + targetID).hide('slow');
			}
		});

		// And set up visibility initially

		$( ".hiding-checkbox" ).each(function() {
			var targetID = $(this).data('target');
			if ($(this).prop("checked") == true) {
				$('.' + targetID).show();
			} else {
				$('.' + targetID).hide();
			}
		});


	</script>
</body>
</html>


