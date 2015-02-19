<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/php/Lib/lib.php");
?>

<?php
	if(!Credentials::isLoggedIn())
	{
		require_once("$root/php/Core/body/loginControls.php");
	}
	else
	{
		require_once("$root/php/Core/body/profileControls.php");
	}
?>