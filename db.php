<?php
class SQL {
	private $mysqliconn;
	private $tblprfx;
	function __construct($hostname, $username, $password, $dbname, $tableprefix) {
		$this->mysqliconn = new mysqli($hostname, $username, $password);
		$this->select_db($dbname);
		$this->tblprfx = $tableprefix;
	}
	function select_db($dbname) {
		$this->mysqliconn->select_db($dbname);
	}
	function query($qstring) {
		return $this->mysqliconn->query($qstring);
	}
	function num_rows($result) {
		return $result->num_rows;
	}
	function fetch_assoc($result) {
		return $result->fetch_assoc();
	}
	function error() {
		return $this->mysqliconn->error;
	}
	function format_table_name($table) {
		return $this->tblprfx . $table;
	}
	function real_escape_string($string) {
		return $this->mysqliconn->real_escape_string($string);
	}
}
require('db_init.php');
?>
