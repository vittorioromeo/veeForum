<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/php/lib/lib.php");

	$msg = Creds::isLoggedIn() ? 'Permissions not valid to view this page.' : 'User not logged in.';

	(new Container())
		->br()
		->strong($msg)
	->printRoot();
?>