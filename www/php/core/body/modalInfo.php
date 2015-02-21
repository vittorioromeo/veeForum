<?php
	$modal = new BSModal('modalInfo', '');
	$modal->inHeader()->inHTMLCtrl('h4', ['class' => 'modal-title', 'id' => 'modalInfoHeader']);
	$modal->inBody()->inHTMLCtrl('p', ['id' => 'modalInfoText']);
	$modal->printRoot();

	Gen::JS_PostAction('tryRegister()', 'tryRegister',
		[		
			'username' => '$("#tbLgUsername").val()',
			'password' => '$("#tbLgPassword").val()',
			'email' => '$("#tbLgEmail").val()',
			'firstname' => '$("#tbLgFirstname").val()',
			'lastname' => '$("#tbLgLastname").val()',
			'birthdate' => '$("#dateLgBirth").val()',		
		],
		'showAPModal("Add/edit", mOut);',
		'showAPModal("Add/edit - error", mErr);');

	Gen::JS_OnBtnClick('btnLgOK', 'tryRegister();');
?>

<script>
function showModalInfo(mHeader, mText)
{
	$("#modalInfoHeader").text(mHeader);
	$("#modalInfoText").html(mText);
	$("#modalInfo").modal('show');
}
</script>