<?php
class Controller_hitler extends Controller{
    function __construct(){
        parent::__construct();
        $this->model = new Model_hitler();
        $this->view = new View();
    }
    function action_index($action_param = null, $action_data = null){
        if($action_param == "get"){
            echo json_encode($_SESSION);
            exit();
        }
        if($action_param == "success"){
            if($_SESSION["win"]){
                if($_SESSION["user_connected"]) {
                    $user_rating["old_rating"] = $this->model->GetRating($_SESSION["user_id"]);
                    $user_rating["old_rank"] = $this->model->GetRank($_SESSION["user_id"]);
                    $this->model->SaveSuccess();
                    $user_rating["new_rank"] = $this->model->GetRank($_SESSION["user_id"]);
                    $user_rating["new_rating"] = $this->model->GetRating($_SESSION["user_id"]);
                }
                $userStatistics = $this->getUserStatistics();
                $this->view->generate("success_view.php", "templates/template_with_background.php",
                    $userStatistics, "/hitler", $user_rating);
//                unset($_SESSION["hitler"]);
//                $this->unset_gamesession();
                exit();
            }
            else{ header("Location: /"); }
        }

        if($action_param == "lose"){
            $userStatistics = $this->getUserStatistics();
            $this->view->generate("lose_game_view.php", "templates/template_with_background.php",
                $userStatistics, "/hitler/5_steps");
            $this->unset_gamesession();
            exit();
        }

        unset($_SESSION["hitler"]);
        $this->unset_gamesession();
        $_SESSION["hitler"] = array("starttime" => time(), "type" => "standart");
        if(WayParser::isMD5Hash($action_data)){
            $_SESSION["hitler"]["way_hash"] = $action_data;
        }
        if($action_param != ""){
            $_SESSION["hitler"]["type"] = $action_param;
        }
        else if($action_param == "test") { var_dump($_SESSION); exit();}
        $this->view->generate("hitler_view.php", "templates/game_template.php");
    }

}