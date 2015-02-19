<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$rootLib = "$root/php/lib/";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);
date_default_timezone_set('UTC');

require_once("$rootLib/settings/settings.php");
require_once("$rootLib/session/session.php");
require_once("$rootLib/debug/debug.php");
require_once("$rootLib/db/db.php");
require_once("$rootLib/privs/privs.php");
require_once("$rootLib/pages/pages.php");
require_once("$rootLib/utils/utils.php");
require_once("$rootLib/gen/gen.php");
require_once("$rootLib/creds/creds.php");
require_once("$rootLib/tbl/tbl.php");

Session::init();

?>