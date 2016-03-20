<?php
class Model_Main extends Model{
	function __construct(){
		$this->ConnectDB();
	}
	
	function getCategories(){
		$list = [];
		$result = $this->query("SELECT * FROM categories ORDER BY id DESC");
		while ($row = $result->fetch_assoc()) {
            array_push($list, $row);
        }
        $result->free();
        return $list;
	}
	function CheckUserInDB($d){
		$q = "SELECT id FROM users WHERE login='$d[login]' AND pwd='$d[pwd]'";
		$res = $this->query($q);
		$res->data_seek(0);
		$user_id = $res->fetch_row()[0];
		if(sizeof($user_id) > 0){
			$_SESSION["user_id"] = $user_id;
			return 0;
		}
	}
	function getGameModes(){
		$game_modes = array();
		$result = $this->query("SELECT * FROM game_modes");
		if($result)
			while($out = $result->fetch_assoc()) {
				array_push($game_modes, $out);
			}
		return $game_modes;
	}
	function getLeaders(){
		return $this->getAssoc("SELECT value, nick, count FROM cache_user_rating ORDER BY value DESC LIMIT 5");
	}

	function getPopularWays()
	{
		$fetched = array();
		$result = $this->query("SELECT way_nodes.id, way_nodes.way_id, link, parent_id, ways.hash as hash,
		  cache_ways_rating.value as rating, cache_ways_rating.is_hitler
          FROM  `way_nodes` INNER JOIN cache_ways_rating ON cache_ways_rating.way_id = way_nodes.way_id INNER JOIN
          ways ON ways.id = cache_ways_rating.way_id");
		while ($out = $result->fetch_array()) {
			if ($out["parent_id"] == 0) {
				$fetched[$out["way_id"]]["start"] = StringUtils::pageTitle($out["link"]);
				$fetched[$out["way_id"]]["end_id"] = 0;
				$fetched[$out["way_id"]]["steps"] = $out["steps"];
				$fetched[$out["way_id"]]["rating"] = $out["rating"];
			} else if ($fetched[$out["way_id"]]["end_id"] <= $out["parent_id"]) {
				$fetched[$out["way_id"]]["end_id"] = $out["id"];
				$fetched[$out["way_id"]]["end"] = StringUtils::pageTitle($out["link"]);
			}
			if ($out["is_hitler"] == 1) {
				$fetched[$out["way_id"]]["end"] =
						"Гитлер, Адольф";
				$fetched[$out["way_id"]]["way_link"] = "/hitler/".$out["hash"];
			}
			else {
				$fetched[$out["way_id"]]["way_link"] = "/wiki/way/".$out["hash"];
			}
		}
		return $fetched;
	}

	function getAllPopularWays()
	{
		$fetched = array();
		$result = $this->query("SELECT way_nodes.id, way_nodes.way_id, link, parent_id, ways.hash as hash,
		  cache_ways_rating2.value as rating, cache_ways_rating2.is_hitler
          FROM  `way_nodes` INNER JOIN cache_ways_rating2 ON cache_ways_rating2.way_id = way_nodes.way_id INNER JOIN
          ways ON ways.id = cache_ways_rating2.way_id");
		while ($out = $result->fetch_array()) {
			if ($out["parent_id"] == 0) {
				$fetched[$out["way_id"]]["start"] = StringUtils::pageTitle($out["link"]);
				$fetched[$out["way_id"]]["end_id"] = 0;
				$fetched[$out["way_id"]]["steps"] = $out["steps"];
				$fetched[$out["way_id"]]["rating"] = $out["rating"];
			} else if ($fetched[$out["way_id"]]["end_id"] <= $out["parent_id"]) {
				$fetched[$out["way_id"]]["end_id"] = $out["id"];
				$fetched[$out["way_id"]]["end"] = StringUtils::pageTitle($out["link"]);
			}
			if ($out["is_hitler"] == 1) {
				$fetched[$out["way_id"]]["end"] =
						"Гитлер, Адольф";
				$fetched[$out["way_id"]]["way_link"] = "/hitler/".$out["hash"];
			}
			else {
				$fetched[$out["way_id"]]["way_link"] = "/wiki/way/".$out["hash"];
			}
		}
		return $fetched;
	}

	function refreshCache(){
		$output = $this->query("SELECT SUM( like_value ), way_id, is_hitler FROM likes GROUP BY way_id
ORDER BY SUM( like_value ) DESC LIMIT 0,5");
	}

	function updatePopularWaysCache(){
		$temp = $this->getAssoc("SELECT SUM( like_value ) as value, way_id, is_hitler FROM likes
		WHERE date BETWEEN NOW() - INTERVAL 1 DAY AND NOW() GROUP BY way_id
		ORDER BY SUM( like_value ) DESC LIMIT 5");
		$this->query("TRUNCATE cache_ways_rating");
		foreach ($temp as $k=>$v) {
			$this->query("INSERT INTO cache_ways_rating VALUES('', '{$v[way_id]}', '{$v[is_hitler]}', '{$v[value]}')");
		}
	}

	function updateAllPopularWaysCache(){
		$temp = $this->getAssoc("SELECT SUM( like_value ) as value, way_id, is_hitler FROM likes GROUP BY way_id
		ORDER BY SUM( like_value ) DESC LIMIT 5");
		$this->query("TRUNCATE cache_ways2_rating");
		foreach ($temp as $k=>$v) {
			$this->query("INSERT INTO cache_ways_rating2 VALUES('', '{$v[way_id]}', '{$v[is_hitler]}', '{$v[value]}')");
		}
	}

	function updateLeadersCache(){
		$temp = $this->getAssoc("SELECT SUM(ext_info) as value, COUNT(ext_info) as count, users.nick  FROM stats INNER JOIN users ON users.id=stats.user_id
		WHERE finished_at BETWEEN NOW() - INTERVAL 1 DAY AND NOW() GROUP BY users.nick ORDER BY SUM(ext_info) DESC LIMIT 0,5");
		$this->query("TRUNCATE cache_user_rating");
		foreach($temp as $k=>$v){
			$this->query("INSERT INTO cache_user_rating VALUES('', '{$v[nick]}', '{$v[value]}', '{$v[count]}')");
		}
	}

}