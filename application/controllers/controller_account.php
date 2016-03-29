<?php
class Controller_account extends Controller{
    function __construct(){
        parent::__construct();
        $this->model = new Model_account();
        $this->view = new View();
    }
    function action_index($action_param = null, $action_data = null){
        $loggedIn = isset($_SESSION['user_connected']) && $_SESSION['user_connected'] === true;
        $this->unset_gamesession();
        if(!$loggedIn){
            header("Location: /");
        }
        if($action_param == "savenick"){
            if(!$this->model->CheckNick($_POST["nick"])){
                echo "exists";
            }
            else {
                $this->model->SetNickname($_SESSION["user_id"], $_POST["nick"]);
                echo $_POST["nick"];
            }
            exit();
        }
        $uid = $_SESSION["user_id"];
        $a = [];
        $a["nick"] = $this->model->GetNickname($uid);
        $a["rating"] = $this->model->GetRating($uid);
        $a["rank"] = $this->model->GetRank($uid);
        $a["sum"] = $this->model->GetSumOfPlayed($uid);
        $a["order"] = $this->model->GetUserOrder($uid);
        $stats["played"] =  $this->model->FetchPlayedWays($uid);
        $stats["custom_ways"] = $this->model->GetCustomRoutes($uid);
        //var_dump($a);
        //$this->model->SetNickname($uid, "TTT");
        //echo $this->model->GetRank($uid);
        //var_dump($this->model->FetchPlayedWays($uid));

        $this->view->generate("account_view.php", "templates/template_with_background.php", $a, $stats,
            $this->model->GetSumOfModes($uid));
    }
}