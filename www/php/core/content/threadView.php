<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/php/lib/lib.php");
	
	$tid = Session::get(SK::$threadID);
	$sid = TBS::$cntThread->findByID($tid)['id_section'];

	(new Container())
		->h(1, 'Thread')
		->inSpan(['id' => 'threadName'])
			->out()
		->hr()	
		->inSpan(['id' => 'threadCtrls'])
			->out()
		->hr()
		->inSpan(['id' => 'threadPage'])
	->printRoot();

	require_once("$root/php/core/content/sections/modalNewPost.php"); 

	Gen::JS_PostAction('refreshThreadCtrls()', 'refreshThreadCtrls', [], '$("#threadCtrls").html(mOut);', 'showModalInfo("Error", mErr);'); 
	Gen::JS_PostAction('refreshThread()', 'refreshThread', [], '$("#threadName").html(mOut);', 'showModalInfo("Error", mErr);'); 
	Gen::JS_PostAction('refreshPosts()', 'refreshPosts', [], '$("#threadPage").html(mOut);', 'showModalInfo("Error", mErr);');

	Gen::JS_PostAction('deleteCurrentPosts()', 'deleteCurrentPosts', [], 'refreshAll();', 'showModalInfo("Error", mErr);');
	Gen::JS_PostAction('deleteCurrentThread()', 'deleteCurrentThread', [], 'if(mOut){ changeCurrentPage('.PK::$sections.'); } refreshAll();', 'showModalInfo("Error", mErr);');

	Gen::JS_PostAction('subCurrentThread()', 'subCurrentThread', [], 'refreshAll();', 'showModalInfo("Error", mErr);');
	Gen::JS_PostAction('unsubCurrentThread()', 'unsubCurrentThread', [], 'refreshAll();', 'showModalInfo("Error", mErr);');

	Gen::JS_OnBtnClickDynamic('btnNewPost', '$("#modalNewPost").modal("show");');
	Gen::JS_OnBtnClickDynamic('btnDelPosts', 'deleteCurrentPosts();');
	Gen::JS_OnBtnClickDynamic('btnDelThread', 'deleteCurrentThread(); ');
	Gen::JS_OnBtnClickDynamic('btnSubThread', 'subCurrentThread(); ');
	Gen::JS_OnBtnClickDynamic('btnUnsubThread', 'unsubCurrentThread(); ');
?>

<script>
function refreshAll()
{
	refreshThreadCtrls();
	refreshThread();
	refreshPosts();
	reloadNavbar();
}

$(document).ready(function(){ refreshAll(); });
</script>
