<?php

class PrivSet
{
	private $bits = "";

	public function __construct(...$mPrivs)
	{
		$this->bits = str_repeat('F', Privs::count);

		foreach($mPrivs as $x) $this->add($x);
	}

	public static function fromStr($mX)
	{
		$res = new PrivSet();
		$res->bits = $mX;
		return $res;
	}

	public static function fromGroup($mX)
	{
		$res = new PrivSet();
		if($mX['is_superadmin']) $res->add(Privs::isSuperAdmin);
		if($mX['can_manage_sections']) $res->add(Privs::canManageSections);
		if($mX['can_manage_users']) $res->add(Privs::canManageUsers);
		if($mX['can_manage_groups']) $res->add(Privs::canManageGroups);
		if($mX['can_manage_permissions']) $res->add(Privs::canManagePermissions);
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
		for($i = 0; $i < Privs::count; $i++)
			if($this->has($i) != $mX->has($i))
				return false;

		return true;
	}

	public function getOrWith($mX)
	{
		$res = new PrivSet();
		
		for($i = 0; $i < Privs::count; $i++)
			if($this->has($i) || $mX->has($i))
				$res->add($i);

		return $res;
	}

	public function getAndWith($mX)
	{
		$res = new PrivSet();
		
		for($i = 0; $i < Privs::count; $i++)		
			if($this->has($i) && $mX->has($i))			
				$res->add($i);		

		return $res;
	}
}

?>