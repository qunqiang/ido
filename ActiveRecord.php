<?php
// ================================================================================================
// = ActiveRecord :Base class for all that would prefer to a quick database access & modification =
// ================================================================================================
class ActiveRecord
{
	
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
		the two function calls will be both mapped to 
		ActiveRecord::find_by(array('id' => 1)),
		ActiveRecord::find_by(array('name' => 'ln', 'sex' => Female))
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

		//echo $this->table->connection->getAdapter()->adapterName();
		//var_dump($this->table->connection->getAdapter()->verify(120));	
		// $this->table->connection->query($this->table->getBuilder()->build($conditions));
		// echo $this->table->humanName();

		var_dump($this->table->connection->initQueryWithConditions($conditions)->exec());
		var_dump($this->table->connection->initQueryWithSQL(SQLSyntax::get('sql.front.news_list'))->getAll());
		// var_dump($conditions);

	}
	
	/**
	 * set scope expression for finders
	 */
	public function scope_by($conditions)
	{
	}
	

}