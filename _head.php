	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title><?php echo htmlspecialchars($title); ?></title>
	<link rel="dns-prefetch" href="//ajax.googleapis.com" />
	<link rel="dns-prefetch" href="//fonts.googleapis.com" />
	<link rel="dns-prefetch" href="//www.facebook.com" />
	<meta name="description" content="<?php echo htmlspecialchars($description); ?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta name="author" content="Tomorrow Youth Repertory" />
	<meta name="geo.region" content="US-CA" />
	<meta name="geo.placename" content="Alameda" />
	<!--[if gte IE 8]><!-->
	<link href='http://fonts.googleapis.com/css?family=Homenaje%7CDroid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="<?php echo $root; ?>style/styles.css?cb=20171215" />
	<link rel="stylesheet" href="<?php echo $root; ?>style/grid.css?cb=20171215" />
	<link rel="stylesheet" href="<?php echo $root; ?>style/header.css?cb=20171215" />
	<link rel="shortcut icon" href="<?php echo $root; ?>icon/favicon.ico?cb=20171215" type="image/x-icon" />
	<link rel="apple-touch-icon" href="<?php echo $root; ?>icon/apple-touch-icon.png?cb=20171215" />
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $root; ?>icon/apple-touch-icon-57x57.png?cb=20171215" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $root; ?>icon/apple-touch-icon-72x72.png?cb=20171215" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $root; ?>icon/apple-touch-icon-76x76.png?cb=20171215" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $root; ?>icon/apple-touch-icon-114x114.png?cb=20171215" />
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $root; ?>icon/apple-touch-icon-120x120.png?cb=20171215" />
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $root; ?>icon/apple-touch-icon-144x144.png?cb=20171215" />
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $root; ?>icon/apple-touch-icon-152x152.png?cb=20171215" />
	<!--<![endif]-->

	<!--[if lte IE 9]>
    <style>header, main { display: none }
    <![endif]-->

<?php
if (isset($event) && $event)
{
	$event->outputHeadTags();
}
else
{
	echo "<!-- no event for meta tags -->\n";
}
?>


