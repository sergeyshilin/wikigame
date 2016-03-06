<?php
class Model_account extends Model{
    function __construct(){
        $this->ConnectDB();
    }
	function GetRating($userid){
        return $this->toArray("SELECT SUM(categories.rating) AS sum from categories INNER JOIN ways
         ON categories.id = ways.cat_id INNER JOIN stats
          ON stats.way_id = ways.id WHERE stats.user_id = $userid");
    }
    function GetRank($userid){
        $rating = $this->GetRating($userid);
        return (int)sqrt($rating[0]/100);
    }
    function GetSumOfPlayed($userid){
        return $this->toArray("SELECT COUNT(id) FROM stats WHERE user_id = $userid");
    }
    function FetchPlayedWays($userid)
    {
        $fetched = array();
        $result = $this->query("SELECT way_nodes.id, way_nodes.way_id, link, parent_id, stats.steps
          FROM  `way_nodes` INNER JOIN stats ON stats.way_id = way_nodes.way_id
          WHERE stats.user_id = $userid ORDER BY stats.finished_at");
        while ($out = $result->fetch_array()) {
            if ($out["parent_id"] == 0) {
                $fetched[$out["way_id"]]["start"] = $out["link"];
                $fetched[$out["way_id"]]["end_id"] = 0;
                $fetched[$out["way_id"]]["steps"] = $out["steps"];
            } else if ($fetched[$out["way_id"]]["end_id"] < $out["parent_id"]) {
                $fetched[$out["way_id"]]["end_id"] = $out["id"];
                $fetched[$out["way_id"]]["end"] = $out["link"];
            }
        }
        return $fetched;
    }
    function GenerateShortlink($userid){

    }
    function SetNickname($userid, $nick){
        if($this->toArray("SELECT id FROM users WHERE nick= '$nick'") > 0){
            return false;
        }
        return $this->query("UPDATE users SET users.nick = '$nick' WHERE users.id = $userid") === true;
    }
    function GetNickname($userid){
        return $this->toArray("SELECT nick FROM users WHERE id = $userid");
    }

}