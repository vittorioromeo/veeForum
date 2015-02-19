<div class="col-md-8">
	<h2>Groups</h2>
	<div class="col-md-4">
		<div class="panel panel-default">
			<?php Gen::PanelTitle('Add'); ?>
			<div class="panel-body">
				<?php Gen::Textbox("tbGrName", "Name"); ?>

				<div class="form-group">
					<label for="slGrPrivileges">Privileges</label>
					<select class="form-control" multiple="true" id="slGrPrivileges">
						<option value="0">SuperAdmin</option>
					</select>
				</div>

				<div class="form-group">
					<label for="slGrParent">Parent</label>
					<select class="form-control" id="slGrParent">

					</select>
				</div>

				<div class="btn-group pull-right">
					<?php Gen::LinkBtn('btnGrAdd', 'glyphicon-plus'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<?php Gen::PanelTitle('Delete'); ?>
			<div class="panel-body">
				<div class="form-group">
					<label for="slGrToDel">Select</label>
					<select class="form-control" name="slGrToDel" id="slGrToDel">

					</select>
				</div>

				<div class="btn-group pull-right">
					<?php Gen::LinkBtn('btnGrDel', 'glyphicon-minus'); ?>
					<?php Gen::LinkBtn('btnGrDelRecursive', '', 'Recursive'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<?php Gen::PanelTitle('Hierarchy'); ?>
			<div class="panel-body">
				<div id="divGrHierarchy"></div>
			</div>
		</div>
	</div>
</div>

<?php
	Gen::JS_PostAction('grAdd()', 'grAdd',
		[
			'idParent' => '$("#slGrParent").val()',
			'name' => '$("#tbGrName").val()',
			'privileges' => '$("#slGrPrivileges").val()'
		],
		'showAPModal("Create", mOut);',
		'showAPModal("Create - error", mErr);');

	Gen::JS_PostAction('grDel()', 'grDel',
		['id' => '$("#slGrToDel").val()' ],
		'showAPModal("Delete", mOut);',
		'showAPModal("Delete - error", mErr);');

	Gen::JS_PostAction('grDelRecursive()', 'grDelRecursive',
		[ 'id' => '$("#slGrToDel").val()' ],
		'showAPModal("Delete recursive", mOut);',
		'showAPModal("Delete recursive - error", mErr);');

	Gen::JS_OnBtnClick('btnGrAdd', 				'grAdd(); refreshAll();');
	Gen::JS_OnBtnClick('btnGrDel', 				'grDel(); refreshAll();');
	Gen::JS_OnBtnClick('btnGrDelRecursive', 	'grDelRecursive();	refreshAll();');
?>