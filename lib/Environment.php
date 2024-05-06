<?php

namespace Intratum\Facturas;

class Environment{
	
	public static $db;
	
	public static function connectDB(){


$dbs = new \PDODb(['type' => 'mysql',
                 'host' => 'localhost',
                 'username' => 'root', 
                 'password' => 'intratum',
                 'dbname'=> 'facturas',
                 'port' => 3307,
                 'prefix' => 'itt_',
                 'charset' => 'utf8']);

		self::$db = $dbs;

	}
	
}