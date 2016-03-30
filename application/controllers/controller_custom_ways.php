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
        if($action_param == "add" && (sizeof($_POST) > 0)){
            $hash = CustomWay::staticCreateHash($_POST["startlink"], $_POST["endlink"]);
            if($this->model->CheckWayIfExists($hash)) {
                echo "exists";
            }
            else {
                $check1 = $this->CheckCustomLink($_POST["startlink"]);
                $check2 = $this->CheckCustomLink($_POST["endlink"]);
                if(($check1 && $check2)&&($_POST["startlink"] != $_POST["endlink"])){
                    echo ($this->model->AddNewWay($hash, $_POST["startlink"], $_POST["endlink"]) == true) ?
                        $hash : "failed";
                }
                else echo "invalid links";

            }
        }
        else if($action_param == "del" && $action_data !== null){
            if(!$this->model->DeleteWay($action_data)){
                header("Location: /");
            }
            else header("Location: /account");
        }
    }

    function CheckCustomLink($link){
        if (!$this->startsWith($link, "//ru.wikipedia.org") &&
            !$this->startsWith($link, "https://ru.wikipedia.org") &&
            !$this->startsWith($link, "http://ru.wikipedia.org"))
            return false;
        $handle = curl_init($link);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);
        return ($httpCode == 200) ? true : false;
    }
    function startsWith($haystack, $needle) {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }


}