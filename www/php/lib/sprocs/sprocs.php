<?php

class SProc
{
	private $procedureName;
	private $inParamCount;

	public function __construct($mProcedureName, $mInParamCount)
	{
		$this->procedureName = $mProcedureName;
		$this->inParamCount = $mInParamCount;
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
}

SPRCS::$mkContentThread = new SProc('mk_content_thread', 3);
SPRCS::$mkContentPost = new SProc('mk_content_post', 3);
SPRCS::$mkContentAttachment = new SProc('mk_content_attachment', 3);

SPRCS::$mkSubscriptionUser = new SProc('mk_subscription_user', 2);
SPRCS::$mkSubscriptionThread = new SProc('mk_subscription_thread', 2);
SPRCS::$mkSubscriptionTag = new SProc('mk_subscription_tag', 2);

SPRCS::$mkNotificationUser = new SProc('mk_notification_user', 2);
SPRCS::$mkNotificationThread = new SProc('mk_notification_thread', 2);
SPRCS::$mkNotificationTag = new SProc('mk_notification_tag', 2);

?>