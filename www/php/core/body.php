<?php	
	require_once("$root/php/core/body/modalInfo.php");
	require_once("$root/php/core/body/modalNotifications.php");
	require_once("$root/php/core/body/navbar.php");

	(new HTMLControl('body'))
		->inDiv(['class' => 'container', 'id' => 'pageContainer'])
			->inSpan(['id' => 'page'])
				->out()
			->file("$root/php/core/body/footer.php")
	->printRoot();

	Gen::JS_PostAction('reloadPage()', 'getCurrentPage', [], 'reloadPageImpl(mOut);');


	Gen::JS_OnBtnClickDynamic('btnNewPost', '$("#modalNewPost").modal("show");');
	Gen::JS_OnBtnClickDynamic('btnDelPosts', 'deleteCurrentPosts();');
	Gen::JS_OnBtnClickDynamic('btnDelThread', 'deleteCurrentThread(); ');
	Gen::JS_OnBtnClickDynamic('btnSubThread', 'alert("SUB CLICK"); subCurrentThread(); ');
	Gen::JS_OnBtnClickDynamic('btnUnsubThread', 'unsubCurrentThread(); ');
	Gen::JS_OnBtnClickDynamic('btnUsAdd',		'showUsEditModal(-1);');
?>

<script>
function reloadPageImpl(mX)
{
	$("#pageContainer").fadeOut('fast', function()
	{
		$("#page").load(mX);
		$("#pageContainer").fadeIn('fast');
	});
}

$(document).ready(function()
{ 
	reloadPage(); 
});
</script>