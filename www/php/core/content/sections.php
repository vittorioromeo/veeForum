<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/php/lib/lib.php");

	(new Container())
		->h(1, 'Sections')
		->hr()
		->span(['id' => 'sectionsPage'])
		->printRoot();

	require_once("$root/php/core/content/sections/modalNewThread.php"); 

	Gen::JS_PostAction('refreshSections()', 'refreshSections', [], '$("#sectionsPage").html(mOut);', 'showModalInfo("Error", mErr);');
?>

<script>
function refreshAll()
{
	refreshSections();
}

$(document).ready(function(){ refreshAll(); });
</script>
