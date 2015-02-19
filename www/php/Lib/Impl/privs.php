<?php

class Privs
{
	public static $count = 1;

	public static $superAdmin = 0;
}

class PrivSet
{
	private $bits = "";

	public function __construct(...$mPrivs)
	{
		$this->bits = str_repeat('F', Privs::$count);

		foreach($mPrivs as $x) $this->add($x);
	}

	public static function fromStr($mX)
	{
		$res = new PrivSet();
		$res->bits = $mX;
		return $res;
	}

	public function toStr()
	{
		return $this->bits;
	}

	public function add($mX)
	{
		$this->bits[$mX] = 'T';
	}

	public function del($mX)
	{
		$this->bits[$mX] = 'F';
	}

	public function has($mX)
	{
		return $this->bits[$mX] == 'T';
	}

	public function isEqualTo($mX)
	{
		for($i = 0; $i < Privs::$count; $i++)
			if($this->has($i) != $mX->has($i))
				return false;

		return true;
	}

	public function getOrWith($mX)
	{
		$res = new PrivSet();
		
		for($i = 0; $i < Privs::$count; $i++)
			if($this->has($i) || $mX->has($i))
				$res->add($i);

		return $res;
	}

	public function getAndWith($mX)
	{
		$res = new PrivSet();
		
		for($i = 0; $i < Privs::$count; $i++)		
			if($this->has($i) && $mX->has($i))			
				$res->add($i);		

		return $res;
	}
}

?>