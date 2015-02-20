<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/php/lib/lib.php");

if(!Creds::isLoggedIn())
{
	require_once("$root/php/core/body/loginControls.php");
}
else
{
	require_once("$root/php/core/body/profileControls.php");
}
?>