<?php

class TblSection extends Tbl
{
	public function getHierarchyStr()
	{	
		$res = "";

		$this->forChildren(function(&$mRow, $mDepth) use (&$res)
		{
			$indent = str_repeat("--->", $mDepth);

			$id = $mRow['id'];
			$name = $mRow['name'];

			$res .= $indent . "($id) $name\n";
		});

		return $res;
	}
}

?>