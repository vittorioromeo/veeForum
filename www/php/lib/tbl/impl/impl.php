<?php

class Tbl
{
	protected $tblName;
	private $insertFields;

	public function __construct($mTblName, ...$mInsertFields) 
	{
		$this->tblName = $mTblName;
		$this->setInsertFields(...$mInsertFields);
	}

	public function setInsertFields(...$mFields)
	{
		$this->insertFields = $mFields;
	}

	public function insert(...$mValues)
	{
		$insertFieldsStr = Utils::getCSL($this->insertFields);
		$insertValuesStr = Utils::getCSL($mValues);
		
		Debug::loLn();
		Debug::lo("Inserting into table $this->tblName:");
		Debug::lo("FIELDS: $insertFieldsStr");
		Debug::lo("VALUES: $insertValuesStr");

		if(count($mValues) != count($this->insertFields))
		{
			$err = "Error: count of values does not match count of fields.";
			Debug::lo($err);
			return $err;
		}

		$res = DB::query("INSERT INTO $this->tblName ($insertFieldsStr) VALUES ($insertValuesStr);");
		if($res) return $res;

		return DB::$lastError;
	}

	public function insertValues(...$mValues)
	{
		$vals = [];
		foreach($mValues as $x) array_push($vals, DB::v($x));
		return $this->insert(...$vals);
	}


	public function updateByID($mID, $mArray)
	{	
		$q = "UPDATE $this->tblName SET ";
		
		$notFirst = false;
		foreach($mArray as $k => $v)
		{
			if($notFirst) $q .= ', ';			
			
			$notFirst = true;
			$q .= $k.' = '.DB::v($v);
		}

		$q .= ' WHERE id = '.DB::v($mID);

		return DB::query($q);
	}

	

	public function getAll()
	{
		return DB::query("SELECT * FROM $this->tblName");
	}

	public function getWhere($mX)
	{
		return DB::query("SELECT * FROM $this->tblName WHERE $mX");
	}

	public function getFirst($mX)
	{
		$res = $this->getAll();
		return $res->fetch_assoc();
	}

	public function getFirstWhere($mX)
	{
		$res = $this->getWhere($mX);
		return $res->fetch_assoc();
	}



	public function deleteWhere($mX)
	{
		return DB::query("DELETE FROM $this->tblName WHERE $mX");
	}

	public function deleteByID($mID)
	{
		return $this->deleteWhere('id = '.DB::v($mID));
	}	

	public function deleteRecursiveByID($mID)
	{
		$qres = $this->getWhere('id_parent = '.DB::v($mID));

		if(!$qres) return false;

		while($row = $qres->fetch_assoc()) 
		{
			$this->deleteRecursiveByID($row["id"]);
		}

		return $this->deleteByID($mID);		
	}	
	


	public function findByID($mID)
	{
		return $this->getFirstWhere('id = '.DB::v($mID));
	}

	public function findAllByIDParent($mIDParent)
	{
		if($mIDParent == null)
		{
			return $this->getWhere('id_parent IS NULL');
		}

		return $this->getWhere('id_parent = '.DB::v($mIDParent));
	}



	public function hasAnyWhere($mX)
	{
		return $this->getWhere($mX)->num_rows > 0;
	}

	public function hasID($mID)
	{
		return $this->hasAnyWhere('id ='.DB::v($mID));
	}


	public function forRows($mFn)
	{
		$qres = $this->getAll();
		if(!$qres) return false;

		while($row = $qres->fetch_assoc()) 
		{
			$mFn($row);			
		}

		return true;
	}

	public function forWhere($mFn, $mWhere)
	{
		$qres = $this->getWhere($mWhere);
		if(!$qres) return false;

		while($row = $qres->fetch_assoc()) 
		{
			$mFn($row);			
		}

		return true;
	}

	public function forChildren($mFn, $mIDParent = null, $mDepth = 0)
	{
		$qres = $this->findAllByIDParent($mIDParent);
		if(!$qres) return false;

		while($row = $qres->fetch_assoc()) 
		{
			$mFn($row, $mDepth);
			$this->forChildren($mFn, $row['id'], $mDepth + 1);
		}

		return true;
	}

	public function forParent($mFn, $mID, $mDepth = 0)
	{
		if($mID == 'null') return false;
		
		$row = $this->findByID($mID);
		if(!$row) return false;	
		
		$mFn($row, $mDepth);
		$this->forParent($mFn, $row['id_parent'], $mDepth + 1);
	
		return true;
	}
}

?>