<?php require_once('_prelude.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='';
$title='Tomorrow Youth Rep — Donate';
$description='Your donations can help Tomorrow Youth Repertory, musical theatre program based in Alameda California.';
include('_head.php');
?>
	<style>

.thumbnail {
	border:5px solid white;}

.person {
	font-variant:small-caps;
	font-weight:bold;
}


	</style>
</head>
<body id="page-donate" class="orange-block">
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
						<section class="clearfix capped-width">
							<div class="inlinebox">
								<h2>Donate to Tomorrow Youth Rep</h2>
							</div>
							<div class="inlinebox video">
								<div class='youtube-container'>
									<iframe src='//www.youtube.com/embed/DbH2RIF3178?showinfo=0&amp;rel=0' frameborder='0' allowfullscreen></iframe>
								</div>
							</div>
							<div class="inlinebox">

<p>
  Can you help us continue to supply the wonderful programs and productions that we offer to the community?  While TYR is adept at operating efficiently with sometimes thin budgets, the truth of the matter is that we rely on your support in order to bring memorable productions for the kids, and the very best of instructors and staff.
</p>
<p>
  Take a moment to donate — even if it’s just a few dollars — it goes a long way to helping us continue to provide the programs that you love.
</p>
<p>
	Tomorrow Youth Repertory is a registered 501c(3) non-profit organization, and all donations are tax deductible. Our EIN/Tax ID is 45-5544176.
</p>

<p>You can donate any amount online, one-time or monthly, right now:

	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="D9YMBDWGUL9SY">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</p>
<p>
	<img class="snapshot floated large-block opposite" alt="A girl waits in the wings to go onstage in Narnia production" src="<?php echo htmlspecialchars($root); ?>img/misc-tech-rehearsal.jpg" />
Or you can send a check of any amount to:
</p>
<p>
	Tomorrow Youth Rep<br />
	P.O. Box 793<br />
	Alameda, CA 94501
</p>



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


