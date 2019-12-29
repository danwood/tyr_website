<?php
require_once('_functions.php');
require_once('_classes.php');
require_once('_globals.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='';
$title='Tomorrow Youth Rep — Tuition';
$description='Make an online tuition payment to Tomorrow Youth Rep';
include('_head.php');
include('../_private.php'); // for variables
?>
</head>
<body id="page-tuition" class="orange-block">
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
						<section id="tuition" class="clearfix capped-width">
							<div class="inlinebox">
								<h2>Credit Card Tuition Payments</h2>
								<p>
									You can pay for tuition here AFTER you have completed your online registration.  Our PayPal processor accepts all major credit cards.
								</p>
							</div>
						</section>




<?php
if ($payment_tuition || $payment_tuition_2) {
	if ($payment_tuition) {
?>

						<section class="clearfix capped-width">
							<div class="inlinebox">



<h3>Tuition for <?php echo htmlspecialchars($payment_tuition_name); ?></h3>
<p>You must have already registered for the class.</p>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="S23KQJ329QXAA">
<table>
<tr><td><input type="hidden" name="on0" value="TUITION for (Student's name)">Student's name</td></tr><tr><td><input type="text" name="os0" maxlength="200"></td></tr>
</table>
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>






							</div>
						</section>

<?php
	}
	if ($payment_tuition_2) {

?>

						<section class="clearfix capped-width">
							<div class="inlinebox">



<h3>Tuition for <?php echo htmlspecialchars($payment_tuition_name_2); ?></h3>
<p>You must have already registered for the class.</p>

<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="DKE3GMBUKD4WA">
<table>
<tr><td><input type="hidden" name="on0" value="Class level">Class level</td></tr><tr><td><select name="os0">
<option value="ELEMENTARY section">ELEMENTARY section $395.00 USD</option>
<option value="TEEN section">TEEN section $425.00 USD</option>
</select> </td></tr>
<tr><td><input type="hidden" name="on1" value="TUITION for (Student's name)">Student's name</td></tr><tr><td><input type="text" name="os1" maxlength="200"></td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>







							</div>
						</section>

<?php
	}
}
else {
?>

						<section class="clearfix capped-width">
							<div class="inlinebox">

	<p>Sorry, no classes configured for accepting tuition right now.</p>

							</div>
						</section>
<?php

}
?>





					</main>
				</div><!-- end before-sticky-footer -->
			</div><!-- end clearfix -->
		</div><!-- end contain-sticky-footer -->
<?php include('_footer.php'); ?>
	</div>
<?php $includePinterest = FALSE; include('_body.end.php'); ?>
</body>
</html>
