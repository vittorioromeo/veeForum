<?php

class Pages
{
	private static $pdarray = [];

	public static function add(...$mArgs)
	{
		array_push(Pages::$pdarray, new PageData(...$mArgs));
	}

	public static function get($mX)
	{		
		return Pages::$pdarray[(int)$mX];
	}

	public static function setCurrent($mX)
	{
		Session::set(SK::$pageID, (int)$mX);
	}	

	public static function getCurrent()
	{
		return Pages::get((int)Session::get(SK::$pageID));
	}
}

Pages::add("php/core/content/sections.php");
Pages::add("php/core/content/adminPanel.php", Privs::isSuperAdmin);
Pages::add("php/core/content/threadView.php");

?>