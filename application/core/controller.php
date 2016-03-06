<?php
class Controller{
	
	public $model;
	public $view;
	

	function __construct(){
		session_start();
		$this->view = new View();
	}

	function action_index(){}

}