<?php

class TblCntThread extends Tbl
{
	public function mk(...$mArgs)
	{
		return SPRCS::$mkContentThread->call(...$mArgs);
	}

	public function mkCU(...$mArgs)
	{
		return $this->mk(Creds::getCUID(), ...$mArgs);
	}
}

?>