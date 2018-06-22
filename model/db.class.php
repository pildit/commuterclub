<?php

class db {

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


/**
 * Save an array of rows to table $table by using INSERTs
 *
 * @param [string] $table
 * @param [array] $columns
 * @param [array] $rows
 * @return bool
 */
public static function save_rows_to_table($table, $columns, $rows) 
{

	$db = self::getInstance();
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$nb_cols = count($columns);
	$str_cols = implode(',', $columns);
	
	$func = function($val) {
		return ":$val";
	};

	$placeholders = array_map($func, $columns);
	$str_placeholders = implode(',', $placeholders);

	// try {
		$query = $db->prepare("INSERT INTO $table ($str_cols) VALUES ($str_placeholders) ");

		/** bind params */
		foreach ($columns as $col)
			$query->bindParam(":$col", $$col);

		/** generate INSERTs */	
		foreach ($rows as $row) {
			foreach ($columns as $key => $col)
				$$col = $row[$key];
				$query->execute();
		}
	// } catch (PDOException $e) {
		// print_r($query->errorInfo());
	// }

}

/**
 * Select rows from table
 *
 * @param [string] $table
 * @param [string] $where
 * @return array 
 */
public static  function select_from_table($table, $where = null) {
	$db 	= self::getInstance();
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$results = array();

	$sql = "SELECT * FROM $table " . 
			(!is_null($where) ? " WHERE $where " : ""  );
	
	$rows = $db->query($sql);

	if ($rows->rowCount())
		return $rows->fetchAll(PDO::FETCH_ASSOC);
	else
		return $results;	

}


} /*** end of class ***/

?>
