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
}