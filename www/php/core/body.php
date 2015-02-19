<body>
	<?php	
		require_once("$root/php/core/body/modalInfo.php");
		require_once("$root/php/core/body/navbar.php");
	?>
	<div class="container" id="pageContainer">
		<span id="page"></span>
		<?php 
			require_once("$root/php/core/body/footer.php"); 
		?>
	</div>
</body>

<?php 
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