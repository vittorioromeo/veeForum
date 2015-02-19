<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">veeForum</a>
		</div>
		<span id="navCont"></span>
	</div>
</nav>

<script>
$(document).ready(function()
{
	reloadNavbar();
});

function reloadNavbar()
{
	$("#navCont").load("php/Core/body/navbarContents.php");
}
</script>