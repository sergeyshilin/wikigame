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
        $cat = isset($cat) && !empty($cat) ? escape($cat, $this->model) : 0;
        if (WayParser::isMD5Hash($title)) {
            $way = WayParser::getWayByHash($title, $this->model);
            if (!empty($way)) {
                wayToSession($way);
                header('Location: /wiki/' . $_SESSION["start"]);
            } else {
                throw new Exception();
            }
        } else if (empty($_SESSION['start']) || empty($_SESSION['end']) || $title == "Main_Page") {
            unset_gamesession();
            session_start();
            $way = WayParser::getRandomWay($cat, $this->model);
            wayToSession($way, $cat, $this->model);
            // echo "STOP";
            header('Location: /wiki/' . $_SESSION["start"]);
        } else if (!$_SESSION['win']) {
            if (empty($_SERVER['HTTP_REFERER']) && $title != $_SESSION["current"]) {
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
            $utils = new WayUtils($this->model);
            $cats = $utils->getCategories();
            $this->view->generate("ingame_view.php","dummy.php", $resolver->printPage($obj["title"], $obj["content"]), $cats);
        } else {
            echo "WINNER";
        }
        
    }
}
function escape($str, $db) {
    $str = htmlspecialchars($str); // Escape HTML.
    $str = $db->escape($str); // Escape SQL.
    return $str;
}

function wayToSession(Way $way, $cat = NULL) {
    $_SESSION['lang'] = $way->getLang();
    $_SESSION['cat'] = $cat;
    $_SESSION['hash'] = $way->getHash();
    $_SESSION['startlink'] = $way->getStartPoint();
    $_SESSION['endlink'] = $way->getEndPoint();

    $_SESSION['start'] = Way::getName($way->getStartPoint());
    $_SESSION['current'] = Way::getName($way->getStartPoint());
    $_SESSION['end'] = Way::getName($way->getEndPoint());

    $_SESSION['win'] = false;
    // var_dump($_SESSION);
}
function unset_gamesession(){
    unset($_SESSION['lang']);
    unset($_SESSION['cat']);
    unset($_SESSION['hash']);
    unset($_SESSION['startlink']);
    unset($_SESSION['endlink']);
    unset($_SESSION['start']);
    unset($_SESSION['current']);
    unset($_SESSION['end']);
    unset($_SESSION['win']);
}


