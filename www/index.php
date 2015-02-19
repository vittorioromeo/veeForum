<!doctype html>
<html>

<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/php/Lib/lib.php");
require_once("$root/php/Core/head.php");
require_once("$root/php/Core/body.php");

Debug::loLn();
Debug::lo("<br/>Session ID: <br/>".session_id()); 
Debug::lo("<br/>Session data: <br/>".print_r($_SESSION, true));

?>

<div id="debugLo">
	<?php Debug::echoLo(); ?>
</div>

</html>