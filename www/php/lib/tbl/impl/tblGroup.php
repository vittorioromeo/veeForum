<?php

class TblGroup extends Tbl
{
	public function mkGroup($mIDParent, $mName, $mPrivs, &$mMsg)
	{
		if(!Utils::checkEmptyStr($mName, $mMsg)) return false;

		$parentId = Utils::getInsertParent($this, $mIDParent, $mMsg);
		if(!$parentId) return false;

		$this->insert($parentId, $mName, DB::v($mPrivs->toStr()));
		$mMsg = "Group created successfully.";
		return true;
	}

	public function getHierarchyStr()
	{	
		$res = "";

		$this->forChildren(function(&$mRow, $mDepth) use (&$res)
		{
			$indent = str_repeat("--->", $mDepth);

			$id = $mRow['id'];
			$name = $mRow['name'];
			$privileges = $mRow['privileges'];

			$res .= $indent . "($id) $name [$privileges]\n";
		});

		return $res;
	}
}


?>