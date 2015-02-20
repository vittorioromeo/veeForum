<div class="modal fade" id="modalNewPost">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
				<h4 class="modal-title">New post</h4>
				<div>ID: <?php print(Session::get(SK::$threadID)); ?></div>
			</div>
			<div class="modal-body">
				<?php Gen::Textarea("taPost", "Contents"); ?>
			</div>
			<div class="modal-footer">
				<div class="btn-group pull-right">
					<?php Gen::LinkBtn('btnNewPostOk', 'glyphicon-ok', '', '', true); ?>
					<?php Gen::BtnCloseModal(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

Gen::JS_PostAction('newPost()', 'newPost',
			[
				'contents' => '$("#taPost").val()'
			],
			'showModalInfo("New post", mOut); refreshAll();',
			'showModalInfo("New post - error", mErr);');

Gen::JS_OnBtnClick('btnNewPostOk', 'newPost();');
?>