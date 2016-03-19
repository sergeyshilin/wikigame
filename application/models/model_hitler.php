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
        $result =
            $this->query("INSERT INTO stats VALUES('', $_SESSION[user_id], $id, $_SESSION[counter], NOW(),3, 80, 0)");
        if(!$result){echo mysqli_error($this); exit();}
    }
}