<?php

class DBHelper {
    public static function escape($string) {
        require_once('SQLConfig.php');
        $sqlconfig = new SQLConfig();
        $mysqli = $sqlconfig->getMysqli();
        $string = $mysqli->escape_string($string);
        return $string;
    }

    public static function run($query)
    {
        require_once('SQLConfig.php');
        $sqlconfig = new SQLConfig();
        $mysqli = $sqlconfig->getMysqli();
        $mysqli->query($query);
        return true;
    }

    public static function delete($query) 
    {
        require_once('SQLConfig.php');
        $sqlconfig = new SQLConfig();
        $mysqli = $sqlconfig->getMysqli();
        $result = $mysqli->query($query);
        if($result === TRUE)
            return true;
        return false;
    }

    public static function insert($query)
    {
        require_once('SQLConfig.php');
        $sqlconfig = new SQLConfig();
        $mysqli = $sqlconfig->getMysqli();
        $mysqli->query($query);
        $result = $mysqli->query("SELECT LAST_INSERT_ID() AS LID");
        if ($result->num_rows > 0) {
            $item = $result->fetch_array(MYSQLI_ASSOC);
            return $item['LID'] != 0 ? $item['LID'] : NULL;
        }
        return NULL;
    }

    public static function update($query) 
    {
        require_once('SQLConfig.php');
        $sqlconfig = new SQLConfig();
        $mysqli = $sqlconfig->getMysqli();
        $mysqli->query($query);
        if ($mysqli->affected_rows > 0)
            return true;
        return false;
    }

    public static function getFirst($query)
    {
        require_once('SQLConfig.php');
        $sqlconfig = new SQLConfig();
        $mysqli = $sqlconfig->getMysqli();
        if ($result = $mysqli->query($query)) {
            if ($result->num_rows > 0) {
                return $result->fetch_array(MYSQLI_ASSOC);
            }
        }
        return NULL;
    }

    public static function getAssoc($query)
    {
        require_once('SQLConfig.php');
        $sqlconfig = new SQLConfig();
        $mysqli = $sqlconfig->getMysqli();
        $list = [];
        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_assoc()) {
                array_push($list, $row);
            }
            $result->free();
        }

        return $list;
    }
} 
