<?php
	class Way {
		private $way = [];
		private $deep = 0;
		private $links = 0;

		public function __construct($_way, $_deep, $_links) {
			$this->way = $_way;
			$this->deep = $_deep;
			$this->links = $_links;
		}

		public function getStartPoint() {
			return str_replace('\'', '', $this->way[0]);
		}

		public function getEndPoint() {
			$result = str_replace('\'', '', $this->way[count($this->way) -1]);
			return $result;
		}

		public function getDeep() {
			return $this->deep;
		}

		public function getLinksCount() {
			return $this->links;
		}
	}

?>