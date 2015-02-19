<?php

class PK
{
	public static $sections = 0;
	public static $administration = 1;
	public static $threadView = 2;
}

class PageData
{
	private $url;
	private $privs;

	public function __construct($mURL, $mPrivs)
	{
		$this->url = $mURL;
		$this->privs = $mPrivs;
	}

	public function getURL() 
	{ 
		return $this->url; 
	}

	public function getPrivs() 
	{
	 	return $this->privs; 
	}

	public function canViewWithPrivs($mX)
	{
		return $this->privs->getAndWith($mX)->isEqualTo($this->privs);
	}
}

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

Pages::add("php/Core/content/sections.php", new PrivSet());
Pages::add("php/Core/content/adminPanel.php", new PrivSet(Privs::$superAdmin));
Pages::add("php/Core/content/threadView.php", new PrivSet());

?>