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
        return $this->query("UPDATE pvp_rooms SET user2_id=$_SESSION[user_id] WHERE hash='{$game_hash}'");
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
        $this->query("INSERT INTO stats VALUES('', $_SESSION[user_id], $id, $_SESSION[counter], NOW(), 5, $rating, $is_custom)");
        $this->query("UPDATE pvp_rooms SET status=1 WHERE hash='{$game_hash}'");
//        $way = WayParser::getWayByHash($_SESSION["hash"], $this);
//        $id = $way->getId();
//        $result =
//            $this->query("INSERT INTO stats VALUES('', $_SESSION[user_id], $id, $_SESSION[counter], 0, 0, 0, 2)");
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
}