<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/php/lib/lib.php");
	
	$tid = Session::get(SK::$threadID);
	$sid = TBS::$thread->findByID($tid)['id_section'];

	(new Container())
		->h(1, 'Thread')
		->inSpan(['id' => 'threadName'])
			->out()
		->hr()
	->printRoot();

	if(Creds::canCUPost($sid))
		Gen::LinkBtn('btnNewPost', 'glyphicon-plus', 'New post'); 
	
	if(Creds::canCUDeletePost($sid))
		Gen::LinkBtn('btnDelPosts', 'glyphicon-remove', 'Delete all posts'); 

	if(Creds::canCUDeleteThread($sid))
		Gen::LinkBtn('btnDelThread', 'glyphicon-remove', 'Delete thread'); 

	(new Container())
		->hr()
		->inSpan(['id' => 'threadPage'])
	->printRoot();

	require_once("$root/php/core/content/sections/modalNewPost.php"); 

	Gen::JS_PostAction('refreshThread()', 'refreshThread', [], '$("#threadName").html(mOut);', 'showModalInfo("Error", mErr);'); 
	Gen::JS_PostAction('refreshPosts()', 'refreshPosts', [], '$("#threadPage").html(mOut);', 'showModalInfo("Error", mErr);');

	Gen::JS_PostAction('deleteCurrentPosts()', 'deleteCurrentPosts', [], 'refreshAll();', 'showModalInfo("Error", mErr);');
	Gen::JS_PostAction('deleteCurrentThread()', 'deleteCurrentThread', [], 'if(mOut){ changeCurrentPage('.PK::$sections.'); } refreshAll();', 'showModalInfo("Error", mErr);');

	Gen::JS_OnBtnClick('btnNewPost', '$("#modalNewPost").modal("show");');
	Gen::JS_OnBtnClick('btnDelPosts', 'deleteCurrentPosts();');
	Gen::JS_OnBtnClick('btnDelThread', 'deleteCurrentThread(); ');
?>

<script>
function refreshAll()
{
	refreshThread();
	refreshPosts();
}

$(document).ready(function(){ refreshAll(); });
</script>
