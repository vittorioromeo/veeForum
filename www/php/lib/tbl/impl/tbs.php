<?php

class TBS
{
	public static $section;
	public static $group;
	public static $user;
	public static $gsperms;
	public static $cdata;
	public static $thread;
	public static $post;
}

TBS::$section = new TblSection('tbl_section',
	'id_parent', 'name');

TBS::$group = new TblGroup('tbl_group',
	'id_parent', 'name', 'privileges');

TBS::$user = new TblUser('tbl_user',
	'id_group', 'username', 'password_hash', 'email', 'registration_date', 'firstname', 'lastname', 'birth_date');

TBS::$gsperms = new TblGroupSectionPermission('tbl_group_section_permission',
	'id_group', 'id_section', 'can_view', 'can_post', 'can_create_thread', 'can_delete_post', 'can_delete_thread', 'can_delete_section');

TBS::$cdata = new TblCData('tbl_creation_data',
	'creation_date', 'id_author');

TBS::$thread = new TblThread('tbl_thread',
	'id_creation_data', 'id_section', 'title');

TBS::$post = new TblPost('tbl_post',
	'id_creation_data', 'id_thread', 'contents');

?>