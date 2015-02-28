<?php
	class WayParser {
		private $waysarr;
		private $path = "scripts/1.txt";

		public function __construct() {
			require_once('Way.php');
			$this->waysarr = $this->getWaysArray($this->path);
		}

		private function getWaysArray($path) {
			$result = [];
			$handle = @fopen($path, "r");

			if ($handle) {
			    while (($buffer = fgets($handle, 4096)) !== false) {
			    	$cell = explode('\n', $buffer)[0];
			    	$waystr = substr($cell, strpos($cell, '[') + 1, strpos($cell, ']') - 1);
			    	$wayarr = explode(',', $waystr);
			    	$cellarr = explode(',', $cell);
			    	array_push($result, new Way($wayarr, $cellarr[count($cellarr)-2], $cellarr[count($cellarr)-1]));
			    }
			    if (!feof($handle)) {
			        echo "Error: unexpected fgets() fail\n";
			    }
			    fclose($handle);
			} else {
				echo "cant read file";
			}

			return $result;
		}

		public function getRandomWay() {
			$max_number = count($this->waysarr);
			$index = rand(0, $max_number);
			return $this->waysarr[$index];
		}

		// public function getStartPoint() {

		// }

		// public function getEndPoint() {

		// }

		// public function getDifficulty() {
			
		// }
	}
?>