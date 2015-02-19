<?php

class TblPost extends Tbl
{
	public function mkPostAndCData($mIDThread, $mContents)
	{
		$cdID = TBS::$cdata->createCDataAndGetID();
		return $this->insertValues($cdID, $mIDThread, $mContents);
	}
}

?>