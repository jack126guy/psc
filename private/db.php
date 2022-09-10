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
		$statement = $this->conn->query($qstring);
		if(!$statement) {
			$this->errstr = implode(' ', $this->conn->errorInfo());
			return NULL;
		}
		return $statement;
	}
	function num_rows($result) {
		return $result->rowCount();
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
	function real_escape_string($string) {
		// Really bad hack, this will be replaced with prepared statements
		return trim($this->conn->quote($string), '"\'');
	}
}
require('db_init.php');
?>
