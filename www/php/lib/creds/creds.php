<?php

class Perms
{
	const count = 6;

	const view = 0;
	const post = 1;
	const addThread = 2;
	const delPost = 3;
	const delThread = 4;
	const delSection = 5;
}

class Creds
{
	public static function isLoggedIn()
	{
		return Session::get(SK::$userID) != null;
	}

	public static function tryLogin($mUser, $mPass)
	{
		$row = TBS::$user->findByCreds($mUser, $mPass);

		if(!$row)
		{
			Debug::lo("Invalid credentials: $mUser, $mPass");
			Session::set(SK::$userID, null);
			return false;
		}
		
		Debug::lo("Login successful: $mUser, $mPass");			
		Session::set(SK::$userID, $row['id']);		
		Pages::setCurrent(PK::$sections);
		return true;		
	}

	public static function tryLogout()
	{		
		Session::set(SK::$userID, null);
		return true;
	}

	public static function getCUID()
	{
		return Session::get(SK::$userID);
	}

	public static function getCURow()
	{
		return TBS::$user->findByID(Creds::getCUID());
	}

	public static function getCUPrivRow()
	{
		SPRCS::$calcFinalPrivs->callOut($res, Creds::getCUID());		
		return $res;
	}

	public static function getCUPermRow($mSID)
	{		
		SPRCS::$calcFinalPerms->callOut($res, Creds::getCUID(), $mSID);
		return $res;
	}


	public static function canCUViewCurrentPage()
	{
		return Pages::getCurrent()->canViewWithPrivs(Creds::getCUPrivRow());
	}

	public static function hasCUPriv($mX)
	{
		return Creds::getCUPrivRow()[$mX];
	}

	public static function hasCUPerm($mSID, $mX)
	{
		return Creds::getCUPermRow($mSID)[$mX];
	}
}

?>