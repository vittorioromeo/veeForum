<div class="modal fade" id="modalLgRegister">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
				<h4 class="modal-title">Register</h4>				
			</div>
			<div class="modal-body">
				<?php
					Gen::Textbox("tbLgUsername", "Username");
					Gen::Textbox("tbLgPassword", "Password");
					Gen::Textbox("tbLgEmail", "Email");
					Gen::Textbox("tbLgFirstname", "First name");
					Gen::Textbox("tbLgLastname", "Last name");
				?>

				<div class="form-group">
					<label for="dateLgBirth">Birth date</label>
					<input class="form-control" type="date" id="dateLgBirth">
				</div>
			</div>
			<div class="modal-footer">
				<div class="btn-group pull-right">
					<?php Gen::LinkBtn('btnLgOK', 'glyphicon-ok', '', '', true); ?>
					<?php Gen::BtnCloseModal(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
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