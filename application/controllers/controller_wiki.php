<?php
class Controller_wiki extends Controller{
    function __construct(){
        parent::__construct();
        $this->model = new Model_wiki();
        $this->view = new View();
    }
    function action_index($action_param = NULL, $action_data = NULL){
        $title = $action_param; $cat = $action_data;
        $title = escape($title, $this->model);
        $title = StringUtils::pageTitle($title);
        $cat = isset($cat) && !empty($cat) ? escape($cat, $this->model) : 0;
        if (WayParser::isMD5Hash($action_data)) {
            if($action_param == "way") {$way = WayParser::getWayByHash($action_param, $this->model); }
            else if($action_param == "custom_way")
            { $way = WayParser::getCustomWayByHash($action_data, $this->model);}
            if (!empty($way)) {
                wayToSession($way);
                $_SESSION["custom_way"] = true;
                header('Location: /wiki/' . $_SESSION["start"]);
            } else {
                throw new Exception();
            }
        }
        else if ((empty($_SESSION['start']) || empty($_SESSION['end']) || StringUtils::pageTitle($title) == "Main Page")) {
            if($_SESSION["one_minute"]["started"] !== true || ($_SESSION["hitler"]["started"] !== true)
            || $_SESSION["compete"]["started"] !== true || $_SESSION["compete"]["started"] !== true){
                if(isset($_SESSION["one_minute"]["custom_way"])){
                    $way = WayParser::getCustomWayByHash($_SESSION["one_minute"]["custom_way"], $this->model);
                }
                else {$way = WayParser::getRandomWay($cat, $this->model); }
                if(isset($_SESSION["hitler"])){
                    wayToSession($way, $cat, "hitler");
                }
                else if(isset($_SESSION["challenge"]["way_hash"])){
                    if($_SESSION["challenge"]["way_type"] == 1){
                        $way = WayParser::getCustomWayByHash($_SESSION["challenge"]["way_hash"],$this->model);
                    }
                    else {
                        $way = WayParser::getWayByHash($_SESSION["challenge"]["way_hash"],$this->model);
                    }
                    wayToSession($way,0);
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
                else if(isset($_SESSION["compete"])) {
                    $_SESSION["compete"]["started"] = true;
                    $_SESSION["compete"]["step"] = 1;
                }
                header('Location: /wiki/' . $_SESSION["start"]);
            }
        } else if (!$_SESSION['win']) {
            if (empty($_SERVER['HTTP_REFERER']) && $title != $_SESSION["current"] && !isset($_SESSION["one_minute"])) {
                header('Location: /wiki/' . $_SESSION["current"]);
            } else if ($title == $_SESSION['end']) {
                $_SESSION['counter']++;
                if(isset($_SESSION["compete"])){
                    $_SESSION["compete"]["step"]++;
                    $way = WayParser::getRandomWay(0, $this->model);
                    wayToSession($way, 0);
                    header('Location: /wiki/' . $_SESSION["start"]);
                }
                else {
                    $_SESSION['win'] = true;
                }
            } else {
                $resolver = new PageResolver();
                $obj = $resolver->isGenerated($title) ?
                    $resolver->getContentFromHtml($title) : $resolver->getContentFromApi($title);
                if ($resolver->isRedirect($obj["content"])) {
                    $name = $resolver->extractRedirectPageName($obj["content"]);
                    header('Location: /wiki/' . $name);
                } else if ($title == $_SESSION['start']) {
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
            if (isset($_SESSION["one_minute"]) || isset($_SESSION["hitler"]) || isset($_SESSION["compete"])
            || isset($_SESSION["challenge"])) {
//                $_SESSION["win"]=true;
//                echo "win"; exit();
                    echo $resolver->printPage($obj["title"], $obj["content"]);
                    exit();
            }
            $this->view->generate("ingame_view.php","dummy.php", $resolver->printPage($obj["title"], $obj["content"]));
        }
        else {
            if(isset($_SESSION["one_minute"])||isset($_SESSION["hitler"]) || $_SESSION["compete"]["steps"] == 6 ||
            isset($_SESSION["challenge"])){
                echo "win";
                exit();
            }
            $user_rating = array();
            if(isset($_SESSION["user_connected"])){
                $user_rating["old_rating"] = $this->model->GetRating($_SESSION["user_id"]);
                $user_rating["old_rank"] = $this->model->GetRank($_SESSION["user_id"]);
                $this->model->SaveSuccess($_SESSION["id"]);
                $user_rating["new_rank"] = $this->model->GetRank($_SESSION["user_id"]);
                $user_rating["new_rating"] = $user_rating["old_rating"] + 100;

            }
            $this->view->generate("success_view.php", "template_view.php", "Вы прошли маршрут!", "wiki/Main_Page",
                $user_rating);
            unset($_SESSION["custom_way"]);
            $this->unset_gamesession();
        }

    }
}
function escape($str, $db) {
    $str = htmlspecialchars($str); // Escape HTML.
    $str = $db->escape($str); // Escape SQL.
    return $str;
}
function wayToSession($way, $cat = NULL, $mode = NULL) {
    $_SESSION["id"] = $way->getId();
    $_SESSION['lang'] = $way->getLang();
    $_SESSION['cat'] = $cat;
    $_SESSION['hash'] = $way->getHash();
    $_SESSION['startlink'] = $way->getStartPoint();
    if($mode == "hitler"){
        $_SESSION['endlink'] = "https://ru.wikipedia.org/wiki/Гитлер,_Адольф";
        $_SESSION["end"] = "Гитлер, Адольф";
    }
    else {
        $_SESSION['endlink'] = $way->getEndPoint();
        $_SESSION['end'] = StringUtils::pageTitle($way->getEndPoint());
    }
    $_SESSION['start'] = StringUtils::pageTitle($way->getStartPoint());
    $_SESSION['current'] = StringUtils::pageTitle($way->getStartPoint());
    $_SESSION['links'] = array();
    $_SESSION['win'] = false;
    // var_dump($_SESSION);
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
