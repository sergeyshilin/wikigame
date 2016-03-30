<?php
class Model_classic extends Model
{
    function __construct()
    {
        $this->ConnectDB();
    }
    function SaveSuccess(){
        $rating = 100;
        if(isset($_SESSION["classic"]["custom_way"])){
            $way = WayParser::getCustomWayByHash($_SESSION["classic"]["custom_way"], $this);
            $is_custom = 1;
            $rating = 0;
        }
        else{
            $way = WayParser::getWayByHash($_SESSION["hash"], $this);
            $is_custom = 0;
        }
        $id = $way->getId();
        $check = $this->getAssoc("SELECT id from stats WHERE game_mode = 1 and user_id=$_SESSION[user_id] and way_id=$id
        AND is_custom = $is_custom AND finished_at BETWEEN NOW() - INTERVAL 1 DAY AND NOW()")[0]["id"];
        if($check > 0){
            $rating = 0;
        }
        $result =
            $this->query("INSERT INTO stats VALUES('', $_SESSION[user_id], $id, $_SESSION[counter], NOW(), 1, $rating, $is_custom)");
        if(!$result){echo mysqli_error($this); exit();}
    }
}