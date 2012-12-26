<?php
/**
All the concrete database adapters follow the interface laid down in this class. You can use this interface directly by borrowing the database connection from the Base with Base.connection.
Most of the methods in the adapter are useful during migrations. Most notably, SchemaStatements#create_table, SchemaStatements#drop_table, SchemaStatements#add_index, SchemaStatements#remove_index, SchemaStatements#add_column, SchemaStatements#change_column and SchemaStatements#remove_column are very useful.
*/

abstract class AbstractAdapter
{

	static $active;
    static $connection;
    
    /**
     * compaction for user defined exception handler
     */
    public static function raise($exception)
    {
        return BIOS::raise($exception);
    }
    
    /**
     * Sington for Adapter
     */
    public static function init()
    {
        if (!self::$connection)
        {
            self::$connection = self::connect();
        }
        return self::$connection;
    }
    
    /**
     * Provides access to the underlying database connection. Useful for when you need to call a proprietary method such as postgresql’s lo_* methods
     */
    public function getRawConnection()
    {
        if ($connection = self::init())
        {
            return $connection;
        }
        self::raise('ResourceNotFound');
        return NULL;
    }

	/**
	 * Is this connection active and ready to perform queries?
	 */
	public static function activeStatus()
	{
		return self::$active !== false;
	}
	
    /**
     * Returns the human-readable name of the adapter.
     */
	public function adapterName()
	{
		return 'Abstract';
	}
    
    /**
     * Close this connection
     */
    public function disconnect()
    {
        self::init()->$connection = null;
        self::$active = false;
    }
    
    /**
     * Provides access to the underlying database connection. Useful for when you need to call a proprietary method such as postgresql’s lo_* methods
     */
    public function rawConnection()
    {
        return self::init()->getRawConnection();
    }
    
    /**
     * Close this connection and open a new one in its place.   
     */
    public function reconnect()
    {
        self::$active = true;
    }
    
    /**
     * Does this adapter support using DISTINCT within COUNT? This is true for all adapters except sqlite.
     */
    public function supports_count_distinct()
    {
        return true;
    }
    
    /**
     * Lazily verify this connection, calling +active?+ only if it hasn’t been called for timeout seconds.
     */
    public function verify($timeout)
    {
        $now = time();
        if($now - self::$lastVerification > $timeout)
        {
            if (!self::active())
            {
                self::reconnect();
            }
            self::$lastVerification = $now;
        }
    }
}