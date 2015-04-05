<?php

class PageResolver {
    public function getPage($name) {
        if ($this->isGenerated($name)) {
            $obj = $this->getContentFromHtml($name);
        } else {
            $obj = $this->getContentFromApi($name);
            if ($this->isRedirect($obj["content"])) {
                $newName = $this->extractRedirectPageName($obj["content"]);
                $newObj = $this->getContentFromApi($newName);
                return $this->printPage($newObj["title"], $newObj["content"], $name, $obj["title"]);
            }
        }
        return $this->printPage($obj["title"], $obj["content"]);
    }

    public function getContentFromApi($name) {
        $url = "https://" . $_SESSION['lang'] . ".wikipedia.org/w/api.php?action=parse&page=" . urlencode(urldecode($name)) . "&format=json";
        $json = file_get_contents($url);
        $obj = json_decode($json, true);
        $title = $obj['parse']['title'];
        $content = $obj['parse']['text']['*'];
        return array("title" => $title, "content" => $content);
    }

    public function getContentFromHtml($name) {
        include_once('simple_html_dom.php');
        $url = "https://" . $_SESSION['lang'] . ".wikipedia.org/w/index.php?title=" . $name;
        $html = file_get_html($url);

        foreach($html->find('a[class=external text]') as $element) {
            $link = $element->href;
            $element->href = str_replace("//" . $_SESSION['lang'] . ".wikipedia.org", "", $link);
        }

        $title = $html->find('h1[id=firstHeading]', 0)->innertext;
        $content = $html->find('div[id=mw-content-text]', 0);
        return array("title" => $title, "content" => $content);
    }

    public function isRedirect($content) {
        $needle = "<div class=\"redirectMsg\">";
        return $needle === "" || strrpos($content, $needle, -strlen($content)) !== FALSE;
    }

    public function isGenerated($title) {
        return strpos($title,'Категория:') !== false;
    }

    public function extractRedirectPageName($content) {
        $needle = "<ul class=\"redirectText\"><li><a href=\"/w/index.php?title=";
        $startPos = strpos($content, $needle);
        $end1 = strpos($content, '&amp;', $startPos + strlen($needle));
        return substr($content, $startPos + strlen($needle), $end1 - $startPos - strlen($needle));
    }

    private function cutFooter($content) {
        $lastPos = 0;
        $needle = '<h2><span class="mw-headline" id="';

        while (($lastPos = strpos($content, $needle, $lastPos))!== false) {
            $end = strpos($content, '">', $lastPos + strlen($needle));
            $str = substr($content, $lastPos + strlen($needle), $end - $lastPos - strlen($needle));
            if (strcmp($str, ".D0.9F.D1.80.D0.B8.D0.BC.D0.B5.D1.87.D0.B0.D0.BD.D0.B8.D1.8F") == 0 //Примечания
                || strcmp($str, ".D0.A1.D0.BC._.D1.82.D0.B0.D0.BA.D0.B6.D0.B5") == 0 // См. также
                || strcmp($str, ".D0.9B.D0.B8.D1.82.D0.B5.D1.80.D0.B0.D1.82.D1.83.D1.80.D0.B0") == 0 // Литература
                || strcmp($str, ".D0.A1.D1.81.D1.8B.D0.BB.D0.BA.D0.B8") == 0) { // Ссылки
                $cut_pos = $lastPos;
                break;
            }
            $lastPos = $lastPos + strlen($needle);
        }

        if (isset($cut_pos) && $cut_pos > 0) {
            return substr($content, 0, $cut_pos);
        } else {
            return $content;
        }
    }

    public function printPage($title, $content, $redirect = NULL, $redirecttitle = NULL) {
        $text = '<div id="content" class="mw-body zeromargin" role="main">' .
         '<h1 id="firstHeading" class="firstHeading" lang="ru">' . $title . '</h1>' .
         '<div id="bodyContent" class="mw-body-content">' .
         '<div id="siteSub">Материал из Википедии — свободной энциклопедии</div>';
        if (isset($redirect) && !empty($redirect) && isset($redirecttitle) && !empty($redirecttitle)) {
            $text = $text . '<span class="mw-redirectedfrom">(перенаправлено с «<a href="/wiki/' . $redirect . '" title="' . $redirecttitle . '">' . $redirecttitle . '</a>»)</span>';
        }
        $text = $text . '<div id="mw-content-text" lang="ru" dir="ltr" class="mw-content-ltr">' .
         $this->cutFooter($content) .
         "</div></div>";
        return $text;
    }
}