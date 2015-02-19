<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/php/Lib/lib.php");
?>

<h1>Thread</h1>
<span id="threadName"></span>

<hr>
<?php 
	$tid = Session::get(SK::$threadID);
	$sid = TBS::$thread->findByID($tid)['id_section'];
	
	if(Credentials::canCUPost($sid))
		Gen::LinkBtn('btnNewPost', 'glyphicon-plus', 'New post'); 
	
	if(Credentials::canCUDeletePost($sid))
		Gen::LinkBtn('btnDelPosts', 'glyphicon-remove', 'Delete all posts'); 

	if(Credentials::canCUDeleteThread($sid))
		Gen::LinkBtn('btnDelThread', 'glyphicon-remove', 'Delete thread'); 
?>
<hr>

<span id="threadPage"></span>

<?php require_once("$root/php/Core/content/sections/modalNewPost.php"); ?>

<?php
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
