<div class="col-md-4">
	<h2>Debug</h2>
	<div class="panel panel-default">
		<?php Gen::PanelTitle('Actions'); ?>
		<div class="panel-body">
			<div class="btn-group-vertical pull-right">
				<?php
					Gen::LinkBtn('btnDbEnable', 'glyphicon-ok', 'Enable/clear');
					Gen::LinkBtn('btnDbDisable', 'glyphicon-remove', 'Disable');
					Gen::LinkBtn('btnDbRefresh', 'glyphicon-refresh', 'Refresh page');
				?>
			</div>
			<?php Gen::CheckBox('cbDbModals', 'Show modals in this page', true) ?>				
		</div>
	</div>
</div>

<?php
	Gen::JS_OnBtnClick('btnDbEnable', 			'setDebugMode(true);');
	Gen::JS_OnBtnClick('btnDbDisable', 			'setDebugMode(false);');
	Gen::JS_OnBtnClick('btnDbRefresh', 			'refreshAll();');
?>