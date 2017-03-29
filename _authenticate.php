<?php

error_reporting(E_ALL);
date_default_timezone_set('America/Los_Angeles');

$authenticated = FALSE;

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	error_log(print_r($_POST, 1));

	if (isset($_POST['password']))
	{
	error_log("password");
		$password = trim($_POST['password']);
		$authenticated = ($password == 'XXX');
		if ($authenticated)
		{
	error_log("matches!");
			$_SESSION['authenticated'] = 1;
		}
	}
	else
	{
	error_log("only authenticated if already authenticated");
		$authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] = 1;
	}
}
else
{
	error_log("not post");
	$authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] = 1;
}

// If not authenticated, go login first.  Unless this global is set, in which case page that loads this can decide what to do.

if (!isset($ALLOW_UNAUTHENTICATED) || !$ALLOW_UNAUTHENTICATED) {
	if (!$authenticated) {
		header('Location: /login.php?return=' . urlencode($_SERVER['REQUEST_URI']));		// Force login first
	}
}

?>