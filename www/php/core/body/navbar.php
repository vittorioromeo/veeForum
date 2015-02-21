<?php
	(new Container())
		->inHTMLCtrl('nav', ['class' => 'navbar navbar-default navbar-fixed-top', 'role' => 'navigation'])
			->inDiv(['class' => 'container'])
				->inDiv(['class' => 'navbar-header'])
					->inHTMLCtrl('a', ['class' => 'navbar-brand', 'href' => '#'])
						->literal(Settings::getForumName())
						->out()
					->out()
				->inSpan(['id' => 'navCont'])
	->printRoot();
?>

<script>
$(document).ready(function()
{
	reloadNavbar();
});

function reloadNavbar()
{
	$("#navCont").load("php/core/body/navbarContents.php");
}
</script>