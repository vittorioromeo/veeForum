<div class="modal fade" id="modalUsActions">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
				<h4 class="modal-title">User actions</h4>
				<div class="usIdDiv"></div>
			</div>
			<div class="modal-body">
				<div class="btn-group">
					<?php Gen::LinkBtn('btnUsActionsUsDel', 'glyphicon-remove', 'Delete user', '', true); ?>
					<?php Gen::LinkBtn('btnUsActionsUsResetPwd', 'glyphicon-envelope', 'Reset password', '', true); ?>
				</div>
			</div>
			<div class="modal-footer">
				<div class="btn-group pull-right">
					<?php Gen::BtnCloseModal(); ?>
				</div>
			</div>
		</div>
	</div>
</div>