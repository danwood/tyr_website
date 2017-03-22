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
	<link rel="stylesheet" href="<?php echo htmlspecialchars($root); ?>style/styles.css?md=20140826" />
	<link rel="stylesheet" href="<?php echo htmlspecialchars($root); ?>style/grid.css?md=20140826" />
	<link rel="stylesheet" href="<?php echo htmlspecialchars($root); ?>style/header.css?md=20140826" />
	<link rel="shortcut icon" href="<?php echo htmlspecialchars($root); ?>icon/favicon.ico?md=20140826" type="image/x-icon" />
	<link rel="apple-touch-icon" href="<?php echo htmlspecialchars($root); ?>icon/apple-touch-icon.png?md=20140826" />
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo htmlspecialchars($root); ?>icon/apple-touch-icon-57x57.png?md=20140826" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo htmlspecialchars($root); ?>icon/apple-touch-icon-72x72.png?md=20140826" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo htmlspecialchars($root); ?>icon/apple-touch-icon-76x76.png?md=20140826" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo htmlspecialchars($root); ?>icon/apple-touch-icon-114x114.png?md=20140826" />
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo htmlspecialchars($root); ?>icon/apple-touch-icon-120x120.png?md=20140826" />
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo htmlspecialchars($root); ?>icon/apple-touch-icon-144x144.png?md=20140826" />
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo htmlspecialchars($root); ?>icon/apple-touch-icon-152x152.png?md=20140826" />

	<!--<![endif]-->
	<!--[if lte IE 7]>
	<link rel="stylesheet" type="text/css" media="screen, projection" href="http://universal-ie6-css.googlecode.com/files/ie6.0.3.css" />
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


