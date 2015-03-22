<?php
	/**
	* Way Editor class
	*/
	class WayUtils {
		
		public function __construct() {
			require_once('DBHelper.php');
			require_once('WayParser.php');
		}

		public function getCategories() {
			return DBHelper::getAssoc("SELECT * FROM categories");
		}

		public function getWaysByCat($cat) {
			require_once('Way.php');

			$result = [];
			$ways = DBHelper::getAssoc("SELECT w.*, n.link FROM ways w, way_nodes n WHERE cat_id = '{$cat}' AND w.id = n.way_id ORDER BY w.id, n.parent_id");

			$prev_id = $ways[0]["id"];
			$cur_id = 0;
			$route = array();
			foreach ($ways as $way) {
				$cur_id = $way["id"];

				if($cur_id != $prev_id) {
					array_push($result, [
										"id" => $way["id"], 
										"hash" => $way["hash"], 
										"depth" => $way["depth"], 
										"links" => $way["links"],
										"verified" => $way["verified"],
										"way" => $route
									]
						);
					unset($route);
					$route = array();
				}

				array_push($route, $way["link"]);

				$prev_id = $cur_id;
			}

			return $result;
		}
	}
?>