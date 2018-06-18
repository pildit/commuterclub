<?php

class db{

/*** Declare instance ***/
private static $instance = NULL;

/**
*
* the constructor is set to private so
* so nobody can create a new instance using new
*
*/
private function __construct() {

}

/**
*
* Return DB instance or create initial connection
*
*/
public static function getInstance() {

global $configs;

if (!self::$instance)
{ 
	 try { 
		 $dsn = "mysql:host=" . $configs['db_hostname'] .  ";dbname=" . $configs['db_name'];
		 
		 self::$instance = new PDO($dsn, $configs['db_username'], $configs['db_password']);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
}

return self::$instance;
}

/**
*
* Like the constructor, we make __clone private
* so nobody can clone the instance
*
*/
private function __clone(){
}

} /*** end of class ***/

?>
