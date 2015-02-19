<div class="modal fade" id="modalGSPerms">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
				<h4 class="modal-title">Permissions</h4>
				<div class="gspNameDiv"></div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<?php
							Gen::CheckBox("cbGSPCView", "Can view");
							Gen::CheckBox("cbGSPCPost", "Can post");
							Gen::CheckBox("cbGSPCreateThread", "Can create thread");
						?>
					</div>
					<div class="col-md-6">
						<?php
							Gen::CheckBox("cbGSPCDeletePost", "Can delete post");
							Gen::CheckBox("cbGSPCDeleteThread", "Can delete thread");
							Gen::CheckBox("cbGSPCDeleteSection", "Can delete section");
						?>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group pull-right">
						<?php Gen::LinkBtn('btnGSPModalOK', 'glyphicon-ok', '', '', true); ?>
						<?php Gen::BtnCloseModal(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>