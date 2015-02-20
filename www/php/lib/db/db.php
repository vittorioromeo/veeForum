<?php

class DB
{
	public static $conn;
	public static $lastError;

	private static function reportError($mX)
	{
		DB::$lastError .= $mX;
		Debug::lo($mX);
	}	

	public static function connect()
	{
		DB::$conn = new mysqli("localhost", "root", "root", "db_forum");

		if(DB::$conn->connect_errno) 
		{
			DB::reportError("Failed to connect to MySQL: (" . DB::$conn->connect_errno . ") " . DB::$conn->connect_error);
		}
	}

	public static function query($mX)
	{		
		Debug::lo("Executing query: " . $mX);

		$res = DB::$conn->query($mX);

		if(!$res)
		{
			DB::reportError("Query failed: (" . DB::$conn->errno . ") " . DB::$conn->error);		
			return null;
		}

		return $res;
	}

	public static function getInsertedID()
	{
		return DB::$conn->insert_id;
	}

	public static function esc($mX)
	{
		return DB::$conn->real_escape_string($mX);
	}

	public static function v($mX)
	{
		$res = DB::esc($mX);
		if($res == 'null') return $res;
		if($res == 'true') return 'true';
		if($res == 'false') return 'false';
		return "'$res'";
	}
}

DB::connect();
Debug::lo(DB::$conn->host_info . "\n");

?>