<?php

namespace W\Model;

use \PDO;
use \PDOException;

/**
 * Manages connection to DB (Singleton Pattern)
 */
class ConnectionModel{

	private static $dbh;

	/**
	 * Creates connection or returns it if it already exists
	 */
	public static function getDbh(){

		if(!self::$dbh){
			self::setNewDbh();
		}
		return self::$dbh;

	}


	/**
	 * Creates a new connection to the DB
	 */
	public static function setNewDbh(){

		$app = getApp();

		try{
		    self::$dbh = new PDO('mysql:host='.$app->getConfig('db_host').';dbname='.$app->getConfig('db_name'), $app->getConfig('db_user'), $app->getConfig('db_pass'), array(
		        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
		    ));
		}catch(PDOException $e){
		    echo 'Erreur de connexion : ' . $e->getMessage();
		}

	}

}
