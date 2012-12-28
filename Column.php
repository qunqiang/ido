<?php
class Column
{
	private $default;
	private $limit;
	private $name;
	private $null;
	private $precision;
	public 	$primary;
	private $scale;
	private $sql_type;
	private $type; 
	
	public function Column()
	{
	
	}
	
	public static function create($name, $default, $sql_type = null, $null = true)
	{
		$this->name = $name;
		$this->default = $default;
		$this->null = $null;
		
		$this->limit = $this->_extractLimit($sql_type);
		
	}
	
	public static function binary_to_string($value)
	{
		$ret = NULL;
		$length = strlen($value);
		for($i = 0; $i < ($length / 8); $i ++)
		{
			$ret .= chr(intval(substr($value, $i * 8, 8), 2));
		}
		return $ret;
	}

}
