<?php

require_once("$rootLib/session/impl/sk.php");

class Session
{
	public static function init()
	{
		session_start();
	}

	public static function get($mX)
	{
		if(!isset($_SESSION[$mX]) || empty($_SESSION[$mX]) || $_SESSION[$mX] == null) return null;
		return $_SESSION[$mX];
	}

	public static function set($mX, $mVal)
	{
		$_SESSION[$mX] = $mVal;
	}	
}

?>