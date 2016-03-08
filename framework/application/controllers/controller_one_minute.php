<?php
class Controller_one_minute extends Controller{
    function __construct(){
        parent::__construct();
        $this->model = new Model_one_minute();
        $this->view = new View();
    }
    function action_index($action_param = null, $action_data = null){
        if(!(isset($_SESSION['user_connected']) && $_SESSION['user_connected'])){
            header("Location: /");
        }
        if($action_param == "get"){
            echo json_encode($_SESSION);
            exit();
        }
        if($action_param == "success"){
            if($_SESSION["win"]){
                echo "Вы прошли путь за одну минуту. Это заглушка";
                exit();
            }
            else{ header("Location: /"); }
        }
        unset($_SESSION["one_minute"]);
        $_SESSION["one_minute"] = array("starttime" => time());
        if($action_param == "test") { echo $_SESSION["one_minute"]; exit();}
        $this->view->generate("one_minute_view.php", "dummy.php");
    }

}