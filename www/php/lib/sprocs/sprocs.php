<?php

// TODO: code repetition
class SProc
{
	private $procedureName;
	private $inParamCount;
	private $outParamCount;

	public function __construct($mProcedureName, $mInParamCount, $mOutParamCount)
	{
		$this->procedureName = $mProcedureName;
		$this->inParamCount = $mInParamCount;
		$this->outParamCount = $mOutParamCount;
	}

	public function call(...$mArgs)
	{
		if(count($mArgs) != $this->inParamCount)
		{
			$err = "Error: count of passed values does not match count of sproc parameters.";
			Debug::lo($err);
			return false;	
		}

		$argsStr = '';
		for($i = 0; $i < count($mArgs); ++$i) 
		{	
			$argsStr .= DB::v($mArgs[$i]);
			if($i < count($mArgs) - 1) $argsStr .= ', ';
		}

		$queryStr = 'call '.$this->procedureName.'('.$argsStr.');';		
		$res = DB::query($queryStr);

		if(!$res) 
		{
			$err = 'Error: call to '.$this->procedureName.' failed: '.DB::$lastError;
			Debug::lo($err);
			return false;
		}

		return $res;
	}

	public function callOut(&$mOutArray, ...$mArgs)
	{
		if(count($mArgs) != $this->inParamCount)
		{
			$err = "Error: count of passed values does not match count of sproc parameters.";
			Debug::lo($err);
			return false;	
		}

		$argsStr = '';
		for($i = 0; $i < count($mArgs); ++$i) 
		{	
			$argsStr .= DB::v($mArgs[$i]);
			if($i < count($mArgs) - 1) $argsStr .= ', ';
		}

		$outStr = '';
		for($i = 0; $i < $this->outParamCount; ++$i) 
		{	
			$outStr .= '@r'.$i;
			if($i < $this->outParamCount - 1) $outStr .= ', ';
		}

		$queryStr = 'call '.$this->procedureName.'('.$argsStr.', '.$outStr.');';		
		$res = DB::query($queryStr);

		if(!$res) 
		{
			$err = 'Error: call to '.$this->procedureName.' failed: '.DB::$lastError;
			Debug::lo($err);
			return false;
		}

		$mOutArray = [];
		for($i = 0; $i < $this->outParamCount; ++$i) 
		{
			$key = '@r'.$i;
			$qres = DB::query('SELECT '.$key.';');
			array_push($mOutArray, $qres->fetch_assoc()[$key]); 
		}

		return $res;
	}
}

class SPRCS
{
	public static $mkContentThread;
	public static $mkContentPost;
	public static $mkContentAttachment;

	public static $mkSubscriptionUser;
	public static $mkSubscriptionThread;
	public static $mkSubscriptionTag;

	public static $mkNotificationUser;
	public static $mkNotificationThread;
	public static $mkNotificationTag;

	public static $calcFinalPrivs;
	public static $calcFinalPerms;
}

SPRCS::$mkContentThread = new SProc('mk_content_thread', 3, 0);
SPRCS::$mkContentPost = new SProc('mk_content_post', 3, 0);
SPRCS::$mkContentAttachment = new SProc('mk_content_attachment', 3, 0);

SPRCS::$mkSubscriptionUser = new SProc('mk_subscription_user', 2, 0);
SPRCS::$mkSubscriptionThread = new SProc('mk_subscription_thread', 2, 0);
SPRCS::$mkSubscriptionTag = new SProc('mk_subscription_tag', 2, 0);

SPRCS::$mkNotificationUser = new SProc('mk_notification_user', 2, 0);
SPRCS::$mkNotificationThread = new SProc('mk_notification_thread', 2, 0);
SPRCS::$mkNotificationTag = new SProc('mk_notification_tag', 2, 0);

SPRCS::$calcFinalPrivs = new SProc('calculate_final_privileges', 1, 5);
SPRCS::$calcFinalPerms = new SProc('calculate_final_permissions', 2, 6);

?>