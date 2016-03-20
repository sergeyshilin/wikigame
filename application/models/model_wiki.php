<?php
class Model_wiki extends Model
{
    function __construct()
    {
        $this->ConnectDB();
    }
    function getWayById($id)
    {
        $result = [];
        if ($q = $this->query("SELECT * FROM way_nodes WHERE way_id = '{$id}' order by parent_id")) {
            while ($row = $q->fetch_assoc()) {
                array_push($way, $row);
            }
            $q->free();
        }
        for ($i = 0; $i < count($way); $i++)
            array_push($result, $way[$i]["link"]); 
        return $result;
    }
    function SaveSuccess($id){
        $is_custom = (isset($_SESSION["custom_way"])) ? 1 : 0;
        $rating = ($is_custom == 1) ? 0 : 100;
        $this->query("INSERT INTO stats VALUES('', $_SESSION[user_id], $id, $_SESSION[counter], NOW(), 1, $rating, $is_custom)");
    }
}