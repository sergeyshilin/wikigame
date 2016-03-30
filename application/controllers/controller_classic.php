<?php
class Controller_classic extends Controller{
    function __construct(){
        parent::__construct();
        $this->model = new Model_classic();
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

                $this->view->generate("success_view.php", "template_view.php", "/classic", $user_rating);
//                $this->unset_gamesession();
//                unset($_SESSION["one_minute"]);
//                $this->unset_gamesession();
                exit();
            }
            else{ header("Location: /"); }
        }
        else if($action_param == "custom_way" && $action_data != ""){
            $_SESSION["classic"] = array("starttime" => time());
            $_SESSION["classic"]["custom_way"] = $action_data;
            $_SESSION["playlink"] = "classic/custom_way/".$action_data;
            $this->view->generate("classic_view.php", "dummy.php");
            exit();
        }
        else if(WayParser::isMD5Hash($action_param)){
            $_SESSION["classic"] = array("starttime" => time());
            $_SESSION["classic"]["way_hash"] = $action_param;
            $_SESSION["playlink"] = "classic/".$action_param;
            $this->view->generate("classic_view.php", "dummy.php");
            exit();
        }
        else if($action_param == "playlink") { echo $_SESSION["playlink"]; exit();}


        else if($action_param == "test") { var_dump($_SESSION); exit();}

        else {
            $this->unset_gamesession();
            $_SESSION["classic"] = array("starttime" => time());
            $this->view->generate("classic_view.php", "dummy.php");
        }
    }

}