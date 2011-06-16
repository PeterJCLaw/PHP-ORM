<?php

require_once('dbman.class.php');
require_once('db/db.class.php');

class singletonDB extends dbman
{
	public function __construct($server = "localhost", $username = "", $password = "", $schema = "")
	{
		db::singleton($server, $username, $password, $schema);
		parent::__construct();
	}

	protected function _getConnection($name)
	{
		return db::singleton();
	}
}
