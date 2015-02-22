<?php

class PageData
{
	private $url;
	private $privs;

	public function __construct($mURL, ...$mPrivs)
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
		foreach($this->privs as $p)		
			if(!$mX[$p]) return false;
		
		return true;
	}
}

?>