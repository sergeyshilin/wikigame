<?php
class Controller_compete extends Controller{
    function __construct(){
        parent::__construct();
        $this->model = new Model_compete();
        $this->view = new View();
    }
    function action_index($action_param = null, $action_data = null){
        if(!$_SESSION["user_connected"]) { header("Location: /"); }
        if($action_param == "get"){
            echo json_encode($_SESSION);
            exit();
        }
        if($action_param == "lose"){
            $userStatistics = $this->getUserStatistics();
            $this->view->generate("lose_game_view.php", "templates/template_with_background.php",
                $userStatistics, "/compete");
            $this->unset_gamesession();
            exit();
        }
        if($action_param == "success"){
            if($_SESSION["compete"]["steps"] == 6){
                $this->model->SaveSuccess();
                $rank = $this->model->GetRank($_SESSION["user_id"]);
                $this->unset_gamesession();
                $userStatistics = $this->getUserStatistics();
                $this->view->generate("success_view.php", "templates/template_with_background.php",
                    $userStatistics, "/compete", $rank);
                exit();
            }
            else{ header("Location: /"); }
        }
        unset($_SESSION["compete"]);
        $this->unset_gamesession();
        $_SESSION["compete"] = array("starttime" => time());
        if($action_param == "test") { echo $_SESSION["compete"]; exit();}
        $this->view->generate("compete_view.php", "templates/game_template.php");
    }

}