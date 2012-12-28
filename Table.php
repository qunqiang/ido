<?php
class Table extends AbstractTable
{
	static $table;
	
	public $tableName;
	
	/**
	 * returns singleton of Table
	 */
	public static function init()
	{
		if (!self::$table)
		{
			self::$table = new Table;
		}
		return self::$table;
	}
	
	/**
	 * returns singleton of Table with tableName
	 */
	public static function initWithTableName($tabaleName)
	{
		$table = self::init();
		$table->tableName($tabaleName);
		return $table;
	}
	
	/**
	 * setter/getter for tableName
	 */
	public function tableName()
	{
		if (func_get_arg(0))
		{
			$this->tableName = func_get_arg(0);
		}
		else
		{
			return $this->tableName;
		}
	}
	
	/**
	 * add one or muti columns to table
	 */
	public function addColumns($columns = array())
	{
	
	}

}