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
        return DBHelper::getAssoc("SELECT * FROM categories ORDER BY id DESC");
    }

    public function getWaysByCat($cat) {
        require_once('Way.php');

        $result = [];
        $ways = DBHelper::getAssoc("SELECT w.*, n.link FROM ways w, way_nodes n WHERE cat_id = '{$cat}' AND w.id = n.way_id ORDER BY w.id, n.parent_id");

        $prev_id = $ways[0]["id"];
        $cur_id = 0;
        $route = array();
        for ($i = 0; $i < count($ways); $i++) {
            $way = $ways[$i];
            $cur_id = $way["id"];

            if ($cur_id != $prev_id) {
                array_push($result, $this->getWayInfoToShow($ways[$i - 1], $route));
                unset($route);
                $route = array();
            }

            array_push($route, $way["link"]);

            if ($i == count($ways) - 1) {
                array_push($result, $this->getWayInfoToShow($ways[$i - 1], $route));
            }


            $prev_id = $cur_id;
        }

        return $result;
    }

    private function getWayInfoToShow($way, $route) {
        return [
            "id" => $way["id"],
            "hash" => $way["hash"],
            "depth" => $way["depth"],
            "links" => $way["links"],
            "verified" => $way["verified"],
            "way" => $route
        ];
    }

    public function updateVerificationInCat($cat_id, $verify) {
        return DBHelper::update("UPDATE ways SET verified='{$verify}' WHERE cat_id = '{$cat_id}'");
    }

    public function deleteWayByHash($hash) {
        return DBHelper::delete("DELETE FROM `ways` WHERE hash = '{$hash}'");
    }

}

?>