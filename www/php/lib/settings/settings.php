<?php

class Settings
{
	private static $path;
	private static $data;

	public static function init()
	{
		$root = realpath($_SERVER["DOCUMENT_ROOT"]);
		Settings::$path = "$root/json/settings.json";
	}

	public static function loadFromFile()
	{	
		Settings::$data = json_decode(file_get_contents(Settings::$path), true);
	}
	public static function saveToFile()
	{
		file_put_contents(Settings::$path, json_encode(Settings::$data));
	}

	public static function setForumName($mX)
	{
		Settings::$data["forumName"] = $mX;
	}
	public static function getForumName()
	{
		return Settings::$data["forumName"];
	}

	public static function getDefaultGroup($mX)
	{
		Settings::$data["defaultGroup"] = $mX;
	}
	public static function setDefaultGroup()
	{
		return Settings::$data["defaultGroup"];
	}
}

Settings::init();
Settings::loadFromFile();

?>