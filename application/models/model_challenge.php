<?php
class Model_challenge extends Model
{
    function __construct()
    {
        $this->ConnectDB();
    }
    function createRoom($game_hash, $hash, $way_type){
        $this->query("INSERT INTO pvp_rooms VALUES('', $_SESSION[user_id], '', '{$game_hash}', '{$hash}', $way_type, NOW(), 0, 0)");
    }
    function joinRoom($game_hash){
        $check = $this->getAssoc("SELECT id FROM pvp_rooms WHERE hash='{$game_hash}' AND user1_id != '{$_SESSION[user_id]}'")[0]["id"];
        if(sizeof($check) <= 0) return false;
        else $this->query("UPDATE pvp_rooms SET user2_id=$_SESSION[user_id] WHERE hash='{$game_hash}'");
        return true;
    }

    function tryRoom($game_hash){
        $check = $this->getAssoc("SELECT id FROM pvp_rooms WHERE hash='{$game_hash}'")[0]["id"];
        return(sizeof($check) <= 0) ? false : true;
    }
    function prepareUser($game_hash){
        return $this->getAssoc("SELECT hash, way_hash, way_type from pvp_rooms WHERE hash='{$game_hash}'")[0];
    }
    function SaveSuccess($id, $game_hash){
        if($_SESSION["challenge"]["way_type"] == 1){
            $is_custom = 1;
            $rating = 0;
        }
        else{
            $is_custom = 0;
            $rating = 200;
        }
        $check = $this->getAssoc("SELECT id from stats WHERE game_mode = 5 and user_id=$_SESSION[user_id] and way_id=$id
        AND is_custom = $is_custom AND finished_at BETWEEN NOW() - INTERVAL 1 DAY AND NOW()")[0]["id"];
        if($check > 0){
            $rating = 0;
        }
        $this->query("INSERT INTO stats VALUES('', $_SESSION[user_id], $id, $_SESSION[counter], NOW(), 5, $rating, $is_custom)");
        $this->query("UPDATE pvp_rooms SET status=1 WHERE hash='{$game_hash}'");
//        $way = WayParser::getWayByHash($_SESSION["hash"], $this);
//        $id = $way->getId();
//        $result =
//            $this->query("INSERT INTO stats VALUES('', $_SESSION[user_id], $id, $_SESSION[counter], 0, 0, 0, 2)");
    }

    function SaveLose($id, $game_hash){
        //todo: count new user rank if lose at challenge type of the game
        return true;
        //exit();
    }

    function checkForRoommate($game_hash){
        return ($this->getAssoc("SELECT user2_id FROM pvp_rooms WHERE hash='{$game_hash}'")[0]["user2_id"] > 0);
    }

    function putStamp($game_hash){
        $time = time();
        $room_id = $this->getAssoc("SELECT id FROM pvp_rooms WHERE hash='{$game_hash}'")[0]["id"];
        $this->query("INSERT INTO pvp_temp VALUES('', $room_id, $_SESSION[user_id], '{$_SESSION[current]}', $_SESSION[counter], $time)");
    }
    function checkActivity($game_hash){
        $room_id = $this->getAssoc("SELECT id FROM pvp_rooms WHERE hash='{$game_hash}'")[0]["id"];
        return $this->getAssoc("SELECT pvp_temp.id, pvp_temp.link, pvp_temp.counter, pvp_temp.date, users.nick
          FROM pvp_temp INNER JOIN users ON users.id = pvp_temp.user_id WHERE room_id = $room_id AND user_id != $_SESSION[user_id] ORDER BY id DESC")[0];
    }

    function checkIfWinner($game_hash){
        return $this->getAssoc("SELECT status FROM pvp_rooms WHERE hash='{$game_hash}'")[0]["status"] != 0;
    }

    function setUpQueue(){
        $this->lockQueueTable();
        $time = time();
        $check = $this->getAssoc("SELECT * FROM pvp_queues WHERE $time - pvp_queues.date <= 5")[0];
        if($check["id"] > 0){
            $_SESSION["queue"]["id"] = $check["id"];
            $room_hash = substr(md5(time() . $_SESSION["user_id"]), 0, 8);
            $this->query("UPDATE pvp_queues SET room_hash = '{$room_hash}' WHERE id=$check[id]");
            $way = WayParser::getRandomWay(0, $this);
            $way_hash = $way->getHash();
            $_SESSION["queue"]["init"] = true;
            $this->query("INSERT INTO pvp_rooms VALUES ('', $_SESSION[user_id], '', '{$room_hash}','{$way_hash}', 0, NOW(), '', 0)");
            //echo mysqli_error($this);
        }
        else{
            $time = time();
            $this->query("INSERT INTO pvp_queues VALUES ('',$_SESSION[user_id], $time, '')");
            $queue_id = $this->getAssoc("SELECT id FROM pvp_queues ORDER BY id DESC")[0]["id"];
            $_SESSION["queue"]["id"] = $queue_id;
        }
        $this->unlockQueueTable();
    }
    function updateQueue(){
        $this->lockQueueTable();
        $time = time();
        $queue_id = $_SESSION["queue"]["id"];
        $this->query("UPDATE pvp_queues SET date = '{$time}' WHERE id=$queue_id");

        $result = $this->getAssoc("SELECT room_hash, pvp_rooms.way_hash as way_hash, pvp_rooms.user1_id as user1_id
        FROM pvp_queues INNER JOIN pvp_rooms
        ON pvp_rooms.hash = pvp_queues.room_hash WHERE pvp_queues.id=$queue_id")[0];
        $this->unlockQueueTable();
        return (sizeof($result) > 0) ? $result : false;
    }
    function finishQueue(){
        $this->lockQueueTable();
        $code = false;
        $game_hash = $_SESSION["challenge"]["game_hash"];
        if(isset($_SESSION["queue"]["init"])){
            $check = $this->getAssoc("SELECT user2_id FROM pvp_rooms WHERE hash='{$game_hash}'")[0]["user2_id"];
            if($check > 0){
                $code = true;
            }
        }
        else{
            $this->query("UPDATE pvp_rooms SET user2_id=$_SESSION[user_id] WHERE hash='{$game_hash}'");
            $code = true;
        }
        $this->unlockQueueTable();
        return $code;
    }

    function lockQueueTable(){
//        $this->query("LOCK TABLES pvp_queues WRITE");
    }

    function unlockQueueTable(){
//        $this->query("UNLOCK TABLES");
    }
}