<?php

class PageResolver {
    private static $pageNotFoundMsg = 'В Википедии <b>нет статьи</b> с таким названием.';
    private static $undefinedMsg = 'Неизвестная ошибка.';
    private static $metaSections = array(
        ".D0.9F.D1.80.D0.B8.D0.BC.D0.B5.D1.87.D0.B0.D0.BD.D0.B8.D1.8F", // Примечания
        ".D0.9B.D0.B8.D1.82.D0.B5.D1.80.D0.B0.D1.82.D1.83.D1.80.D0.B0", // Литература
        ".D0.A1.D1.81.D1.8B.D0.BB.D0.BA.D0.B8"); // Ссылки

    public function getContentFromApi($name) {
        $url = "https://" . $_SESSION['lang'] . ".wikipedia.org/w/api.php?action=parse&page=" . urlencode(urldecode($name)) . "&format=json";
        $json = file_get_contents($url);
        $obj = json_decode($json, true);
        if (array_key_exists('parse', $obj)) {
            $title = $obj['parse']['title'];
            $content = $obj['parse']['text']['*'];
            return array("title" => $title, "content" => $content);
        } else if (array_key_exists('error', $obj)) {
            return array("title" => str_replace('_', ' ', $name),
                "content" => $this->generateErrorMsg($obj['error']['code'] == 'missingtitle' ? PageResolver::$pageNotFoundMsg : $obj['error']['code']));
        } else {
            return array("title" => str_replace('_', ' ', $name), "content" => $this->generateErrorMsg(PageResolver::$undefinedMsg));
        }
    }

    public function getContentFromHtml($name) {
        include_once('simple_html_dom.php');
        $url = "https://" . $_SESSION['lang'] . ".wikipedia.org/w/index.php?title=" . $name;

        if (isset($_GET['pagefrom']) && !empty($_GET['pagefrom'])) {
            $url .= "&pagefrom=" . htmlspecialchars($_GET['pagefrom']);
        }
        if (isset($_GET['from']) && !empty($_GET['from'])) {
            $url .= "&from=" . htmlspecialchars($_GET['from']);
        }
        if (isset($_GET['namespace']) && !empty($_GET['namespace'])) {
            $url .= "&namespace=" . htmlspecialchars($_GET['namespace']);
        }

        $html = file_get_html($url);
        $title = $html->find('h1[id=firstHeading]', 0)->innertext;
        $content = $html->find('div[id=mw-content-text]', 0);
        return array("title" => $title, "content" => (string)$content);
    }

    public function isGenerated($title) {
        return strpos($title, ':') !== false;
    }

    public function isRedirect($content) {
        $needle = "<div class=\"redirectMsg\">";
        return $needle === "" || strrpos($content, $needle, -strlen($content)) !== FALSE;
    }

    public function extractRedirectPageName($content) {
        $needle = "<ul class=\"redirectText\"><li><a href=\"/w/index.php?title=";
        $startPos = strpos($content, $needle);
        $end1 = strpos($content, '&amp;', $startPos + strlen($needle));
        return substr($content, $startPos + strlen($needle), $end1 - $startPos - strlen($needle));
    }

    private function cutMetaSections($content) {
        $lastPos = 0;
        while (($h2 = $this->substring($content, '<h2>', '</h2>', $lastPos)) !== false) {
            $str = $this->inside($h2['str'], '<span class="mw-headline" id="', '">');
            $headers[] = array('pos' => $h2['startPos'], 'str' => $str['str']);
            $lastPos = $h2['endPos'];
        }

        if (($navBox = $this->substring($content, '<table class="navbox', null, $lastPos)) !== false) {
            $content = $this->cut($content, $navBox['startPos']);
        } else if (($navBox = $this->substring($content, '<div class="NavFrame', null, $lastPos)) !== false) {
            $content = $this->cut($content, $navBox['startPos']) . "</div>";
        }

        $headers[] = array('pos' => strlen($content), 'str' => "");

        for ($i = count($headers) - 1; $i >= 0; $i--) {
            foreach (PageResolver::$metaSections as $meta) {
                if (strcmp($headers[$i]['str'], $meta) == 0) {
                    $content = $this->cut($content, $headers[$i]['pos'], $headers[$i + 1]['pos']);
                    break;
                }
            }
        }
        return $content;
    }

    public function disarmLinks($content) {
        $lang = $_SESSION['lang'];
        $lastPos = 0;
        $tags = array();
        while (($tag = $this->substring($content, '<a', '</a>', $lastPos)) !== false) {
            $tags[] = $tag;
            $lastPos = $tag['endPos'];
        }

        for ($i = count($tags) - 1; $i >= 0; $i--) {
            $link = $this->inside($tags[$i]['str'], 'href="', '"');
            if ($link !== false) {
                if ($this->startsWith($link['str'], "/wiki/") ||
                    $this->startsWith($link['str'], "/w/") ||
                    $this->startsWith($link['str'], "#")
                ) {
                    continue;
                } else if ($this->startsWith($link['str'], "//" . $lang . ".wikipedia.org") ||
                    $this->startsWith($link['str'], "https://" . $lang . ".wikipedia.org") ||
                    $this->startsWith($link['str'], "http://" . $lang . ".wikipedia.org")
                ) {
                    $newLink = $this->substring($link['str'], '/wiki/');
                    $content = $this->replace($content, $tags[$i]['startPos'] + $link['startPos'], $tags[$i]['startPos'] + $link['endPos'], $newLink['str']);
                } else {
                    $linkInside = $this->inside($tags[$i]['str'], '>', '</a>');
                    $content = $this->replace($content, $tags[$i]['startPos'], $tags[$i]['endPos'], $linkInside['str']);
                }
            }
        }

        return $content;
    }

    public function printPage($title, $content) {
        $content = $this->cutMetaSections($content);
        $content = $this->disarmLinks($content);

        return '<div id="content" class="mw-body zeromargin" role="main">' .
        '<h1 id="firstHeading" class="firstHeading" lang="ru">' . $title . '</h1>' .
        '<div id="bodyContent" class="mw-body-content">' .
        '<div id="siteSub">Материал из Википедии — свободной энциклопедии</div>' .
        '<div id="mw-content-text" lang="ru" dir="ltr" class="mw-content-ltr">' .
        $content .
        "</div></div>";
    }

    public function generateErrorMsg($msg) {
        return '<div id="noarticletext" class="plainlinks" style="padding-left: 2em; padding-right: 2em">' .
        '<div class="floatright"><a href="//commons.wikimedia.org/wiki/File:Wiki_letter_w_dashed.svg?uselang=ru" class="image"><img alt="Wiki letter w dashed.svg" src="//upload.wikimedia.org/wikipedia/commons/thumb/e/ef/Wiki_letter_w_dashed.svg/100px-Wiki_letter_w_dashed.svg.png" width="100" height="100" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/e/ef/Wiki_letter_w_dashed.svg/150px-Wiki_letter_w_dashed.svg.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/e/ef/Wiki_letter_w_dashed.svg/200px-Wiki_letter_w_dashed.svg.png 2x" data-file-width="44" data-file-height="44"></a></div>' .
        '<p>' . $msg . '</p>' .
        '<p>Вы можете cообщить нам об ошибке на этой странице, написав нам нам на почту <a href="mailto:game@wikiwalker.ru">game@wikiwalker.ru</a> ' .
        'или в <a href="https://vk.com/wikiwalker" target="_blank">группу <b>ВКонтакте</b></a></p></div>';
    }

    private function substring($content, $startStr, $endStr = null, $lastPos = 0) {
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

    private function inside($content, $startStr, $endStr, $lastPos = 0) {
        $startPos = strpos($content, $startStr, $lastPos);
        if ($startPos === false) return false;
        $endPos = strpos($content, $endStr, $startPos + strlen($startStr));
        if ($endPos === false) return false;
        $str = substr($content, $startPos + strlen($startStr), $endPos - $startPos - strlen($startStr));
        return array('startPos' => $startPos + strlen($startStr), 'endPos' => $endPos, 'str' => $str);
    }

    private function cut($content, $startPos, $endPos = null) {
        if ($endPos != null) {
            return substr($content, 0, $startPos) . substr($content, $endPos);
        } else {
            return substr($content, 0, $startPos);
        }
    }

    private function replace($content, $startPos, $endPos, $newSubStr) {
        return substr($content, 0, $startPos) . $newSubStr . substr($content, $endPos);
    }

    function startsWith($haystack, $needle) {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    function endsWith($haystack, $needle) {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }
}