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