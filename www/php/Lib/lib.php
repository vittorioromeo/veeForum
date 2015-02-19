<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$rootLibImpl = "$root/php/Lib/Impl";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);
date_default_timezone_set('UTC');

require_once("$rootLibImpl/session.php");
require_once("$rootLibImpl/debug.php");
require_once("$rootLibImpl/db.php");
require_once("$rootLibImpl/privs.php");
require_once("$rootLibImpl/pages.php");
require_once("$rootLibImpl/utils.php");
require_once("$rootLibImpl/gen.php");
require_once("$rootLibImpl/credentials.php");
require_once("$rootLibImpl/tbl.php");
require_once("$rootLibImpl/tblImpl.php");

Session::init();

?>