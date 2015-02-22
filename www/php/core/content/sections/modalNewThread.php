<?php
	$modal = new BSModal('modalNewThread', 'New thread');
	$modal->inHeader()->inDiv(['class' => 'sectionIdDiv']);
	$modal->inBody()->bsFormTextbox('tbThreadTitle', 'Title');	
	$modal->inFooterBtns()
		->inBSLinkBtn('btnNewThreadOk')
			->bsLinkBtnAddDismissModal()
			->bsIcon('ok');
	$modal->printRoot();

	Gen::JS_PostAction('newThread()', 'newThread',
				[
					'sectionId' => 'sectionId',
					'title' => '$("#tbThreadTitle").val()'
				],
				'refreshAll();',
				'showModalInfo("New thread - error", mErr);');

	Gen::JS_OnBtnClick('btnNewThreadOk', 'newThread(); ');
?>

<script>
var sectionId = -1;

function setSectionId(mID)
{
	sectionId = mID;

	if(mID != -1)
	{
		$(".sectionIdDiv").text("ID: " + sectionId);
	}
	else
	{
		$(".sectionIdDiv").text("NULL section (error!)");
	}
}

function showNewThreadModal(mID)
{
	setSectionId(mID);
	$("#modalNewThread").modal("show");
}
</script>