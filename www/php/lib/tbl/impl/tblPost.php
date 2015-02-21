<?php

class TblCntPost extends Tbl
{
	public function mk(...$mArgs)
	{
		return SPRCS::$mkContentPost->call(...$mArgs);
	}

	public function mkCU(...$mArgs)
	{
		return $this->mk(Creds::getCUID(), ...$mArgs);
	}
}

class TblCntAttachment extends Tbl
{
	public function mk(...$mArgs)
	{
		return SPRCS::$mkContentAttachment->call(...$mArgs);
	}

	public function mkCU(...$mArgs)
	{
		return $this->mk(Creds::getCUID(), ...$mArgs);
	}
}

?>