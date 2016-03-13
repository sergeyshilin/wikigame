<?php
class Model_custom_ways extends Model
{
    function __construct()
    {
        $this->ConnectDB();
    }

    function AddNewWay($hash, $startlink, $endlink){
        $result = $this->query("INSERT INTO custom_ways VALUES('', $_SESSION[user_id], $hash, $startlink, $endlink, NOW())");
        return $result;
    }

    function CheckWayIfExists($hash){
        $result = ($this->query("SELECT id from custom_ways WHERE hash='{$hash}' AND user_id=$_SESSION[user_id]")[0] > 0);
        return $result;
    }

    function DeleteWay($hash){
        $result = $this->getAssoc("SELECT id from custom_ways WHERE hash = '{$hash}' AND user_id = $_SESSION[user_id]")[0];
        if($result > 0) return false;
        else {
            $this->query("DELETE FROM custom_ways WHERE hash = '{$hash}' AND user_id = $_SESSION[user_id]");
            return true;
        }
    }
}