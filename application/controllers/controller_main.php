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

		if($action_param == "upd-stats"){
			$this->model->updateLeadersCache();
			$this->model->updatePopularWaysCache();
			$this->model->updateAllPopularWaysCache();
			$this->model->updateAllLeadersCache();
			exit();
		}


		if($action_param == "pgt"){
			echo StringUtils::pageTitle($_POST["pgt"]);
			exit();
		}

		if($action_param == "referer_mode" && $action_data !== ""){
			$_SESSION["referer_mode"] = $action_data;
			exit();
		}
		//Загрузка главной страницы, передачи списка категорий нет
		$this->unset_gamesession();


		$userStatistics = $this->getUserStatistics();
		$rating = array();
		$rating["leaders"] = $this->model->getLeaders();
		$rating["all_leaders"] = $this->model->getAllLeaders();
		$rating["pop_ways"] = $this->model->getPopularWays();
		$rating["all_pop_ways"] = $this->model->getAllPopularWays();
		$this->view->generate('start_page.php', 'templates/template_with_background.php',
				$userStatistics, $rating);
		unset($_SESSION["referer_mode"]);
	}
}