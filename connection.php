<?php
include_once('Configuration.php');
class Connection extends MySQLi
{
	private static $_instance = null;
	public static function get()
	{
		if(self::$_instance == null)
		{
			self::$_instance = new Connection();
		}
		return self::$_instance;
	}
	public function __construct()
	{
		parent::__construct(Configuration::MYSQL_HOST, Configuration::MYSQL_USER, Configuration::MYSQL_PASSWORD, Configuration::MYSQL_DATABASE);
	}
}