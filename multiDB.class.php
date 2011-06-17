<?php

require_once('db/db.class.php');
require_once('dbman.class.php');

class db2 extends db
{
	public function __construct($server = "localhost", $username = "", $password = "", $schema = "")
	{
		parent::__construct($server, $username, $password, $schema);
	}
}

/**
 * Multiple Database connection manager.
 * Allows for any mapping of ORM class to database that you want.
 */
class multiDB extends dbman
{
	private $connections = array();

	private $server;
	private $username;
	private $password;

	/**
	 * @param server The default server that will be used for new connections.
	 * @param username The default username that will be used for new connections.
	 * @param password The default password that will be used for new connections.
	 */
	public function __construct($server = null, $username = null, $password = null)
	{
		$this->server   = $server;
		$this->username = $username;
		$this->password = $password;
		parent::__construct();
	}

	protected function _getConnection($name)
	{
		return $this->connections[$name];
	}

	/**
	 * Assigns a database connection to be used by a given orm class.
	 * @param ormNames An array of strings of the name of the classes that will use this connection.
	 * @param db An instance of the db class, which will be used by the given classes.
	 */
	public function setConnections($ormNames, db $db)
	{
		foreach ($ormNames as $ormName)
		{
			$this->setConnection($ormName, $db);
		}
	}

	/**
	 * Assigns a database connection to be used by a given orm class.
	 * @param ormName A string of the name of the class.
	 * @param db An instance of the db class, which will be used by the given classes.
	 */
	public function setConnection($ormName, db $db)
	{
		if (!is_subclass_of($ormName, 'orm'))
		{
			trigger_error("Class '$ormName' is not an orm class!", E_USER_WARNING);
		}
		$this->connections[$ormName] = $db;
	}

	/**
	 * Create a new db connection and assign it to be used by a given orm class.
	 * @param ormNames A string (or array of strings) of the name of the class.
	 * @param schema The database to use for the connection.
	 * @param username The username to use for the connection, defaults to the one specified in the constructor.
	 * @param password The password to use for the connection, defaults to the one specified in the constructor.
	 * @param server The server to use for the connection, defaults to the one specified in the constructor.
	 */
	public function createConnection($ormNames, $schema, $username = null, $password = null, $server = null)
	{
		$username = ($username === null) ? $this->username : $username;
		$password = ($password === null) ? $this->password : $password;
		$server   = ($server === null) ? $this->server : $server;

		$db = new db2($server, $username, $password, $schema);

		if (is_array($ormNames))
		{
			$this->setConnections($ormNames, $db);
		}
		else
		{
			$this->setConnection($ormNames, $db);
		}
	}
}
