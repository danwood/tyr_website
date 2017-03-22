<?php require_once('_prelude.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='';
$title='Tomorrow Youth Rep — Payment';
$description='Make an online payment to Tomorrow Youth Rep';
include('_head.php');
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
						<section class="clearfix capped-width">
							<div class="inlinebox">









<!-- This is the generic Glossy-Program form.  Just un-comment this whole section below and put in the title of the show, and we are set! -->



<h3>Glossy Program Ad</h3>


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



<!-- This is the lower-cost ad form - lower costs.  Just un-comment this whole section below and put in the title of the show, and we are set! -->

<!--

<h3>Glossy Program Ad</h3>

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

-->





							</div>
						</section>
						<section class="clearfix capped-width">
							<div class="inlinebox">




<!-- This is the generic T-shirt form.  Just un-comment this whole section below and put in the title/description of the show, and we are set!





<h3>Mysterious Mainstage T-Shirt</h3>

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
	Shirt will be black, with design on the front and the back.
</p>

	<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="9XB6R5FAWMLTJ">
<table>
<tr><td><input type="hidden" name="on0" value="Sizes">Sizes</td></tr><tr><td><select name="os0">
	<option value="Youth - Medium (8)">Youth - Medium (8) $10.00 USD</option>
	<option value="Youth - Large (10-12)">Youth - Large (10-12) $10.00 USD</option>
	<option value="Adult - Small">Adult - Small $10.00 USD</option>
	<option value="Adult - Medium">Adult - Medium $10.00 USD</option>
	<option value="Adult - Large">Adult - Large $10.00 USD</option>
	<option value="Adult - XL">Adult - XL $10.00 USD</option>
	<option value="Ladies - S">Ladies - S $10.00 USD</option>
	<option value="Ladies - M">Ladies - M $10.00 USD</option>
	<option value="Ladies - L">Ladies - L $10.00 USD</option>
	<option value="Ladies - XL">Ladies - XL $10.00 USD</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>





							</div>
						</section>
						<section class="clearfix capped-width">
							<div class="inlinebox">



<!-- This is the generic All-Experiences form.  Just un-comment this whole section below and put in the title of the show, and we are set! -->


<!--

<h3>_________________ Program Ad</h3>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="Y5865TW69NNKA">
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

-->















							</div>
						</section>
					</main>
				</div><!-- end before-sticky-footer -->
			</div><!-- end clearfix -->
		</div><!-- end contain-sticky-footer -->
<?php include('_footer.php'); ?>
	</div>
<?php $includePinterest = FALSE; include('_body.end.php'); ?>
</body>
</html>
