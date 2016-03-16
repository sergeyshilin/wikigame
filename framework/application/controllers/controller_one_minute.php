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
        if($action_param == "success"){
            if($_SESSION["win"]){
                $rank = 0;
                if($_SESSION["user_connected"]) {
                    $this->model->SaveSuccess();
                    $rank = $this->model->GetRank($_SESSION["user_id"]);
                }
                $this->view->generate("success_view.php", "template_view.php", "one_minute", $rank);
                exit();
            }
            else{ header("Location: /"); }
        }
        else if($action_param != ""){
            $_SESSION["one_minute"] = array("starttime" => time());
            $_SESSION["one_minute"]["custom_way"] = $action_param;
            $this->view->generate("one_minute_view.php", "dummy.php");
            exit();
        }
        unset($_SESSION["one_minute"]);
        $_SESSION["one_minute"] = array("starttime" => time());
        if($action_param == "test") { echo $_SESSION["one_minute"]; exit();}
        $this->view->generate("one_minute_view.php", "dummy.php");
    }

}