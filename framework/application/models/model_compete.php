<?php
class Model_compete extends Model
{
    function __construct()
    {
        $this->ConnectDB();
    }
    function SaveSuccess(){
        $result =
            $this->query("INSERT INTO mul_stats VALUES('', $_SESSION[user_id], 12, NOW())");
        $this->UpdateRating($_SESSION["user_id"], 1500);
        if(!$result){echo mysqli_error($this); exit();}
    }
}