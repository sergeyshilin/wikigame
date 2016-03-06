<?php
class Controller_wiki extends Controller{
    function __construct(){
        parent::__construct();
        $this->model = new Model_wiki();
        $this->view = new View();
    }
    function action_index(){
    
        //$title = escape($_GET['title']);
        $cat = isset($action_param) && !empty($action_param) ? escape($action_param) : 0;
    
        if (WayParser::isMD5Hash($title)) {
            $way = WayParser::getWayByHash($title);
            if (!empty($way)) {
                wayToSession($way);
                header('Location: /wiki/index/' . $_SESSION["start"]);
            } else {
                throw new Exception();
            }
        } else if (empty($_SESSION['start']) || empty($_SESSION['end']) || $title == "Main_Page") {
            $way = WayParser::getRandomWay($cat);
            wayToSession($way, $cat);
            header('Location: /wiki/index/' . $_SESSION["start"]);
        } else if (!$_SESSION['win']) {
            if (empty($_SERVER['HTTP_REFERER']) && $title != $_SESSION["current"]) {
                header('Location: /wiki/index/' . $_SESSION["current"]);
            } else if ($title == $_SESSION['end']) {
                $_SESSION['counter']++;
                $_SESSION['win'] = true;
            } else {
                include_once("classes/PageResolver.php");
                $resolver = new PageResolver();
                $obj = $resolver->isGenerated($title) ? $resolver->getContentFromHtml($title) : $resolver->getContentFromApi($title);
                if ($resolver->isRedirect($obj["content"])) {
                    $name = $resolver->extractRedirectPageName($obj["content"]);
                    header('Location: /wiki/index/' . $name);
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
    }
}


class WayParser {
    private $waysarr;
    private $path = "application/scripts/1.txt";
    private $lang = "en";

    public function __construct($_path) {
        require_once('Way.php');
        if (func_get_args() > 0) {
            $this->path = $_path;
            $this->waysarr = $this->getWaysArray($this->path);
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
                array_push($result, new Way($wayarr, $cellarr[count($cellarr) - 2], $cellarr[count($cellarr) - 1]));
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

    public static function getRandomWay($cat = 0) {
        if ($cat == 0)
            $way = DBHelper::getAssoc("SELECT * FROM ways WHERE verified = 1 ORDER BY RAND() LIMIT 1")[0];
        else
            $way = DBHelper::getAssoc("SELECT * FROM ways WHERE cat_id = '{$cat}' AND verified = 1 order by RAND() LIMIT 1")[0];
        return new Way($way["id"], $way["depth"], $way["links"]);
    }

    public static function isMD5Hash($md5 = '') {
        return preg_match('/^[a-f0-9]{7}$/', $md5);
    }

    public static function getWayByHash($hash) {
        require_once('DBHelper.php');
        require_once('Way.php');
        $way = DBHelper::getAssoc("SELECT * FROM ways WHERE hash = '{$hash}'")[0];
        return count($way) > 0 ? (new Way($way["id"], $way["depth"], $way["links"])) : NULL;
    }

    public function getWays() {
        return $this->waysarr;
    }

    public function setLang($_lang) {
        $this->lang = $_lang;
    }

    public function writeWays($cat) {
        require_once('SQLConfig.php');
        $sqlconfig = new SQLConfig();
        $mysqli = $sqlconfig->getMysqli();

        $hashes = array();

        /* @var $way Way */
        foreach ($this->waysarr as $way) {
            $id = NULL;
            $hash = $way->createHash();
            $depth = $way->getDepth();
            $links = $way->getLinksCount();
            $complexity = 0;
            $lang = $this->lang;
            if ($mysqli->query("INSERT INTO ways VALUES(NULL, '{$cat}', '{$hash}', '{$depth}', '{$links}', '{$complexity}', '{$lang}', 0, 0, 0)") === TRUE) {
                $id = $mysqli->insert_id;
                $this->writeNode($mysqli, $id, $way->getWay(), 0, NULL);
                $hashes[] = $hash;
            } else {
                throw new Exception("Can't create way");
            }
        }

        return $hashes;
    }

    private function writeNode(&$mysqli, $id, $nodes, $key, $parent_id) {
        $link = Way::getUrl($nodes[$key]);
        /* @var $mysqli mysqli */
        if ($mysqli->query("INSERT INTO way_nodes VALUES(NULL, '{$id}', '{$link}', '{$parent_id}')") === TRUE) {
            $last_id = $mysqli->insert_id;
            $next_key = $key + 1;
            if ($next_key < count($nodes)) {
                $this->writeNode($mysqli, $id, $nodes, $next_key, $last_id);
            }
        } else {
            throw new Exception("Can't create node");
        }
    }

}


class Way {
    private $id = 0;
    private $hash = "";
    private $lang = "en";
    private $way = [];
    private $depth = 0;
    private $links = 0;

    public function __construct($_id, $_depth, $_links) {
        if (!is_array($_id)) {
            $this->id = $_id;
            $this->setWayInfo();
        } else {
            $this->way = $_id;
            $this->depth = $_depth;
            $this->links = $_links;
        }
    }

    private function setWayInfo() {
        require_once('DBHelper.php');
        $id = $this->id;
        $info = $this->model->getAssoc("SELECT * FROM ways WHERE id = '{$id}'")[0];
        $this->hash = $info["hash"];
        $this->lang = $info["lang"];
        $this->way = Way::getWayById($this->id);
    }

    public static function getWayById($id) {
        return $this->model->getWayById($id);
    }

    public static function substrNodeName($string, $chars = 50) {
        preg_match('/^.{0,' . $chars . '}(?:.*?)\b/iu', $string, $matches);
        $new_string = $matches[0];
        return ($new_string === $string) ? $string : $new_string . '&hellip;';
    }

    public function getWay() {
        return $this->way;
    }

    public function getLang() {
        return $this->lang;
    }

    public static function getUrl($string) {
        $result = str_replace('\'', '', $string);
        $result = preg_replace('/\s+/', '', $result);
        return $result;
    }

    public function getDepth() {
        return $this->depth;
    }

    public function getHash() {
        return $this->hash;
    }

    public function getLinksCount() {
        return $this->links;
    }

    public function createHash() {
        return substr(md5(Way::getName($this->getStartPoint()) . Way::getName($this->getEndPoint())), 0, 7);
    }

    public static function getName($node) {
        $end = strpos($node, 'wiki/');
        return rawurldecode(substr($node, $end + strlen('wiki/')));
    }

    public function getStartPoint() {
        $result = str_replace('\'', '', $this->way[0]);
        $result = preg_replace('/\s+/', '', $result);
        return $result;
    }

    public function getEndPoint() {
        $result = str_replace('\'', '', $this->way[count($this->way) - 1]);
        $result = preg_replace('/\s+/', '', $result);
        return $result;
    }
}