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
            if($_SESSION["compete"]["step"] == 6){
                $user_rating["old_rating"] = $this->model->GetRating($_SESSION["user_id"]);
                $user_rating["old_rank"] = $this->model->GetRank($_SESSION["user_id"]);
                $this->model->SaveSuccess();
                $user_rating["new_rank"] = $this->model->GetRank($_SESSION["user_id"]);
                $user_rating["new_rating"] = $this->model->GetRating($_SESSION["user_id"]);
                $userStatistics = $this->getUserStatistics();
                $this->view->generate("success_view.php", "templates/template_with_background.php",
                    $userStatistics, "/compete", $user_rating);
                $this->unset_gamesession();
                exit();
            }
            else{ header("Location: /"); }
        }
        unset($_SESSION["compete"]);
        $this->unset_gamesession();
        $_SESSION["compete"] = array("starttime" => time());
        $_SESSION["playlink"] = "compete";
        if($action_param == "test") { echo $_SESSION["compete"]; exit();}
        $this->view->generate("compete_view.php", "templates/game_template.php");
    }

}