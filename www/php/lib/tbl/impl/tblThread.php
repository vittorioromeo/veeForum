<?php

class TblThread extends Tbl
{
	public function mkThreadAndCData($mIDSection, $mTitle)
	{
		$cdID = TBS::$cdata->createCDataAndGetID();
		return $this->insertValues($cdID, $mIDSection, $mTitle);
	}
}

?>