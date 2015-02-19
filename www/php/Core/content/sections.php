<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/php/Lib/lib.php");
?>

<h1>Sections</h1>
<hr>

<span id="sectionsPage"></span>

<?php require_once("$root/php/Core/content/sections/modalNewThread.php"); ?>

<?php 
Gen::JS_PostAction('refreshSections()', 'refreshSections', [], '$("#sectionsPage").html(mOut);', 'showModalInfo("Error", mErr);');
?>

<script>
function refreshAll()
{
	refreshSections();
}

$(document).ready(function(){ refreshAll(); });
</script>
