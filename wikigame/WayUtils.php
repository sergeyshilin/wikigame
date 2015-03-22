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
			$ways = DBHelper::getAssoc("SELECT * FROM ways WHERE cat_id = '{$cat}'");


			foreach ($ways as $way) {
				array_push($result, [
										"id" => $way["id"], 
										"hash" => $way["hash"], 
										"depth" => $way["depth"], 
										"links" => $way["links"],
										"verified" => $way["verified"],
										"way" => Way::getWayById($way["id"])
									]
						);
			}

			return $result;
		}
	}
?>