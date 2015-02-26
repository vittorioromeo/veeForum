<?php

	$modalNtf = new BSModal('modalNtf', 'Notifications');
	$modalNtfBody = $modalNtf->inBody()->addAttribute('id', 'modalNtfBody');

	$modalNtf->inFooterBtns()
		->inBSLinkBtnActive('btnMarkAllNtfs', 'markAllNtfs();')
			->bsIcon('ok')
			->literal(' Mark all as seen')
			->out()
		->inBSLinkBtnActive('btnDelAllNtfs', 'delAllNtfs();')
			->bsIcon('remove')
			->literal(' Delete all')
			->out()
	->printRoot();

	Gen::JS_PostAction('markAllNtfs()', 'markAllNtfs', [], 'refreshNotificationsModal(); reloadNavbar();', 'showModalInfo("Error", mErr);');
	Gen::JS_PostAction('delAllNtfs()', 'delAllNtfs', [], 'refreshNotificationsModal(); reloadNavbar();', 'showModalInfo("Error", mErr);');

	Gen::JS_PostAction('refreshNotificationsModal()', 'refreshNotificationsModal', [], '$("#modalNtfBody").html(mOut);', 'showModalInfo("Error", mErr);');
	Gen::JS_PostAction('delNtfByID(mX)', 'delNtfByID', ['id' => 'mX'], 'refreshNotificationsModal(); reloadNavbar();', 'showModalInfo("Error", mErr);');
	Gen::JS_PostAction('markNtfByID(mX)', 'markNtfByID', ['id' => 'mX'], 'refreshNotificationsModal(); reloadNavbar();', 'showModalInfo("Error", mErr);');



	// TODO: move

	$modalDebug = new BSModal('modalDebug', 'Debug log');
	$modalDebug->inBody()->addAttribute('id', 'modalDebugBody');

	$modalDebug->inFooterBtns()->printRoot();

	Gen::JS_PostAction('refreshDebugModal()', 'refreshDebugModal', [], '$("#modalDebugBody").html(mOut);', 'showModalInfo("Error", mErr);');
	Gen::JS_PostAction('clearDebugModal()', 'clearDebugModal');






	// TODO: move

	(new Container())->inHTMLCtrl('span', ['id' => 'modalUPContainer'])->printRoot();
	

	Gen::JS_PostAction('refreshModalUP(mX)', 'refreshModalUP', ['id' => 'mX'], '$("#modalUPContainer").html(mOut); reloadNavbar(); $(\'#modalUP\').modal(\'show\');', 'showModalInfo("Error", mErr);');
	Gen::JS_PostAction('subUser(mX)', 'subUser', ['id' => 'mX'], 'reloadNavbar(); refreshModalUP(mX);', 'showModalInfo("Error", mErr);');
	Gen::JS_PostAction('unsubUser(mX)', 'unsubUser', ['id' => 'mX'], 'reloadNavbar(); refreshModalUP(mX);', 'showModalInfo("Error", mErr);');
?>

<script>
function showModalUP(mX)
{
	refreshModalUP(mX);	
}
</script>