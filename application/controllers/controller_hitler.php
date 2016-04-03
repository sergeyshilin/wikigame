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
                $rank = 0;
                if($_SESSION["user_connected"]) {
                    $this->model->SaveSuccess();
                    $rank = $this->model->GetRank($_SESSION["user_id"]);
                }
                $this->view->generate("success_view.php", "template_view.php", "/hitler", $rank);
//                unset($_SESSION["hitler"]);
//                $this->unset_gamesession();
                exit();
            }
            else{ header("Location: /"); }
        }

        if($action_param == "lose"){
            echo "SORRY, 5 STEPS ONLY!";
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
        $this->view->generate("hitler_view.php", "dummy.php");
    }

}