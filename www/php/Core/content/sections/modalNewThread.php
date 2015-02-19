<div class="modal fade" id="modalNewThread">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
				<h4 class="modal-title">New thread</h4>
				<div class="sectionIdDiv"></div>
			</div>
			<div class="modal-body">
				<?php Gen::Textbox("tbThreadTitle", "Title"); ?>
			</div>
			<div class="modal-footer">
				<div class="btn-group pull-right">
					<?php Gen::LinkBtn('btnNewThreadOk', 'glyphicon-ok', '', '', true); ?>
					<?php Gen::BtnCloseModal(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

Gen::JS_PostAction('newThread()', 'newThread',
			[
				'sectionId' => 'sectionId',
				'title' => '$("#tbThreadTitle").val()'
			],
			'showModalInfo("New thread", mOut); refreshAll();',
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