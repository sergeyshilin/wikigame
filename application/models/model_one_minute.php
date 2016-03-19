<?php
class Model_one_minute extends Model
{
    function __construct()
    {
        $this->ConnectDB();
    }
    function SaveSuccess(){
        if(isset($_SESSION["one_minute"]["custom_way"])){
            $way = WayParser::getCustomWayByHash($_SESSION["one_minute"]["custom_way"], $this);
            $is_custom = 1;
        }
        else{
            $way = WayParser::getWayByHash($_SESSION["hash"], $this);
            $is_custom = 0;
        }
        $id = $way->getId();
        $rating = 280 - (3 * (time() - $_SESSION["one_minute"]["starttime"]));
        $result =
            $this->query("INSERT INTO stats VALUES('', $_SESSION[user_id], $id, $_SESSION[counter], NOW(), 2, $rating, $is_custom)");
        if(!$result){echo mysqli_error($this); exit();}
    }
}