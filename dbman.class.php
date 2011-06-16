<?php

/**
 * Database connection manager.
 * Allows you to manage your database connections distinctly from your database objects.
 */
abstract class dbman
{
	// Holds an instance of the class
	private static $instance;

	/**
	 * A protected constructor; prevents direct creation of object
	 * All child classes *must* invoke the parent constructor.
	 */
	protected function __construct()
	{
		self::$instance = $this;
	}

	/**
	 * Get the database connection for the given class name.
	 * TODO: define a way of handling the non-existence of the connection.
	 * @param name The name of the class to get the DB connection for.
	 * @returns A db that contains the given class.
	 */
	public static function getConnection($name)
	{
		return self::$instance->_getConnection($name);
	}

	/**
	 * Get the database connection for the given class name.
	 * TODO: define a way of handling the non-existence of the connection.
	 * @param name The name of the class to get the DB connection for.
	 * @returns A db that contains the given class.
	 */
	protected abstract function _getConnection($name);
}
