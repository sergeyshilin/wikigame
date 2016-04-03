<?php
class Controller_challenge extends Controller{
    function __construct(){
        parent::__construct();
        $this->model = new Model_challenge();
        $this->view = new View();
    }
    function action_index($action_param = null, $action_data = null){
        if(!isset($_SESSION["user_connected"])){
            header("Location: /");
        }
        if($action_param == "get"){
            echo json_encode($_SESSION);
            exit();
        }
//        if($action_param == "start_queue"){
//            $this->model->setUpQueue();
//            exit();
//        }
        if($action_param == "check_queue"){
            $room_data = $this->model->updateQueue();
            if($room_data != false){
                $this->model->joinRoom($room_data["way_hash"]);
                $_SESSION["challenge"]["game_hash"] = $room_data["room_hash"];
                $_SESSION["challenge"]["way_hash"] = $room_data["way_hash"];
                $_SESSION["challenge"]["way_type"] = 0;
                $_SESSION["playlink"] = "challenge";
                if($this->model->finishQueue()){
                    echo "ready";
                }
            }
            exit();
        }
        if($action_param == "queue"){
            $this->model->setUpQueue();
            $this->view->generate("challenge_queue_view.php", "template2_view.php");
            exit();
        }

        if($action_param == "success"){
            if($_SESSION["win"]){
                if(isset($_SESSION["challenge"]["way_type"]) && $_SESSION["challenge"]["way_type"] == 1){
                    $way = WayParser::getCustomWayByHash($_SESSION["challenge"]["way_hash"], $this->model);
                }
                else{
                    $way = WayParser::getWayByHash($_SESSION["challenge"]["way_hash"], $this->model);
                }
                $id = $way->getId();
                $this->model->SaveSuccess($id, $_SESSION["challenge"]["game_hash"]);
                $rank = $this->model->GetRank($_SESSION["user_id"]);
                $this->view->generate("success_view.php", "template_view.php", "/challenge", $rank);
                $this->unset_gamesession();
                exit();
            }
            else{ header("Location: /"); }
        }

        if(($action_param == "check") && (isset($_SESSION["challenge"]))){
            $info = $this->model->checkActivity($_SESSION["challenge"]["game_hash"]);
            echo json_encode($info);
            exit();
        }

        if(($action_param == "upd") && (isset($_SESSION["challenge"]))) {
            $this->model->putStamp($_SESSION["challenge"]["game_hash"]);
            if($this->model->checkIfWinner($_SESSION["challenge"]["game_hash"])){
                echo "lose";
            }
            exit();
        }
        if($action_param == "test") { var_dump($_SESSION["challenge"]); exit();}
        if($action_param == "wait") {
            if($this->model->checkForRoommate($_SESSION["challenge"]["game_hash"]))
            {
                echo "play";
            }

            exit();
        }
        if(($action_param == "join") && ($_SESSION["user_connected"]) && (isset($action_data))){
            if(!$this->model->joinRoom($action_data)) {header("Location: /");}
            $info = $this->model->prepareUser($action_data);
            $_SESSION["challenge"]["game_hash"] = $info["hash"];
            $_SESSION["challenge"]["way_hash"] = $info["way_hash"];
            $_SESSION["challenge"]["way_type"] = $info["way_type"];
            $_SESSION["playlink"] = "challenge";
            header("Location: /challenge/play");
            exit();
        }
        if($action_param == "play"){
            if(!isset($_SESSION["challenge"])) { header("Location: /");}
            $this->view->generate("challenge_play_view.php", "dummy.php");
            exit();
        }
        $this->unset_gamesession();
        unset($_SESSION["queue"]);
        $game_hash = substr(md5(time() . $_SESSION["user_id"]), 0, 8);
        $_SESSION["challenge"] = array("starttime" => time(), "game_hash" => $game_hash);
        if($action_param == "custom" && isset($action_data)){
            $_SESSION["challenge"]["way_hash"] = $action_data;
            $_SESSION["challenge"]["way_type"] = 1;
            $this->model->createRoom($game_hash, $action_data, 1);
        }
        else {
            $way = WayParser::getRandomWay(0, $this->model);
            $hash = $way->getHash();
            $_SESSION["challenge"]["way_hash"] = $hash;
            $this->model->createRoom($game_hash, $hash, 0);
        }
        $this->view->generate("challenge_start_view.php", "template2_view.php", $_SERVER["SERVER_NAME"]."/challenge/join/".$game_hash);
    }

}