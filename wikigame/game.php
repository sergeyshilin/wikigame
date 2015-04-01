<?php
session_start();

if (isset($_GET['page']) && !empty($_GET['page'])) {
    require_once('DBHelper.php');
    require_once('WayParser.php');

    $cat = 0;

    $page = $_GET['page'];
    $page = htmlspecialchars($page); // Escape HTML.
    $page = DBHelper::escape($page); // Escape SQL.

    if (isset($_GET["cat"]) && !empty($_GET["cat"])) {
        $cat = $_GET["cat"];
        $cat = htmlspecialchars($cat); // Escape HTML.
        $cat = DBHelper::escape($cat); // Escape SQL.
    }

    if (WayParser::isMD5Hash($page)) {
        $way = WayParser::getWayByHash($page);
        if (!empty($way)) {
            $_SESSION['end'] = Way::getName($way->getEndPoint());
            $_SESSION['start'] = Way::getName($way->getStartPoint());
            $_SESSION['startlink'] = $way->getStartPoint();
            $_SESSION['endlink'] = $way->getEndPoint();
            $_SESSION['win'] = false;
            $_SESSION['lang'] = $way->getLang();
            $_SESSION['hash'] = $way->getHash();
            header('Location: ' . $_SESSION["start"]);
        } else {
            header('Location: /');
        }
    }

    if (empty($_SESSION['start']) || empty($_SESSION['end']) || $page == "Main_Page") {
        $way = WayParser::getRandomWay($cat);
        $_SESSION['cat'] = $cat;
        $_SESSION['end'] = Way::getName($way->getEndPoint());
        $_SESSION['start'] = Way::getName($way->getStartPoint());
        $_SESSION['startlink'] = $way->getStartPoint();
        $_SESSION['endlink'] = $way->getEndPoint();
        $_SESSION['win'] = false;
        $_SESSION['lang'] = $way->getLang();
        $_SESSION['hash'] = $way->getHash();
        header('Location: ' . $_SESSION["start"]);
    }

    $_SESSION['previous'] = $_SESSION['current'];
    $_SESSION['current'] = $page;
    if ($_SESSION['current'] != $_SESSION['previous'] && !$_SESSION['win'])
        $_SESSION['counter'] += 1;
    if ($_SESSION['current'] == $_SESSION['start'] && !$_SESSION['win']) {
        $_SESSION['counter'] = 0;
        $_SESSION['previous'] = "";
        $_SESSION['current'] = $page;
    }
    if ($_SESSION['current'] == $_SESSION['end'] && !empty($_SERVER['HTTP_REFERER'])) {
        $_SESSION['win'] = true;
    } else if ((empty($_SERVER['HTTP_REFERER'])) &&
        (($_SESSION['current'] == $_SESSION['end']) || ($_SESSION['current'] != $_SESSION['start']))
        && !$_SESSION['win']
    ) {
        $_SESSION['counter'] = 0;
        header('Location: ' . $_SESSION["start"]);
    }

} else {
    session_unset();
    session_destroy();
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- made by www.metatags.org -->
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <meta name="keywords" content="википедия, вики, игра, интерактив, развлечение, образование, ссылка, переход, клик"/>
    <meta name="author" content="Sergey Shilin & Dmitriy Verbitskiy">
    <meta name="robots" content="index, nofollow">
    <meta name="revisit-after" content="3 days">

    <meta property="og:title" content="WikiWalker - Пройди свой путь"/>
    <meta property="og:description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <meta property="og:url" content="http://wikiwalker.ru/"/>
    <meta property="og:image" content="http://wikiwalker.ru/wiki/img/forsocials.png"/>
    <meta property="og:image:url" content="http://wikiwalker.ru/wiki/img/forsocials.png"/>

    <meta name="title" content="WikiWalker - Пройди свой путь"/>
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <link rel="image_src" href="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>

    <title>WikiWalker - Пройди свой путь</title>

    <link rel="stylesheet" type="text/css" href="/wiki/css/main.css">

	<script type="text/javascript" language="JavaScript" src="/wiki/js/jquery.min.js"></script>
	<script type="text/javascript" language="JavaScript" src="/wiki/js/bootstrap.min.js"></script>
    <script type="text/javascript" language="JavaScript" src="/wiki/js/ie10-viewport-bug-workaround.js"></script>
    <script type="text/javascript" language="JavaScript" src="/wiki/js/main.js"></script>
</head>
<body>

<?php

if (!$_SESSION['win']) {
    include_once("frame/header.php");

    echo '<div id="content" class="mw-body zeromargin" role="main">';

    $url = "https://" . $_SESSION['lang'] . ".wikipedia.org/w/api.php?action=parse&page=" . $page . "&format=json";
    $json = file_get_contents($url);
    $obj = json_decode($json, true);

    $title = $obj['parse']['title'];
    $content = $obj['parse']['text']['*'];

    echo '<h1 id="firstHeading" class="firstHeading" lang="ru">' . $title . '</h1>';
    echo '<div id="bodyContent" class="mw-body-content">';
    echo '<div id="siteSub">Материал из Википедии — свободной энциклопедии</div>';
    echo '<div id="mw-content-text" lang="ru" dir="ltr" class="mw-content-ltr">';

    $positions = array();
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
        echo substr($content, 0, $cut_pos);
    } else {
        echo $content;
    }
    echo "</div></div>";

} else {
    include_once('frame/win.php');
}
?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter28976460 = new Ya.Metrika({id:28976460, trackLinks:true, accurateTrackBounce:true, trackHash:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/28976460" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
