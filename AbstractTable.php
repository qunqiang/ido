<?php 
abstract class AbstractTable
{
	/**
	 * @var Connection<ido/connection.php> stored established connection
	 */
	public $connection;
	
	public $tableName;
	
	public function AbstractTable()
	{
		$this->connection = Connection::connect();
	}
	
	
	public function humanName()
	{
		return ucfirst(trim($this->tableName, '{}'));
	}

}