<?php
class Controller_Main extends Controller{
	function __construct(){
		parent::__construct();
		$this->model = new Model_Main();
		$this->view = new View();
	}
	function action_index($action_param = null, $action_data = null){
		//Загрузка главной страницы, передачи списка категорий нет
        unset($_SESSION["one_minute"]);
		unset($_SESSION["hitler"]);
		$this->view->generate('start_page.php', 'dummy.php', $this->model->getGameModes());
	}
}