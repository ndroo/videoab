<?php

//@todo refactor to singleton to get rid of all globals
require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance(); 

Class Database
{
	private $_connections = null;
	private $rand_stats_host = null;
	private $rand_lp_host = null;

	public static function get() {
		return new self;
	}

	public function __construct() 
	{
	}

	//we only want to create a connection when its requested
	public function getConn($type = "write")
	{
		$con = null;

		//do we have a connection already?
		if($this->_connections != null && isset($this->_connections[$type]) && $this->_connections[$type] != null)
		{
			$con = $this->_connections[$type];
		}
		//we dont have a connection already, so lets create one
		else if($type == "write")
		{
			$this->_connections[$type] = $this->connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
			$con = $this->_connections[$type];
		}
		else if($type == "read")
		{
			$this->_connections[$type] = $this->connect(DB_READ_HOST,DB_USER,DB_PASS,DB_NAME);
			$con = $this->_connections[$type];
		}

		else
		{
			error_log("Unknown database connection type: $type");
			$con = null;
		}

		return $con;
	}

	public function StartTransaction()
	{
		$sql = "START TRANSACTION;";
		$this->getConn()->query($sql);
	}

	public function Commit()
	{
		$sql = "COMMIT;";
		$this->getConn()->query($sql);
	}

	public function connect($host,$user,$password,$db)
	{
		return Zend_Db::factory('Pdo_Mysql', array(
					'host' => $host,
					'username' => $user,
					'password' => $password,
					'dbname' => $db,
					));
	}
}
