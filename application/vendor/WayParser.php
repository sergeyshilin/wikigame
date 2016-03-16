<?php

class WayParser {
    private $waysarr;
    private $path = "scripts/1.txt";
    private $lang = "en";
    public $db;
    public function __construct($_path, $db) {
        if (func_get_args() > 0) {
            $this->path = $_path;
            $this->waysarr = $this->getWaysArray($this->path);
            $this->db = $db;
        }
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
                array_push($result, new Way($wayarr, $cellarr[count($cellarr) - 2], $cellarr[count($cellarr) - 1], $this->db));
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

    public static function getRandomWay($cat = 0, $db_) {
        if ($cat == 0)
            $way = $db_->getAssoc("SELECT * FROM ways WHERE verified = 1 ORDER BY RAND() LIMIT 1")[0];
        else
            $way = $db_->getAssoc("SELECT * FROM ways WHERE cat_id = '{$cat}' AND verified = 1 order by RAND() LIMIT 1")[0];
        return new Way($way["id"], $way["depth"], $way["links"], $db_);
    }
    public static function getHitlerWay($db_){
        $way = $db_->getAssoc("SELECT * FROM ways WHERE verified = 1 ORDER BY RAND() LIMIT 1")[0];
        return new Way($way["id"], $way["depth"], $way["links"], $db_);
    }

    public static function isMD5Hash($md5 = '') {
        return preg_match('/^[a-f0-9]{7}$/', $md5);
    }

    public static function getWayByHash($hash, $db_) {
        $way = $db_->getAssoc("SELECT * FROM ways WHERE hash = '{$hash}'")[0];
        return count($way) > 0 ? (new Way($way["id"], $way["depth"], $way["links"], $db_)) : NULL;
    }
    public static function getCustomWayByHash($hash, $db_){
        $way = $db_->getAssoc("SELECT * FROM custom_ways WHERE hash = '{$hash}'")[0];
//        var_dump($way);
        return count($way) > 0 ? (new CustomWay($way["id"], $db_)) : NULL;
    }

    public function getWays() {
        return $this->waysarr;
    }

    public function setLang($_lang) {
        $this->lang = $_lang;
    }

    public function writeWays($cat) {
        $hashes = array();

        /* @var $way Way */
        foreach ($this->waysarr as $way) {
            $id = NULL;
            $hash = $way->createHash();
            $depth = $way->getDepth();
            $links = $way->getLinksCount();
            $complexity = 0;
            $lang = $this->lang;
            if ($this->db->query("INSERT INTO ways VALUES(NULL, '{$cat}', '{$hash}', '{$depth}', '{$links}', '{$complexity}', '{$lang}', 0, 0, 0)") === TRUE) {
                $id = $this->db->insert_id;
                $this->writeNode($db, $id, $way->getWay(), 0, NULL);
                $hashes[] = $hash;
            } else {
                throw new Exception("Can't create way");
            }
        }

        return $hashes;
    }

    private function writeNode(&$db_, $id, $nodes, $key, $parent_id) {
        $link = Way::getUrl($nodes[$key]);
        /* @var $mysqli mysqli */
        if ($db_->query("INSERT INTO way_nodes VALUES(NULL, '{$id}', '{$link}', '{$parent_id}')") === TRUE) {
            $last_id = $db_->insert_id;
            $next_key = $key + 1;
            if ($next_key < count($nodes)) {
                $this->writeNode($db_, $id, $nodes, $next_key, $last_id);
            }
        } else {
            throw new Exception("Can't create node");
        }
    }

}

?>