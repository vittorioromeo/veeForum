<?php

class TBS
{
	public static $log;
	public static $tag;
	public static $group;
	public static $user;
	public static $section;

	public static $cntBase;
	public static $cntThread;
	public static $cntPost;
	public static $cntAttachment;

	public static $subBase;
	public static $subThread;
	public static $subUser;
	public static $subTag;

	public static $ntfBase;
	public static $ntfThread;
	public static $ntfUser;
	public static $ntfTag;

	public static $tagContent; // TODO
	public static $fileData; // TODO

	public static $gsperms;
}

class LogType
{
	const __default = self::Info;

	const Info = 0;
	const Error = 1;
	const Debug = 2;
}

class TblLog extends Tbl
{
	public function mk($mType, $mX)
	{
		$this->insertValues($mType, date('Y-m-d G:i:s'), $mX);
	}
}

class TblTag extends Tbl
{
	public function mk($mX)
	{
		$this->insertValues($mX);
	}
}



class TblSubThread extends Tbl
{
	public function mk(...$mArgs)
	{
		return SPRCS::$mkSubscriptionThread->call(...$mArgs);
	}

	public function mkCU(...$mArgs)
	{
		return $this->mk(Creds::getCUID(), ...$mArgs);
	}

	public function has($mIDSubscriptor, $mIDThread)
	{
		$qres = $this->getWhere('id_thread = '.$mIDThread);
		if(!$qres) return false;

		while($row = $qres->fetch_assoc())
		{
			$baseRow = TBS::$subBase->findByID($row['id_base']);
			if(!$baseRow) continue;

			if($baseRow['id_subscriptor'] == $mIDSubscriptor) return true;
		}

		return false;
	}

	public function delCU($mIDThread)
	{
		$idSubscriptor = Creds::getCUID();

		$qres = $this->getWhere('id_thread = '.$mIDThread);
		if(!$qres) return false;

		while($row = $qres->fetch_assoc())
		{
			$baseRow = TBS::$subBase->findByID($row['id_base']);
			if(!$baseRow) continue;

			if($baseRow['id_subscriptor'] == $idSubscriptor) 
			{
				TBS::$subBase->deleteByID($baseRow['id']);
				return true;
			}
		}
	}
}

class TblSubUser extends Tbl
{
	public function mk(...$mArgs)
	{
		return SPRCS::$mkSubscriptionUser->call(...$mArgs);
	}
}

class TblSubTag extends Tbl
{
	public function mk(...$mArgs)
	{
		return SPRCS::$mkSubscriptionTag->call(...$mArgs);
	}
}



class TblNtfThread extends Tbl
{
	public function mk(...$mArgs)
	{
		return SPRCS::$mkNotificationThread->call(...$mArgs);
	}
}

class TblNtfUser extends Tbl
{
	public function mk(...$mArgs)
	{
		return SPRCS::$mkNotificationUser->call(...$mArgs);
	}
}

class TblNtfTag extends Tbl
{
	public function mk(...$mArgs)
	{
		return SPRCS::$mkNotificationTag->call(...$mArgs);
	}
}



TBS::$log = new TblLog('tbl_log',
	'type', 'creation_timestamp', 'value');

TBS::$tag = new TblTag('tbl_tag',
	'value');

TBS::$group = new TblGroup('tbl_group',
	'id_parent', 'name', 'is_superadmin', 'can_manage_sections', 'can_manage_users', 'can_manage_groups', 'can_manage_permissions');

TBS::$user = new TblUser('tbl_user',
	'id_group', 'username', 'password_hash', 'email', 'registration_date', 'firstname', 'lastname', 'birth_date');

TBS::$section = new TblSection('tbl_section',
	'id_parent', 'name');

TBS::$cntBase = new Tbl('tbl_content_base');
TBS::$cntThread = new TblCntThread('tbl_content_thread');
TBS::$cntPost = new TblCntPost('tbl_content_post');
TBS::$cntAttachment = new TblCntAttachment('tbl_content_attachment');

TBS::$subBase = new Tbl('tbl_subscription_base');
TBS::$subThread = new TblSubThread('tbl_subscription_thread');
TBS::$subUser = new TblSubUser('tbl_subscription_user');
TBS::$subTag = new TblSubTag('tbl_subscription_tag');

TBS::$ntfBase = new Tbl('tbl_notification_base');
TBS::$ntfThread = new TblNtfThread('tbl_notification_thread');
TBS::$ntfUser = new TblNtfUser('tbl_notification_user');
TBS::$ntfTag = new TblNtfTag('tbl_notification_tag');


TBS::$gsperms = new TblGroupSectionPermission('tbl_group_section_permission',
	'id_group', 'id_section', 'can_view', 'can_post', 'can_create_thread', 'can_delete_post', 'can_delete_thread', 'can_delete_section');

?>