<?php
	(new Container())
		->inFooter()
			->hr()
			->inA(['href' => 'http://vittorioromeo.info'])
				->literal('http://vittorioromeo.info')
	->printRoot();
?>