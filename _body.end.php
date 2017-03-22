	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?php echo htmlspecialchars($root); ?>js/jquery-1.10.1.min.js"><\/script>')</script>
<?php
if ($includePinterest)
{
?>
	<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
<?php
}
?>
	<script>
// Reveal Main Menus
$(".navmenu").click(function() {
	$('.hideablenav').toggleClass('revealed-nav');
});
	</script>
