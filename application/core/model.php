<?php
include_once("mysql_config.php");
class Model extends mysqli{
	public function get_data(){

	}
	public function ConnectDB(){
		parent::__construct(SQLADDR, SQLUSER, SQLPWD, SQLDB);
		$this->query("SET NAMES utf8");
	}
}