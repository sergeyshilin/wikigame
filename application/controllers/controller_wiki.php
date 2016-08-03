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
            if($action_param == "way") { $way = WayParser::getWayByHash($action_data, $this->model); }
            else if($action_param == "custom_way")
            { $way = WayParser::getCustomWayByHash($action_data, $this->model); $_SESSION["custom_way"] = true;}
            if (!empty($way)) {
                wayToSession($way);
//                $_SESSION["playlink"] = ($action_param == "custom_way") ? "wiki/custom_way/".$_SESSION["hash"] :
//                    "wiki/way/".$_SESSION["hash"];
                header('Location: /wiki/' . $_SESSION["start"]);
            } else {
                throw new Exception();
            }
        }
        else if ((empty($_SESSION['start']) || empty($_SESSION['end']) || StringUtils::pageTitle($title) == "Main Page")) {
            if($_SESSION["one_minute"]["started"] !== true || ($_SESSION["hitler"]["started"] !== true)
            || $_SESSION["compete"]["started"] !== true || $_SESSION["compete"]["started"] !== true
                || $_SESSION["classic"]["started"] !== true){
                if(isset($_SESSION["one_minute"]["custom_way"])){
                    $way = WayParser::getCustomWayByHash($_SESSION["one_minute"]["custom_way"], $this->model);
                }
                else if(isset($_SESSION["one_minute"]["way_hash"])){
                    $way = WayParser::getWayByHash($_SESSION["one_minute"]["way_hash"], $this->model);
                }
                else if(isset($_SESSION["classic"]["way_hash"])){
                    $way = WayParser::getWayByHash($_SESSION["classic"]["way_hash"], $this->model);
                }
                else if(isset($_SESSION["classic"]["custom_way"])){
                    $way = WayParser::getCustomWayByHash($_SESSION["classic"]["custom_way"], $this->model);
                }
                else {$way = WayParser::getRandomWay($cat, $this->model); }

                if(isset($_SESSION["hitler"]["way_hash"])){
                    $way = WayParser::getWayByHash($_SESSION["hitler"]["way_hash"], $this->model);
                }
                if(isset($_SESSION["hitler"])){
                    wayToSession($way, $cat, "hitler");
                    $_SESSION["playlink"] = "hitler/".$_SESSION["hitler"]["type"]."/".$_SESSION["hash"];
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
                    if($_SESSION["playlink"] == ""){
                        $_SESSION["playlink"] = "one_minute/".$_SESSION["hash"];
                    }
                }
                else if(isset($_SESSION["hitler"])) {
                    $_SESSION["hitler"]["started"] = true;
                    header('Location: /wiki/' . $_SESSION["start"]);
                }
                else if(isset($_SESSION["compete"])) {
                    $_SESSION["compete"]["started"] = true;
                    $_SESSION["compete"]["step"] = 1;
                    $_SESSION["playlink"] = "compete";
                }
                else if(isset($_SESSION["classic"])){
                    $_SESSION["classic"]["started"] = true;
                    if($_SESSION["playlink"] == ""){
                        $_SESSION["playlink"] = "classic/".$_SESSION["hash"];
                    }
                    header('Location: /wiki/' . $_SESSION["start"]);

                }
                header('Location: /wiki/' . $_SESSION["start"]);
            }
        } else if (!$_SESSION['win']) {
            if (empty($_SERVER['HTTP_REFERER']) && $title != $_SESSION["current"] && !isset($_SESSION["one_minute"])) {
                header('Location: /wiki/' . $_SESSION["current"]);
            } else if ($title == $_SESSION['end']) {
                $_SESSION['counter']++;
                if(isset($_SESSION["compete"]) && $_SESSION["compete"]['step'] < 5){
                    $_SESSION["compete"]["step"]++;
                    $way = WayParser::getRandomWay(0, $this->model);
                    wayToSession($way, 0);
                    header('Location: /wiki/' . $_SESSION["start"]);
                } else {
                    if (isset($_SESSION["compete"])) {
                        $_SESSION["compete"]["step"]++;
                    }
                    $_SESSION['win'] = true;
                }
            } else {
                $germany_link = "%D0%93%D0%B5%D1%80%D0%BC%D0%B0%D0%BD%D0%B8%D1%8F";
                if(array_key_exists("hitler", $_SESSION) && $_SESSION["hitler"]["type"] == "no_germany" && $action_param == $germany_link){
                    echo "return";
                    exit();
                }
                $resolver = new PageResolver();
                $obj = $resolver->isGenerated($action_param) ?
                    $resolver->getContentFromHtml($action_param) : $resolver->getContentFromApi($action_param);
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
                        if(array_key_exists("hitler", $_SESSION) && $_SESSION["hitler"]["type"] == "5_steps" && $_SESSION["counter"] >= 5) {
                            echo "lose";
                            exit();
                        }
                    }
                }
            }
        }
        if (!$_SESSION['win']) {
            if (isset($_SESSION["one_minute"]) || isset($_SESSION["hitler"]) || isset($_SESSION["compete"])
            || isset($_SESSION["challenge"]) || isset($_SESSION["classic"])) {
//                $_SESSION["win"]=true;
//                echo "win"; exit();
                    echo $resolver->printPage($obj["title"], $obj["content"]);
                    exit();
            }
            $this->view->generate("ingame_view.php","templates/game_template.php", $resolver->printPage($obj["title"], $obj["content"]));

        } else {
            if(isset($_SESSION["one_minute"])|| isset($_SESSION["hitler"]) || (isset($_SESSION["compete"])) ||
            isset($_SESSION["challenge"]) || isset($_SESSION["classic"])){
                echo "win";
                exit();
            }
            if(isset($_SESSION["user_connected"])){
                if(!isset($_SESSION["custom_way"])){
                    $user_rating["old_rating"] = $this->model->GetRating($_SESSION["user_id"]);
                    $user_rating["old_rank"] = $this->model->GetRank($_SESSION["user_id"]);
                    $user_rating["new_rank"] = $this->model->GetRank($_SESSION["user_id"]);
                    $user_rating["new_rating"] = $user_rating["old_rating"] + 100;
                }
                $this->model->SaveSuccess($_SESSION["id"]);
            }
//            $_SESSION["playlink"] = ($_SESSION["custom_way"]) ? "wiki/custom_way/".$_SESSION["hash"] :
//                "wiki/way/".$_SESSION["hash"];
//            $this->view->generate("success_view.php", "template_view.php",  "/wiki/Main_Page", $user_rating);
//            $this->unset_gamesession();
//            unset($_SESSION["custom_way"]);
//            $this->unset_gamesession();
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
