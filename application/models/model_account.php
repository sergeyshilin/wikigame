<?php
class Model_account extends Model{
    function __construct(){
        $this->ConnectDB();
    }

    function GetSumOfPlayed($userid){
        return $this->toArray("SELECT COUNT(id) FROM stats WHERE user_id = '$userid'");
    }
    function FetchPlayedWays($userid)
    {
        $fetched = array();
        $result = $this->query("SELECT way_nodes.id, way_nodes.way_id, link, parent_id, stats.steps, stats.game_mode, stats.is_custom
          FROM  `way_nodes` INNER JOIN stats ON stats.way_id = way_nodes.way_id
          WHERE stats.user_id = '$userid' AND game_mode != 12 ORDER BY stats.id DESC");
        while ($out = $result->fetch_array()) {
            if ($out["parent_id"] == 0) {
                $fetched[$out["way_id"]]["start"] = $out["link"];
                $fetched[$out["way_id"]]["end_id"] = 0;
                $fetched[$out["way_id"]]["steps"] = $out["steps"];
            } else if ($fetched[$out["way_id"]]["end_id"] < $out["parent_id"]) {
                $fetched[$out["way_id"]]["end_id"] = $out["id"];
                $fetched[$out["way_id"]]["end"] = $out["link"];
            }
            if($out["game_mode"] == 3){
                $fetched[$out["way_id"]]["end"] =
                    "https://ru.wikipedia.org/wiki/%D0%93%D0%B8%D1%82%D0%BB%D0%B5%D1%80,_%D0%90%D0%B4%D0%BE%D0%BB%D1%8C%D1%84";
            }
            if($out["is_custom"] == 1){
//                $fetched[$out["way_id"]]["start"] =
//                $fetched[$out["way_id"]]["start"] =
            }
        }
        return $fetched;
    }
    function GetCustomRoutes($user_id){
        return $this->getAssoc("SELECT * FROM custom_ways WHERE user_id = $user_id");
    }
    function GenerateShortlink($userid){

    }

    function GetUserOrder($user_id){
        $result = $this->query("SELECT user_id FROM stats GROUP BY user_id ORDER BY SUM( ext_info ) DESC ");
        $i = 1;
        while($out = $result->fetch_array()){
            if($out["user_id"] == $user_id){break;}
            $i++;
        }
        $total = $this->getAssoc("SELECT COUNT(id) as count FROM users")[0]["count"];
        return $i ." из ". $total;
    }

    function GetSumOfModes($user_id){
        $result = $this->query("SELECT game_modes.id AS gm, COUNT( stats.id ) AS count
FROM stats
INNER JOIN game_modes ON game_modes.id = stats.game_mode
WHERE user_id =$user_id
GROUP BY game_modes.id");
        $sum = array("1"=>array("Классический"), "2"=>array("На время"), "3"=>array("Гитлер"), "5"=>array("Дуэль"),
            "12"=>array("Турнир"));
        if($result){
            while($out = $result->fetch_array()){
                $sum[$out["gm"]][] = $out["count"];
            }
        }
        return $sum;
    }
    function SetNickname($userid, $nick){
        $this->query("UPDATE users SET users.nick = '$nick' WHERE users.id = $userid");
    }

    function CheckNick($nick){
        return ($this->getAssoc("SELECT id FROM users WHERE nick='{$nick}'")[0] > 0) ? false : true;

    }

    function GetNickname($userid){
        return $this->toArray("SELECT nick FROM users WHERE id = $userid");
    }

}