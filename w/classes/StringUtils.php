<?php

class StringUtils {
    public static function substring($content, $startStr, $endStr = null, $lastPos = 0) {
        $startPos = strpos($content, $startStr, $lastPos);
        if ($startPos === false) return false;
        if ($endStr != null) {
            $endPos = strpos($content, $endStr, $startPos + strlen($startStr));
            if ($endPos === false) return false;
            $str = substr($content, $startPos, $endPos - $startPos + strlen($endStr));
            return array('startPos' => $startPos, 'endPos' => $endPos + strlen($endStr), 'str' => $str);
        } else {
            $str = substr($content, $startPos);
            return array('startPos' => $startPos, 'endPos' => strlen($content), 'str' => $str);
        }
    }

    public static function inside($content, $startStr, $endStr, $lastPos = 0) {
        $startPos = strpos($content, $startStr, $lastPos);
        if ($startPos === false) return false;
        $endPos = strpos($content, $endStr, $startPos + strlen($startStr));
        if ($endPos === false) return false;
        $str = substr($content, $startPos + strlen($startStr), $endPos - $startPos - strlen($startStr));
        return array('startPos' => $startPos + strlen($startStr), 'endPos' => $endPos, 'str' => $str);
    }

    public static function cut($content, $startPos, $endPos = null) {
        if ($endPos != null) {
            return substr($content, 0, $startPos) . substr($content, $endPos);
        } else {
            return substr($content, 0, $startPos);
        }
    }

    public static function replace($content, $startPos, $endPos, $newSubStr) {
        return substr($content, 0, $startPos) . $newSubStr . substr($content, $endPos);
    }

    public static function startsWith($haystack, $needle) {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    public static function endsWith($haystack, $needle) {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

    public static function contains($haystack, $needle) {
        return strpos($haystack, $needle);
    }

    public static function pageTitle($link) {
        if (StringUtils::contains($link, "/wiki/") !== false) {
            $link = substr(StringUtils::substring($link, "/wiki/")['str'], strlen("/wiki/"));
        } else if (StringUtils::contains($link, "/w/") !== false) {
            $querystr = parse_url($link)["query"];
            parse_str($querystr, $query);
            $link = $query["title"];
        }
        $raw_name = rawurldecode($link);
        return str_replace("_", " ", $raw_name);
    }
}