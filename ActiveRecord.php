<?php
// ================================================================================================
// = ActiveRecord :Base class for all that would prefer to a quick database access & modification =
// ================================================================================================
class ActiveRecord
{
	/**
	 * @var Connection<ido/connection.php> stored established connection
	 */
	private $connection;
	/**
	 * @var Singleton<called class>
	 */
	static $instance;
	/**
	 * @var Table<ido/Table.php> which activerecord will be binded to
	 */
	static $table;

	/**
	 * private function for singleton 
	 */
	private function ActiveRecord()
	{
		$this->connection = Connection::connect();
		$this->table 	  = Table::initWithTableName($this->tableName());
	}
	
	/**
	 * returns singleton object of ActiveRecord
	 */
	public static function init()
	{
		if (function_exists('get_called_class'))
		{
			$class = get_called_class();
		}
		else
		{
			$bt = debug_backtrace();
			$bt = $bt[0];
			$lines = file($bt['file']);
			$line = $lines[$bt['line'] - 1];
			$calledClass = preg_match('/\s(\w+)::/', $line, $class);
			if($calledClass >= 2)
			{
				$class = $class[1];
			}
			
		}
		if (!self::$instance)
		{
			self::$instance = new $class;
		}
		return self::$instance;
	}
	
	/**
	 * returns attribute from active record
	 */
	public function __get($key)
	{
		if (isset($this->{$key}))
		{
			return $this->{$key};
		}
		return NULL;
	}
	/**
	 * sets attribute to active record
	 */
	public function __set($key, $value)
	{
		$this->{$key} = $value;
	}
	
	/**
	 * dynamic functions called support, like 
	 	ActiveRecord::find_by_id(1), 
		ActiveRecord::find_by_name_and_sex('ln',Female);
		the two function calls will both directory to ActiveRecord::find_by($arguments)
	 */
	public function __call($funcName, $args)
	{
		$dynamic_function_tables = array(
			'find_by_' 	=> 'find_by',
			'scope_by_'	=> 'scope_by',
			'set'		=> 'set',
		);
		
		foreach ($dynamic_function_tables as $prefix => $func)
		{
			if (strpos($funcName,$prefix) !== false)
				{
					$arguments = str_replace($prefix, '', $funcName);
					$arguments = explode('_and_', trim($arguments, '_'));
						
					foreach ($arguments as $k => $v)
					{
						$arguments[$arguments[$k]] = $args[$k];
						unset($arguments[$k]);
					}
					$this->{$func}($arguments);
					return $this;
				}
		}
		
	}
	
	/**
	 * returns simple finders' execution result
	 */
	public function find_by($conditions)
	{
		echo $this->connection->getAdapter()->adapterName();
		var_dump($this->connection->getAdapter()->verify(120));
		// $this->connection->createSqlBuilder()->findAll($conditions);
	}
	
	/**
	 * set scope expression for finders
	 */
	public function scope_by($conditions)
	{
	}
	

}