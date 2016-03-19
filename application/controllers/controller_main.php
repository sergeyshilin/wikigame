<?php
class Controller_Main extends Controller{
	function __construct(){
		parent::__construct();
		$this->model = new Model_Main();
		$this->view = new View();
	}
	function action_index($action_param = null, $action_data = null){
		$is_hitler = (isset($_SESSION["hitler"]) ? 1 : 0);
		if($action_param == "like" && $action_data=="check"){
			echo $this->model->GetLike($_SESSION["id"], $is_hitler);
			exit();
		}
		else if($action_param == "like"){

			echo $this->model->SetLike($action_data, $_SESSION["id"], $is_hitler);
			exit();
		}

		if($action_param == "upd-stat"){

		}
		//Загрузка главной страницы, передачи списка категорий нет
        unset($_SESSION["one_minute"]);
		unset($_SESSION["hitler"]);
		unset($_SESSION["compete"]);
		unset($_SESSION["challenge"]);
		$this->unset_gamesession();
		$this->view->generate('start_page.php', 'dummy.php', $this->model->getGameModes(), $this->model->getLeaders());
	}
}