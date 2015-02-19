<?php

class TblUser extends Tbl
{
	public function findByCreds($mUser, $mPass)
	{
		$hash = Utils::getPwdHash($mPass);
		return $this->getFirstWhere('username = '.DB::v($mUser).' AND password_hash = '.DB::v($hash));
	}
}

?>