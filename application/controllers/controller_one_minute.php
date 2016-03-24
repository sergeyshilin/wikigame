<?php
class Controller_one_minute extends Controller{
    function __construct(){
        parent::__construct();
        $this->model = new Model_one_minute();
        $this->view = new View();
    }
    function action_index($action_param = null, $action_data = null){
        if($action_param == "get"){
            echo json_encode($_SESSION);
            exit();
        }
        if($action_param == "lose"){
            $this->view->generate("lose_game_view.php", "template_view.php", "/one_minute");
            $this->unset_gamesession();
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

                $this->view->generate("success_view.php", "template_view.php", "/one_minute", $user_rating);
                $this->unset_gamesession();
//                unset($_SESSION["one_minute"]);
//                $this->unset_gamesession();
                exit();
            }
            else{ header("Location: /"); }
        }
        else if($action_param == "custom_way" && $action_data != ""){
            $_SESSION["one_minute"] = array("starttime" => time());
            $_SESSION["one_minute"]["custom_way"] = $action_data;
            $_SESSION["playlink"] = "one_minute/custom_way/".$action_data;
            $this->view->generate("one_minute_view.php", "dummy.php");
            exit();
        }
        else if(WayParser::isMD5Hash($action_param)){
            $_SESSION["one_minute"] = array("starttime" => time());
            $_SESSION["one_minute"]["way_hash"] = $action_param;
            $_SESSION["playlink"] = "one_minute/".$action_param;
            $this->view->generate("one_minute_view.php", "dummy.php");
            exit();
        }
        else if($action_param == "playlink") { echo $_SESSION["playlink"]; exit();}
        unset($_SESSION["one_minute"]);
        $_SESSION["one_minute"] = array("starttime" => time());
        if($action_param == "test") { var_dump($_SESSION); exit();}

        $this->view->generate("one_minute_view.php", "dummy.php");
    }

}