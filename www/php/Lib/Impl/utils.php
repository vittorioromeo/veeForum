<?php

// Copyright (c) 2013-2015 Vittorio Romeo
// License: Academic Free License ("AFL") v. 3.0
// AFL License page: http://opensource.org/licenses/AFL-3.0

class Utils
{
	public static function getCSL($mArray)
	{
		$res = "";

		for ($x = 0; $x < count($mArray); ++$x) 
		{	
			$res .= $mArray[$x];
			if($x < count($mArray) - 1) $res .= ", ";
		}

		return $res;
	}

	public static function getPwdHash($mX)
	{
		return md5($mX);
	}

	public static function checkEmptyStr($mX, &$mMsg)
	{
		if(trim($mX) == "''")
		{
			$mMsg = "String not valid, empty or whitespace.";
			return false;
		}

		return true;
	}

	public static function getInsertParent(&$mTbl, $mIDParent, &$mMsg)
	{
		if($mIDParent == -1) return 'null';
		
		if(!$mTbl->hasID($mIDParent))
		{
			$mMsg = "Invalid parent ID: $mIDParent";
			return false;
		}

		return $mIDParent;
	}
}

?>