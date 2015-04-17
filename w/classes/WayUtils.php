<?php

/**
 * Way Editor class
 */
class WayUtils {

    public function __construct() {
        require_once('DBHelper.php');
        require_once('WayParser.php');
    }

    public function addCategory($name, $description) {
        return DBHelper::insert("INSERT INTO categories SET name = '" . $name . "', description = '" . $description . "'");
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

    public function likeWay($user_id, $way_hash, $like) {
        if(WayUtils::isValidSessionId($user_id)) {

            if(DBHelper::update("UPDATE stats_unsessioned SET `like`='{$like}', `liked_at` = NOW() WHERE user_id = '{$user_id}' AND way_id IN (SELECT id FROM ways WHERE hash = '{$way_hash}')"))
                return true;
            if(DBHelper::insert("INSERT INTO stats_unsessioned (`id`, `user_id`, `way_id`, `like`, `liked_at`) SELECT NULL, '{$user_id}', id, '{$like}', NOW() FROM ways WHERE hash = '{$way_hash}'") != NULL)
                return true;
            return false;

        } else {

            if(DBHelper::update("UPDATE stats SET `like`='{$like}', `liked_at` = NOW() WHERE user_id = '{$user_id}' AND way_id IN (SELECT id FROM ways WHERE hash = '{$way_hash}')"))
                return true;
            if(DBHelper::insert("INSERT INTO stats (`id`, `user_id`, `way_id`, `like`, `liked_at`) SELECT NULL, '{$user_id}', id, '{$like}', NOW() FROM ways WHERE hash = '{$way_hash}'") != NULL)
                return true;
            return false;

        }

        
    }

    public function getLike($user_id, $way_hash) {
        if(WayUtils::isValidSessionId($user_id))
            return DBHelper::getFirst("SELECT `like` FROM stats_unsessioned WHERE user_id = '{$user_id}' AND way_id IN (SELECT id FROM ways WHERE hash = '{$way_hash}')");
        else
            return DBHelper::getFirst("SELECT `like` FROM stats WHERE user_id = '{$user_id}' AND way_id IN (SELECT id FROM ways WHERE hash = '{$way_hash}')");
    }

    public function setWaySteps($user_id, $way_hash, $count) {
        $steps = DBHelper::getFirst("SELECT `steps` FROM stats WHERE user_id = '{$user_id}' AND way_id IN (SELECT id FROM ways WHERE hash = '{$way_hash}')");
        if($steps != NULL && $count < $steps) {
            if(DBHelper::update("UPDATE stats SET `steps`='{$count}', `finished_at` = NOW() WHERE user_id = '{$user_id}' AND way_id IN (SELECT id FROM ways WHERE hash = '{$way_hash}')"))
                return true;
        } else if(DBHelper::insert("INSERT INTO stats (`id`, `user_id`, `way_id`, `steps`, `finished_at`) SELECT NULL, '{$user_id}', id, '{$count}', NOW() FROM ways WHERE hash = '{$way_hash}'") != NULL)
            return true;
        return false;
    }

    /**
    * Returns array of most rated ways with next columns for the last 24 hours
    * `hash`  -- way hash to create a link
    * `likes` -- amount of likes for this way
    * `start` -- start point link
    * `end`   -- end point link
    */
    public function getDayPopularWays() {
        $query = "
                    SELECT 
                        w.hash, 
                        daypopular.likes,
                        (SELECT link FROM way_nodes WHERE way_id = w.id ORDER BY parent_id ASC LIMIT 1) start,
                        (SELECT link FROM way_nodes WHERE way_id = w.id ORDER BY parent_id DESC LIMIT 1) end
                    FROM 
                    (
                        SELECT 
                            un.way_id, 
                            sum(`like`) 'likes' 
                        FROM 
                        (
                            SELECT 
                                `way_id`, 
                                `like` 
                            FROM stats s 
                            WHERE 
                                `liked_at` > DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                            UNION ALL
                            SELECT 
                                `way_id`, 
                                `like` 
                            FROM stats_unsessioned su
                            WHERE 
                                `liked_at` > DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                        ) un
                        GROUP BY un.way_id
                    ) daypopular,
                        ways w
                    WHERE w.id = daypopular.way_id
                    ORDER BY likes DESC
                ";
        return DBHelper::getAssoc($query);
    }


    /**
    * Returns array of most rated ways with next columns for all time
    * `hash`  -- way hash to create a link
    * `likes` -- amount of likes for this way
    * `start` -- start point link
    * `end`   -- end point link
    */
    public function getPopularWays() {
        $query = "
                    SELECT 
                        w.hash, 
                        daypopular.likes,
                        (SELECT link FROM way_nodes WHERE way_id = w.id ORDER BY parent_id ASC LIMIT 1) start,
                        (SELECT link FROM way_nodes WHERE way_id = w.id ORDER BY parent_id DESC LIMIT 1) end
                    FROM 
                    (
                        SELECT 
                            un.way_id, 
                            sum(`like`) 'likes' 
                        FROM 
                        (
                            SELECT 
                                `way_id`, 
                                `like` 
                            FROM stats s 
                            UNION ALL
                            SELECT 
                                `way_id`, 
                                `like` 
                            FROM stats_unsessioned su
                        ) un
                        GROUP BY un.way_id
                    ) daypopular,
                        ways w
                    WHERE w.id = daypopular.way_id
                    ORDER BY likes DESC
                ";
        return DBHelper::getAssoc($query);
    }

    /**
    * Returns array of top user for the last 24 hours with next columns
    * `email`  -- user email
    * `games`  -- amount of user's games
    * `points` -- user's raiting
    */
    public function getDayTopUsers() {
        $query = "
                    SELECT 
                        u.email, 
                        count(way_id) games, 
                        sum(points) points
                    FROM 
                    (
                        SELECT 
                            user_id, 
                            way_id,
                            CASE steps
                                WHEN w.min THEN 1000
                                WHEN w.min + 1 THEN 900
                                WHEN w.min + 2 THEN 700
                                WHEN w.min + 3 THEN 700
                                WHEN w.min + 4 THEN 350
                                WHEN w.min + 5 OR w.min + 6 OR w.min + 7 THEN 350
                                WHEN w.min + 8 OR w.min + 9 OR w.min + 10 THEN 100
                                ELSE 50
                            END points
                        FROM 
                            stats s,
                            ways w
                        WHERE 
                            steps > 1
                            AND w.id = s.way_id
                            AND finished_at > DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                        GROUP BY user_id
                    ) games_raits,
                        users u
                    WHERE 
                        u.id = games_raits.user_id
                    GROUP BY user_id, way_id, points
                    ORDER BY points DESC
                ";
        return DBHelper::getAssoc($query);
    }

    /**
    * Returns array of top user for all time with next columns
    * `email`  -- user email
    * `games`  -- amount of user's games
    * `points` -- user's raiting
    */
    public function getTopUsers() {
        $query = "
                    SELECT 
                        u.email, 
                        count(way_id) games, 
                        sum(points) points
                    FROM 
                    (
                        SELECT 
                            user_id, 
                            way_id,
                            CASE steps
                                WHEN w.min THEN 1000
                                WHEN w.min + 1 THEN 900
                                WHEN w.min + 2 THEN 700
                                WHEN w.min + 3 THEN 700
                                WHEN w.min + 4 THEN 350
                                WHEN w.min + 5 OR w.min + 6 OR w.min + 7 THEN 350
                                WHEN w.min + 8 OR w.min + 9 OR w.min + 10 THEN 100
                                ELSE 50
                            END points
                        FROM 
                            stats s,
                            ways w
                        WHERE 
                            steps > 1
                            AND w.id = s.way_id
                        GROUP BY user_id
                    ) games_raits,
                        users u
                    WHERE 
                        u.id = games_raits.user_id
                    GROUP BY user_id, way_id, points
                    ORDER BY points DESC
                ";
        return DBHelper::getAssoc($query);
    }

    public static function isValidSessionId($session_id) {
        return preg_match('/^[-,a-zA-Z0-9]{20,128}$/', $session_id) > 0;
    }

}

?>