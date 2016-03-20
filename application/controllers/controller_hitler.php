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
                $this->view->generate("success_view.php", "template_view.php", "hitler", $rank);
//                unset($_SESSION["hitler"]);
//                $this->unset_gamesession();
                exit();
            }
            else{ header("Location: /"); }
        }

        unset($_SESSION["hitler"]);
        $_SESSION["hitler"] = array("starttime" => time());
        if(WayParser::isMD5Hash($action_param)){
            $_SESSION["hitler"]["way_hash"] = $action_param;
        }
        if($action_param == "test") { echo $_SESSION["hitler"]; exit();}
        $this->view->generate("hitler_view.php", "dummy.php");
    }

}