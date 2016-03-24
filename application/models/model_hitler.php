<?php
class Model_hitler extends Model
{
    function __construct()
    {
        $this->ConnectDB();
    }
    function SaveSuccess(){
        $way = WayParser::getWayByHash($_SESSION["hash"], $this);
        $id = $way->getId();
        $rating = 0;
        $check = $this->getAssoc("SELECT id from stats WHERE game_mode = 3 and user_id=$_SESSION[user_id] and way_id=$id
        AND finished_at   BETWEEN NOW() - INTERVAL 1 DAY AND NOW()")[0]["id"];
        if($check == 0){
            $rating = 80;
        }
        $result =
            $this->query("INSERT INTO stats VALUES('', $_SESSION[user_id], $id, $_SESSION[counter], NOW(),3, $rating, 0)");
        if(!$result){echo mysqli_error($this); exit();}
    }
}