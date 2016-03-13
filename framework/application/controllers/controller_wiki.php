<?php
class Controller_wiki extends Controller{
    function __construct(){
        parent::__construct();
        $this->model = new Model_wiki();
        $this->view = new View();
    }
    function action_index($action_param = NULL, $action_data = NULL){
        $title = $action_param; $cat = $action_data;
//        var_dump($_SESSION);

        $title = escape($title, $this->model);
        $title = StringUtils::pageTitle($title);
        $cat = isset($cat) && !empty($cat) ? escape($cat, $this->model) : 0;
        if (WayParser::isMD5Hash($action_data)) {
            if($action_param == "way") {$way = WayParser::getWayByHash($action_param, $this->model); }
            else if($action_param == "custom_way")
            { $way = WayParser::getCustomWayByHash($action_data, $this->model);}
            if (!empty($way)) {
                wayToSession($way);
//                var_dump($way);
////                var_dump($_SESSION);
//                exit();
                header('Location: /wiki/' . $_SESSION["start"]);
            } else {
                throw new Exception();
            }
        } else if ((empty($_SESSION['start']) || empty($_SESSION['end']) || $title == "Main Page")) {
            if($_SESSION["one_minute"]["started"] !== true || ($_SESSION["hitler"]["started"] !== true)) {
                $way = WayParser::getRandomWay($cat, $this->model);
                if(isset($_SESSION["hitler"])){
                    wayToSession($way, $cat, "hitler");
                }
                else{
                    wayToSession($way, $cat);
                }
                if (isset($_SESSION["one_minute"])) {
                    $_SESSION["one_minute"]["started"] = true;
                }
                else if(isset($_SESSION["hitler"])) {
                    $_SESSION["hitler"]["started"] = true;
                    header('Location: /wiki/' . $_SESSION["start"]);
                }
                header('Location: /wiki/' . $_SESSION["start"]);
            }
        } else if (!$_SESSION['win']) {
            if (empty($_SERVER['HTTP_REFERER']) && $title != $_SESSION["current"] && !isset($_SESSION["one_minute"])) {
                header('Location: /wiki/' . $_SESSION["current"]);
            } else if ($title == $_SESSION['end']) {
                $_SESSION['counter']++;
                $_SESSION['win'] = true;
            } else {
                $resolver = new PageResolver();
                $obj = $resolver->isGenerated($title) ?
                    $resolver->getContentFromHtml($title) : $resolver->getContentFromApi($title);
                if ($resolver->isRedirect($obj["content"])) {
                    $name = $resolver->extractRedirectPageName($obj["content"]);
                    header('Location: /wiki/' . $name);
                } else if ($title == $_SESSION['start']) {
//                    echo ($title == $_SESSION['start']) ? "YES" : "NO";
                    $_SESSION['previous'] = "";
                    $_SESSION['current'] = $_SESSION['start'];
                    $_SESSION['counter'] = 0;
                } else {
                    $_SESSION['previous'] = $_SESSION['current'];
                    $_SESSION['current'] = $title;
                    if ($_SESSION['current'] != $_SESSION['previous']) {
                        $_SESSION['counter']++;
                    }
                }
            }
        }
        if (!$_SESSION['win']) {
            if (isset($_SESSION["one_minute"])) {
                    echo $resolver->printPage($obj["title"], $obj["content"]);
                    exit();
            }
            else if (isset($_SESSION["hitler"])) {
                echo $resolver->printPage($obj["title"], $obj["content"]);
                exit();
            }
            $this->view->generate("ingame_view.php","dummy.php", $resolver->printPage($obj["title"], $obj["content"]));
        }
        else {
            if(isset($_SESSION["one_minute"])||isset($_SESSION["hitler"])){
                echo "win";
                exit();
            }

            echo "SUCCESS";
        }

    }
}
function escape($str, $db) {
    $str = htmlspecialchars($str); // Escape HTML.
    $str = $db->escape($str); // Escape SQL.
    return $str;
}
function wayToSession($way, $cat = NULL, $mode = NULL) {
    $_SESSION['lang'] = $way->getLang();
    $_SESSION['cat'] = $cat;
    $_SESSION['hash'] = $way->getHash();
    $_SESSION['startlink'] = $way->getStartPoint();
    if($mode == "hitler"){
        $_SESSION['endlink'] = "https://ru.wikipedia.org/wiki/Гитлер,_Адольф";
        $_SESSION["end"] = "Гитлер, Адольф";
    }
    else {
        $way->getEndPoint();
        $_SESSION['end'] = StringUtils::pageTitle($way->getEndPoint());
    }
    $_SESSION['start'] = StringUtils::pageTitle($way->getStartPoint());
    $_SESSION['current'] = StringUtils::pageTitle($way->getStartPoint());
    $_SESSION['links'] = array();
    $_SESSION['win'] = false;
    // var_dump($_SESSION);
}
function unset_gamesession(){
    $_SESSION['lang'] = "";
    $_SESSION['cat'] = "";
    $_SESSION['hash'] = "";
    $_SESSION['startlink'] = "";
    $_SESSION['endlink'] = "";
    $_SESSION['start'] = "";
    $_SESSION['current'] = "";
    $_SESSION['end'] = "";
    $_SESSION['win'] = "";
    $_SESSION['counter'] = 0;
}
function isStart($title) {
    return $title == StringUtils::pageTitle($_SESSION['start']);
}
function isCurrent($title) {
    return $title == StringUtils::pageTitle($_SESSION['current']);
}
function isEnd($title) {
    return $title == StringUtils::pageTitle($_SESSION['end']);
}
