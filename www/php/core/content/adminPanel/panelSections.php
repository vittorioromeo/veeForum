<div class="col-md-8">
	<h2>Sections</h2>
	<div class="col-md-4">
		<div class="panel panel-default">
			<?php Gen::PanelTitle('Add'); ?>
			<div class="panel-body">
				<?php Gen::Textbox("tbScName", "Name"); ?>

				<div class="form-group">
					<label for="slScParent">Parent</label>
					<select class="form-control" id="slScParent">

					</select>
				</div>

				<div class="btn-group pull-right">
					<?php Gen::LinkBtn('btnScAdd', 'glyphicon-plus'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<?php Gen::PanelTitle('Delete'); ?>
			<div class="panel-body">
				<div class="form-group">
					<label for="slScToDel">Select</label>
					<select class="form-control" id="slScToDel">

					</select>
				</div>

				<div class="btn-group pull-right">
					<?php Gen::LinkBtn('btnScDel', 'glyphicon-minus'); ?>
					<?php Gen::LinkBtn('btnScDelRecursive', '', 'Recursive'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<?php Gen::PanelTitle('Hierarchy'); ?>
			<div class="panel-body">
				<div id="divScHierarchy"></div>
			</div>
		</div>
	</div>
</div>

<?php
	Gen::JS_PostAction('scAdd()', 'scAdd',
		[ 
			'idParent' => '$("#slScParent").val()', 
			'name' => '$("#tbScName").val()' 
		],
		'showAPModal("Create", mOut);',
		'showAPModal("Create - error", mErr);');

	Gen::JS_PostAction('scDel()', 'scDel',
		[ 'id' => '$("#slScToDel").val()' ],
		'showAPModal("Delete", mOut);',
		'showAPModal("Delete - error", mErr);');

	Gen::JS_PostAction('scDelRecursive()', 'scDelRecursive',
		[ 'id' => '$("#slScToDel").val()' ],
		'showAPModal("Delete recursive", mOut);',
		'showAPModal("Delete recursive - error", mErr);');

	Gen::JS_OnBtnClick('btnScAdd', 				'scAdd(); refreshAll();');
	Gen::JS_OnBtnClick('btnScDel', 				'scDel(); refreshAll();');
	Gen::JS_OnBtnClick('btnScDelRecursive', 	'scDelRecursive(); refreshAll();');
?>