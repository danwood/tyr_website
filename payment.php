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
$title='Tomorrow Youth Rep — Payment';
$description='Make an online payment to Tomorrow Youth Rep';
include('_head.php');
include('../_private.php'); // for variables
?>
</head>
<body id="page-payment" class="orange-block">
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
						<section id="payment" class="clearfix capped-width">
							<div class="inlinebox">
								<h2>Credit Card Payments</h2>
								<p>
									You can pay for program ads, T-shirts, etc. online here as they are available.  Our PayPal processor accepts all major credit cards.
								</p>
							</div>
						</section>






<?php
if ($payment_glossy_program) {
?>

						<section class="clearfix capped-width">
							<div class="inlinebox">



<h3><?php echo htmlspecialchars($payment_glossy_name); ?> Program Ad</h3>


<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="2TCNLDP3TJYSL">
<table>
<tr><td><input type="hidden" name="on0" value="Ad sizes">Ad sizes</td></tr><tr><td><select name="os0">
	<option value="Full Page - Color">Full Page - Color $240.00 USD</option>
	<option value="Full Page - B/W">Full Page - B/W $150.00 USD</option>
	<option value="Half Page - Color">Half Page - Color $160.00 USD</option>
	<option value="Half Page - B/W">Half Page - B/W $100.00 USD</option>
	<option value="Third Page - Color">Third Page - Color $80.00 USD</option>
	<option value="Third Page - B/W">Third Page - B/W $50.00 USD</option>
	<option value="Layout Service">Layout Service $50.00 USD</option>
	<option value="Personal Ad">Personal Ad $35.00 USD</option>
</select> </td></tr>
</table>
<br />
<br />
• Remember to add 'Layout Service' to your cart also, if you would like us to create your ad for you.
<br />
<br />
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>


							</div>
						</section>

<?php
}

if ($payment_blackandwhite_program) {
?>


						<section class="clearfix capped-width">
							<div class="inlinebox">


<h3><?php echo htmlspecialchars($payment_blackandwhite_name); ?> Program Ads</h3>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="TZAW6DPXXMFHS">
<table>
<tr><td><input type="hidden" name="on0" value="Sizes">Sizes</td></tr><tr><td><select name="os0">
	<option value="Personal 1/8 page">Personal 1/8 page $20.00 USD</option>
	<option value="Personal 1/4 page">Personal 1/4 page $35.00 USD</option>
	<option value="Personal 1/2 page">Personal 1/2 page $65.00 USD</option>
	<option value="Business 1/2 page">Business 1/2 page $100.00 USD</option>
	<option value="Business 1/2 page with layout service">Business 1/2 page with layout service $125.00 USD</option>
	<option value="Business Full page">Business Full page $200.00 USD</option>
	<option value="Business Full page with layout service">Business Full page with layout service $225.00 USD</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>


							</div>
						</section>

<?php
}

if ($payment_tshirt) {
?>

						<section class="clearfix capped-width">
							<div class="inlinebox">




<h3><?php echo htmlspecialchars($payment_tshirt_name); ?> T-Shirt</h3>

<p>
Cast members, buy a shirt for yourself, and extras for your family!
</p>
<p>
You can order multiple shirts if you want — pick a size and add to cart, then before you check out,
go "back" to this page to add additional shirts to your cart.
</p>
<p>
There are two main styles:  Ladies (trimmer cut, with a V-neck) and Youth/Adult (unisex).
</p>

<p>
Shirt will be
<?php
	echo htmlspecialchars($payment_tshirt_color);
	if ($payment_tshirt_twosided) {
		echo ", with design on the front and the back";
	}
?>.
</p>

<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="B6ZNZMYXQGFCC">
<table>
<tr><td><input type="hidden" name="on0" value="Sizes">Sizes</td></tr><tr><td><select name="os0">
	<option value="Ladies - XS">Ladies - XS $10.00 USD</option>
	<option value="Ladies - Small">Ladies - Small $10.00 USD</option>
	<option value="Ladies - Medium">Ladies - Medium $10.00 USD</option>
	<option value="Ladies - Large">Ladies - Large $10.00 USD</option>
	<option value="Ladies - XL">Ladies - XL $10.00 USD</option>
	<option value="Adult - XS">Adult - XS $10.00 USD</option>
	<option value="Adult - Small">Adult - Small $10.00 USD</option>
	<option value="Adult - M">Adult - M $10.00 USD</option>
	<option value="Adult - L">Adult - L $10.00 USD</option>
	<option value="Adult - XL">Adult - XL $10.00 USD</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>





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
