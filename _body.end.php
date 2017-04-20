<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script>!window.jQuery && document.write('<script src="<?php echo htmlspecialchars($root); ?>js/jquery-1.12.4.min.js"><\/script>')</script>
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
