<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/php/lib/lib.php");
?>

<br/>

<?php
	if(Creds::isLoggedIn())
	{
		print('<strong>Permissions not valid to view this page.</strong>');
	}
	else
	{
		print('<strong>User not logged in.</strong>');
	}
?>