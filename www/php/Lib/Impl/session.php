<?php

// Copyright (c) 2013-2015 Vittorio Romeo
// License: Academic Free License ("AFL") v. 3.0
// AFL License page: http://opensource.org/licenses/AFL-3.0

class SK
{
	public static $userID = "A1";
	public static $debugLog = "A2";
	public static $debugEnabled = "A3";
	public static $pageID = "pageid";
	public static $threadID = "threadid";
}

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