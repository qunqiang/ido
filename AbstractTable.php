<?php 
abstract class AbstractTable
{
	public $tableName;
	
	public function humanName()
	{
		return ucfirst(trim($this->tableName, '{}'));
	}

}