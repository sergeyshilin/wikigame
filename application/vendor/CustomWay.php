<?php
class CustomWay
{
    private $id = 0;
    private $hash = "";
    private $startpoint = "";
    private $endpoint = "";
    private $lang = "ru";
    public $db;

    public function __construct($id, $db_)
    {
        $this->db = $db_;
        $this->id = $id;
        $this->setWayInfo();
    }

    private function setWayInfo()
    {
        $id = $this->id;
        $info = $this->db->getAssoc("SELECT * FROM custom_ways WHERE id = '{$id}'")[0];
        $this->startpoint = $info["startlink"];
        $this->endpoint = $info["endlink"];
        $this->hash = $info["hash"];
    }

    public static function getUrl($string)
    {
        $result = str_replace('\'', '', $string);
        $result = preg_replace('/\s+/', '', $result);
        return $result;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function getId()
    {
        return $this->id;
    }

    public static function getName($node)
    {
        $end = strpos($node, 'wiki/');
        return rawurldecode(substr($node, $end + strlen('wiki/')));
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function createHash()
    {
        return substr(md5(CustomWay::getName($this->getStartPoint()) . CustomWay::getName($this->getEndPoint())), 0, 7);
    }

    public static function staticCreateHash($startlink, $endlink)
    {
        return substr(md5($startlink . $endlink), 0, 7);
    }

    public function getStartPoint() {
        return $this->startpoint;
    }

    public function getEndPoint() {
        return $this->endpoint;
    }
}