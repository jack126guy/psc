<?php
class SQL {
	private $conn;
	private $errstr;
	private $tblprfx;
	function __construct($hostname, $username, $password, $dbname, $tableprefix) {
		$this->conn = new PDO('mysql:host=' . $hostname . ';dbname=' . $dbname, $username, $password);
		$this->tblprfx = $tableprefix;
	}
	function query($qstring, $params = array()) {
		$statement = $this->conn->prepare($qstring);
		if(!$statement) {
			$this->errstr = implode(' ', $this->conn->errorInfo());
			return NULL;
		}
		$execresult = $statement->execute($params);
		if(!$execresult) {
			$this->errstr = implode(' ', $statement->errorInfo());
			return NULL;
		}
		return $statement;
	}
	function fetch_assoc($result) {
		return $result->fetch(PDO::FETCH_ASSOC);
	}
	function error() {
		return $this->errstr;
	}
	function format_table_name($table) {
		return $this->tblprfx . $table;
	}
}
require('db_init.php');
?>
