<?php

error_reporting(E_ALL);
date_default_timezone_set('America/Los_Angeles');

$authenticated = FALSE;

require_once($_SERVER['DOCUMENT_ROOT'] . '../_private.php');	// make sure it's level above document root NOT example

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

	if (isset($_POST['password']))
	{

		$password = trim($_POST['password']);
		$authenticated = ($password == $backstage_password);
		if ($authenticated)
		{
			$_SESSION['authenticated'] = 1;
		}
	}
	else
	{
		$authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] = 1;
	}
}
else
{
	$authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] = 1;
}

// If not authenticated, go login first.  Unless this global is set, in which case page that loads this can decide what to do.

if (!isset($ALLOW_UNAUTHENTICATED) || !$ALLOW_UNAUTHENTICATED) {
	if (!$authenticated) {
		header('Location: /backstage/login.php?return=' . urlencode($_SERVER['REQUEST_URI']));		// Force login first
	}
}
?>