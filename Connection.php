<?php
class Connection
{
	static $connection;
	static $adapter;
	
	private $adapterName;
	
	/**
	 * initlization of adapter
	 */
	private function Connection()
	{
		$this->adapterName = ucfirst(BIOS::activeOs()->getConf('database.adapter')) . 'Adapter';
		self::$adapter = new $this->adapterName;
	}
	
	/**
	 * returns singleton instance of connection
	 */
	public static function connect()
	{
		if (!self::$connection)
		{
			self::$connection = new Connection;
			self::$connection->connect();
		}
		return self::$connection;
	}
	
	/**
	 * returns really adapter connected to database
	 */
	public function getAdapter()
	{
		return self::$adapter;
	}
	
	/**
	 * returns human readable adapter name
	 */
	public function getAdapterName()
	{
		return ucfirst($this->adapterName);
	}
}