<div class="modal fade" id="modalUsAdd">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
				<h4 class="modal-title">Add/edit user</h4>
				<div class="usIdDiv"></div>
			</div>
			<div class="modal-body">
				<?php Gen::Textbox("tbUsAddUsername", "Username"); ?>

				<span id="modalUsAddPwd">
					<?php Gen::Textbox("tbUsAddPassword", "Password"); ?>
				</span>

				<?php
					Gen::Textbox("tbUsAddEmail", "Email");
					Gen::Textbox("tbUsAddFirstname", "First name");
					Gen::Textbox("tbUsAddLastname", "Last name");
				?>

				<div class="form-group">
					<label for="dateUsAddBirth">Birth date</label>
					<input class="form-control" type="date" id="dateUsAddBirth">
				</div>

				<div class="form-group">
					<label for="slUsAddGroup">Group</label>
					<select class="form-control" name="slUsAddGroup" id="slUsAddGroup">

					</select>
				</div>
			</div>
			<div class="modal-footer">
				<div class="btn-group pull-right">
					<?php Gen::LinkBtn('btnUsAddOk', 'glyphicon-ok', '', '', true); ?>
					<?php Gen::BtnCloseModal(); ?>
				</div>
			</div>
		</div>
	</div>
</div>