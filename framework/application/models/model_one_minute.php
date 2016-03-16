<?php
class Model_one_minute extends Model
{
    function __construct()
    {
        $this->ConnectDB();
    }
    function SaveSuccess(){
        $way = WayParser::getWayByHash($_SESSION["hash"], $this);
        $id = $way->getId();
        $result =
            $this->query("INSERT INTO stats VALUES('', $_SESSION[user_id], $id, $_SESSION[counter], 0, NOW(), 0, 2)");
        $rating = 280 - (3 * (time() - $_SESSION["one_minute"]["starttime"]));
        $this->UpdateRating($_SESSION["user_id"], $rating);
        if(!$result){echo mysqli_error($this); exit();}
    }
}