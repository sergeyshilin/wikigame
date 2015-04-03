<?php

class PageResolver {
    public function getPage($name) {
        $obj = $this->getPageByName($name);
        $title = $obj['parse']['title'];
        $content = $obj['parse']['text']['*'];

        if ($this->isRedirect($content)) {
            $this->getRedirectPage($content);
            $title = $obj['parse']['title'];
            $content = $obj['parse']['text']['*'];
        }

        return $this->printPage($title, $content);
    }

    private function getPageByName($name) {
        $url = "https://" . $_SESSION['lang'] . ".wikipedia.org/w/api.php?action=parse&page=" . $name . "&format=json";
        $json = file_get_contents($url);
        $obj = json_decode($json, true);
        return $obj;
    }

    private function isRedirect($content) {
        $needle = "<div class=\"redirectMsg\">";
        return $needle === "" || strrpos($content, $needle, -strlen($content)) !== FALSE;
    }

    private function getRedirectPage($content) {
        $needle = "<ul class=\"redirectText\"><li><a href=\"/w/index.php?title=";
        $startPos = strpos($content, $needle);
        $end1 = strpos($content, '&', $startPos + strlen($needle));
        $end2 = strpos($content, '\"', $startPos + strlen($needle));
        return substr($content, $startPos + strlen($needle), min($end1, $end2) - $startPos - strlen($needle));
    }

    private function cutContent($content) {
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

    private function printPage($title, $content) {
        return '<div id="content" class="mw-body zeromargin" role="main">' .
         '<h1 id="firstHeading" class="firstHeading" lang="ru">' . $title . '</h1>' .
         '<div id="bodyContent" class="mw-body-content">' .
         '<div id="siteSub">Материал из Википедии — свободной энциклопедии</div>' .
         '<div id="mw-content-text" lang="ru" dir="ltr" class="mw-content-ltr">' .
         $this->cutContent($content) .
         "</div></div>";
    }
}