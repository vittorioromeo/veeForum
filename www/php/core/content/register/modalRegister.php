<?php
	$modal = new BSModal('modalLgRegister', 'Register');	
	$modal->inBody()
		->bsFormTextbox('tbLgUsername', 'Username')
		->inBSFormTextbox('tbLgPassword', 'Password')
			->addAttribute('type', 'password')
			->out()
		->bsFormTextbox('tbLgEmail', 'Email')
		->bsFormTextbox('tbLgFirstname', 'First name')
		->bsFormTextbox('tbLgLastname', 'Last name')
		->literal('<div class="form-group">
					<label for="dateLgBirth">Birth date</label>
					<input class="form-control" type="date" id="dateLgBirth">
				</div>');
	$modal->inFooterBtns()
		->inBSLinkBtn('btnLgOK')
			->bsLinkBtnAddDismissModal()
			->bsIcon('ok')
			->out()
	->printRoot();

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