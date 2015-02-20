<?php
	$modal = new BSModal('modalNewPost', 'New post');
	$modal->inHeader()->literal('ID: '.Session::get(SK::$threadID));
	$modal->inBody()->bsFormTextarea('taPost', 'Contents', 3);
	$modal->inFooterBtns()
		->inBSLinkBtn('btnNewPostOk')
			->bsLinkBtnAddDismissModal()
			->bsIcon('ok')
			->out()
	->printRoot();

	Gen::JS_PostAction('newPost()', 'newPost',
		[
			'contents' => '$("#taPost").val()'
		],
		'showModalInfo("New post", mOut); refreshAll();',
		'showModalInfo("New post - error", mErr);');

	Gen::JS_OnBtnClick('btnNewPostOk', 'newPost();');
?>