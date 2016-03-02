<?php
class Controller_Main extends Controller{
	function __construct(){
		parent::__construct();
		$this->model = new Model_Main();
		$this->view = new View();
	}
	function action_index(){
		//Загрузка главной страницы, передача списка категорий
		$this->view->generate('start_page.html', 'dummy.php', $this->model->getCategories());
	}
}