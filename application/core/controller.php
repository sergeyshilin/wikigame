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
		$_SESSION["id"]= "";
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
		unset($_SESSION["custom_way"]);
		unset($_SESSION["playlink"]);
		unset($_SESSION["one_minute"]);
		unset($_SESSION["hitler"]);
		unset($_SESSION["compete"]);
		unset($_SESSION["challenge"]);
		unset($_SESSION["classic"]);
		unset($_SESSION["queue"]);
	}

	function getUserStatistics()
	{
		$uid = $_SESSION["user_id"];
		$rank = $this->model->GetRank($uid);
		$rating = $this->model->GetRating($uid);
		$rating = ($rating == null) ? 0 : $rating;
		$nextLevelScore = (floatval($rank) + 1)*(floatval($rank) + 1)*100;
		return [
				"rank" => $rank,
				"rating" => $rating,
				"nextLevelScore" => $nextLevelScore,
				"progress" => floatval($rating)/$nextLevelScore
		];
	}
}