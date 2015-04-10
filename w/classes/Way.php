<?php

class Way {
    private $id = 0;
    private $hash = "";
    private $lang = "en";
    private $way = [];
    private $depth = 0;
    private $links = 0;

    public function __construct($_id, $_depth, $_links) {
        if (!is_array($_id)) {
            $this->id = $_id;
            $this->setWayInfo();
        } else {
            $this->way = $_id;
            $this->depth = $_depth;
            $this->links = $_links;
        }
    }

    private function setWayInfo() {
        require_once('DBHelper.php');
        $id = $this->id;
        $info = DBHelper::getAssoc("SELECT * FROM ways WHERE id = '{$id}'")[0];
        $this->hash = $info["hash"];
        $this->lang = $info["lang"];
        $this->way = Way::getWayById($this->id);
    }

    public static function getWayById($id) {
        $result = [];
        require_once('DBHelper.php');
        $way = DBHelper::getAssoc("SELECT * FROM way_nodes WHERE way_id = '{$id}' order by parent_id");
        for ($i = 0; $i < count($way); $i++)
            array_push($result, $way[$i]["link"]);

        return $result;
    }

    public static function substrNodeName($string, $chars = 50) {
        preg_match('/^.{0,' . $chars . '}(?:.*?)\b/iu', $string, $matches);
        $new_string = $matches[0];
        return ($new_string === $string) ? $string : $new_string . '&hellip;';
    }

    public function getWay() {
        return $this->way;
    }

    public function getLang() {
        return $this->lang;
    }

    public static function getUrl($string) {
        $result = str_replace('\'', '', $string);
        $result = preg_replace('/\s+/', '', $result);
        return $result;
    }

    public function getDepth() {
        return $this->depth;
    }

    public function getHash() {
        return $this->hash;
    }

    public function getLinksCount() {
        return $this->links;
    }

    public function createHash() {
        return substr(md5(Way::getName($this->getStartPoint()) . Way::getName($this->getEndPoint())), 0, 7);
    }

    public static function getName($node) {
        $end = strpos($node, 'wiki/');
        return rawurldecode(substr($node, $end + strlen('wiki/')));
    }

    public function getStartPoint() {
        $result = str_replace('\'', '', $this->way[0]);
        $result = preg_replace('/\s+/', '', $result);
        return $result;
    }

    public function getEndPoint() {
        $result = str_replace('\'', '', $this->way[count($this->way) - 1]);
        $result = preg_replace('/\s+/', '', $result);
        return $result;
    }
}