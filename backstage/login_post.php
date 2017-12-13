<?php
$ALLOW_UNAUTHENTICATED = TRUE;
require_once('_authenticate.php');

$return = '';

if (isset($_POST['return']))
{
	$return = $_POST['return'];
}
if ($authenticated && !empty($return))
{
	header('Location: ' . $return);		// Logged in; go to destination page.
	exit;
}
header('Location: /backstage/login.php');		// Logged in; go to destination page.

?>