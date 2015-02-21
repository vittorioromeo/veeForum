<?php

class TblGroup extends Tbl
{
	public function mkGroup($mIDParent, $mName, ...$mPrivs)
	{
		$parentId = Utils::getInsertParent($this, $mIDParent);
		if(!$parentId) return false;

		return $this->insertValues($parentId, $mName, ...$mPrivs);
	}

	public function getHierarchyStr()
	{	
		$res = "";

		$this->forChildren(function(&$mRow, $mDepth) use (&$res)
		{
			$indent = str_repeat("--->", $mDepth);

			$id = $mRow['id'];
			$name = $mRow['name'];
			$privileges = PrivSet::fromGroup($mRow)->toStr();

			$res .= $indent . "($id) $name [$privileges]\n";
		});

		return $res;
	}
}


?>