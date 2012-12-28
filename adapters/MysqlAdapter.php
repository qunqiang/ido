<?php
class MysqlAdapter extends AbstractAdapter
{
	/**
	 * returns adapter name
	 */
	public function adapterName()
	{
		return 'MySQL Adapter';
	}

	/**
	 * do physical connection User could recover this function 
	 */
	public function connect()
	{
		$os = BIOS::activeOS();
		$env = $os->getEnv();
		$dbconfig = $os->getConf('database.'. $env);
		print_r($dbconfig);
		$conn = mysql_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password']);
		if (!parent::$connection)
		{
			BIOS::raise('DBConnectionTimeout');
		}
		mysql_select_db($dbconfig['database']);
		mysql_query('SET NAMES ' . $dbconfig['charset']);
	}
	
	public function 
	
}