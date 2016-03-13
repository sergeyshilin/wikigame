<?php
class Controller_custom_ways extends Controller{
    function __construct(){
        parent::__construct();
        $this->model = new Model_custom_ways();
        $this->view = new View();
    }
    function action_index($action_param = null, $action_data = null){
        if(!$_SESSION["user_connected"]){
            header("Location: /");
        }
        if($action_param == "set" && (sizeof($_POST) > 0)){

        }
        if($action_param == "del" && $action_data !== null){

        }
        else {
            $this->view->generate("custom_views.php", "template_view.php");
        }
    }

}