<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$rootCB = "$root/php/core/body";
require_once("$root/php/lib/lib.php");

(new Container())
	->file($rootCB . (Creds::isLoggedIn() ? '/profileControls.php' : '/loginControls.php'))
->printRoot();

?>