<?php
	(new Container())
		->inDiv(['class' =>'col-md-12'])->h(2, 'Users')
			->inBSPanelWithHeader('Manage')
				->inBSTable('tblUsManage')
	->printRoot();
?>
