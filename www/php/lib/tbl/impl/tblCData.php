<?php

class TblCData extends Tbl
{
	public function createCDataAndGetID()
	{
		$idAuthor = Creds::getCUID();
		$res = $this->insertValues(date('Y-m-d'), $idAuthor);

		if(!$res) return null;
		return DB::getInsertedID();
	}
}

?>