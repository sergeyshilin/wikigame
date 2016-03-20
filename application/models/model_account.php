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
        $result = $this->query("SELECT way_nodes.id, way_nodes.way_id, link, parent_id,stats.finished_at as date, stats.steps, stats.game_mode, stats.is_custom, ways.hash
          FROM  `way_nodes` INNER JOIN stats ON stats.way_id = way_nodes.way_id INNER JOIN ways ON ways.id=way_nodes.way_id
          WHERE stats.user_id = '$userid' AND game_mode != 12 AND is_custom = 0 ORDER BY stats.id DESC");
        while ($out = $result->fetch_array()) {
            if ($out["parent_id"] == 0) {
                $fetched[$out["way_id"]]["start"] = $out["link"];
                $fetched[$out["way_id"]]["end_id"] = 0;
                $fetched[$out["way_id"]]["steps"] = $out["steps"];
                $fetched[$out["way_id"]]["hash"] = $out["hash"];
                $fetched[$out["way_id"]]["is_custom"] = 0;
                $fetched[$out["way_id"]]["date"] = $out["date"];
            } else if ($fetched[$out["way_id"]]["end_id"] < $out["parent_id"]) {
                $fetched[$out["way_id"]]["end_id"] = $out["id"];
                $fetched[$out["way_id"]]["end"] = $out["link"];
            }
            if($out["game_mode"] == 5){
                $fetched[$out["way_id"]]["gamelink"] = "/challenge";
            }
            if($out["game_mode"] == 3){
                $fetched[$out["way_id"]]["end"] =
                    "https://ru.wikipedia.org/wiki/%D0%93%D0%B8%D1%82%D0%BB%D0%B5%D1%80,_%D0%90%D0%B4%D0%BE%D0%BB%D1%8C%D1%84";
                $fetched[$out["way_id"]]["gamelink"] = "/hitler";
            }
            if($out["game_mode"] == 2){
                $fetched[$out["way_id"]]["gamelink"] = "/one_minute";
            }
            if($out["is_custom"] == 1){
//                $fetched[$out["way_id"]]["start"] =
//                $fetched[$out["way_id"]]["start"] =
            }
        }
        $result2 = $this->query("SELECT stats.id, stats.game_mode as game_mode, stats.steps, custom_ways.hash, custom_ways.startlink, custom_ways.endlink,
        stats.finished_at as date FROM stats INNER JOIN custom_ways ON stats.way_id=custom_ways.id WHERE stats.user_id = '$userid'
        AND is_custom=1 ORDER BY stats.id DESC");
        while($out = $result2->fetch_array()){
            $id = $out["id"];
            $fetched2[$id]["start"] = $out["startlink"];
            $fetched2[$id]["end"] = $out["endlink"];
            $fetched2[$id]["game_mode"] = $out["game_mode"];
            $fetched2[$id]["hash"] = $out["hash"];
            $fetched2[$id]["steps"] = $out["steps"];
            $fetched2[$id]["date"] = $out["date"];
            $fetched2[$id]["is_custom"] = 1;
            if($out["game_mode"] == 5){
                $fetched2[$id]["gamelink"] = "/challenge/custom/".$out["hash"];
            }
            if($out["game_mode"] == 1){
                $fetched2[$id]["gamelink"] = "/wiki/custom_way/".$out["hash"];
            }
            if($out["game_mode"] == 2){
                $fetched2[$id]["gamelink"] = "/one_minute/".$out["hash"];
            }
        }
        $output = [];
        $i = 0;
        foreach($fetched as $k=>$v){
            $output[$i] = $v;
            $i++;
        }
        foreach($fetched2 as $k=>$v){
            $output[$i] = $v;
            $i++;
        }
        function sortFunction( $a, $b ) {
            return strtotime($b["date"]) - strtotime($a["date"]);
        }
        usort($output, "sortFunction");

        return $output;
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