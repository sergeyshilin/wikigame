<?php
class Controller_account extends Controller{
    function __construct(){
        parent::__construct();
        $this->model = new Model_account();
        $this->view = new View();
    }
    function action_index($action_param = null, $action_data = null){
        $loggedIn = isset($_SESSION['user_connected']) && $_SESSION['user_connected'] === true;
        if(!$loggedIn){
            header("Location: /");
        }
        $uid = $_SESSION["user_id"];
        $a = [];
        $a["nick"] = $this->model->GetNickname($uid);
        $a["rating"] = $this->model->GetRating($uid);
        $a["rank"] = $this->model->GetRank($uid);
        $a["sum"] = $this->model->GetSumOfPlayed($uid);
        //var_dump($a);
        $this->model->SetNickname($uid, "TTT");
        //echo $this->model->GetRank($uid);
        //var_dump($this->model->FetchPlayedWays($uid));
        $this->view->generate("account_view.php", "template_view.php", $a, $this->model->FetchPlayedWays($uid));
    }
}