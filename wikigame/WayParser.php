<?php
	class WayParser {
		private $waysarr;
		private $path = "scripts/1.txt";
		private $lang = "en";

		public function __construct($_path) {
			require_once('Way.php');
			if(func_get_args() > 0)
				$this->path = $_path;
			$this->waysarr = $this->getWaysArray($this->path);
		}

		private function getWaysArray($path) {
			$result = [];
			$handle = @fopen($path, "r");

			if ($handle) {
			    while (($buffer = fgets($handle, 4096)) !== false) {
			    	$cell = explode('\n', $buffer)[0];
			    	$waystr = substr($cell, strpos($cell, '[') + 1, strpos($cell, ']') - 1);
			    	$wayarr = explode(', ', $waystr);
			    	$cellarr = explode(',', $cell);
			    	array_push($result, new Way($wayarr, $cellarr[count($cellarr)-2], $cellarr[count($cellarr)-1]));
			    }
			    if (!feof($handle)) {
			        echo "Error: unexpected fgets() fail\n";
			    }
			    fclose($handle);
			} else {
				echo "cant read file";
				echo $this->path;
			}

			return $result;
		}

		public function setLang($_lang) {
			$this->lang = $_lang;
		}

		public static function getRandomWay() {
			require_once('DBHelper.php');
			require_once('Way.php');
			$way = DBHelper::getAssoc("SELECT * FROM ways order by RAND() LIMIT 1")[0];
			return new Way($way["id"], $way["depth"], $way["links"]);
		}

		public static function isMD5Hash($md5 ='') {
    		return preg_match('/^[a-f0-9]{7}$/', $md5);
		}

		public static function getWayByHash($hash) {
			require_once('DBHelper.php');
			require_once('Way.php');
			$way = DBHelper::getAssoc("SELECT * FROM ways WHERE hash = '{$hash}'")[0];
			return count($way) > 0 ? (new Way($way["id"], $way["depth"], $way["links"])) : NULL;
		}

		public function writeWays() {
			require_once('SQLConfig.php');
			$sqlconfig = new SQLConfig();
	        $mysqli = $sqlconfig->getMysqli();

	        foreach ($this->waysarr as $way) {
	        	$id = NULL;
				$hash = $way->createHash();
				$depth = $way->getDepth();
				$links = $way->getLinksCount();
				$complexity = 0;
				$lang = $this->lang;
				if($mysqli->query("INSERT INTO ways VALUES(NULL, '{$hash}', '{$depth}', '{$links}', '{$complexity}', '{$lang}', 0, 0)") === TRUE) {
					$id = $mysqli->insert_id;
					$this->writeNode($mysqli, $id, $way->getWay(), 0, NULL);
				}
			}

		}

		private function writeNode(&$mysqli, $id, $nodes, $key, $parent_id) {
			$link = Way::getUrl($nodes[$key]);
			if($mysqli->query("INSERT INTO way_nodes VALUES(NULL, '{$id}', '{$link}', '{$parent_id}')") === TRUE) {
				$last_id = $mysqli->insert_id;
				$next_key = $key + 1;
				if($next_key < count($nodes))
	        		$this->writeNode($mysqli, $id, $nodes, $next_key, $last_id);
			}
		}

	}
?>