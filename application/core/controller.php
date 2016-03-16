<?php
class Controller{
	
	public $model;
	public $view;
	

	function __construct(){
		//session_start();
		$this->view = new View();
	}

	function action_index($action_param = null, $action_data = null){}

	function unset_gamesession(){
		$_SESSION['lang'] = "";
		$_SESSION['cat'] = "";
		$_SESSION['hash'] = "";
		$_SESSION['startlink'] = "";
		$_SESSION['endlink'] = "";
		$_SESSION['start'] = "";
		$_SESSION['current'] = "";
		$_SESSION['end'] = "";
		$_SESSION['win'] = "";
		$_SESSION['counter'] = 0;
	}
}