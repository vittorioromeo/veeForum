<?php

class Debug
{
	public static function setEnabled($mX)
	{
		Session::set(SK::$debugEnabled, $mX);
		Session::set(SK::$debugLog, "");
	}

	public static function isEnabled()
	{
		return Session::get(SK::$debugEnabled);
	}

	public static function lo($mX)
	{
		if(!Debug::isEnabled()) return;

		$value = Session::get(SK::$debugLog);
		$value .= $mX . '<br/>';
		Session::set(SK::$debugLog, $value);
	}

	public static function loLn()
	{
		Debug::lo('<br/>-------------------<br/>');
	}

	public static function echoLo()
	{
		if(!Debug::isEnabled()) return;

		print('<br/><hr><br/>');
		print(Session::get(SK::$debugLog));
	}
}

?>