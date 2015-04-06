<?php
session_start();

try {
    require_once('classes/DBHelper.php');
    require_once('classes/WayParser.php');

    if (!isset($_GET['title']) || empty($_GET['title'])) {
        throw new Exception();
    }

    $title = escape($_GET['title']);
    $cat = isset($_GET["cat"]) && !empty($_GET["cat"]) ? escape($_GET["cat"]) : 0;

    if (WayParser::isMD5Hash($title)) {
        $way = WayParser::getWayByHash($title);
        if (!empty($way)) {
            wayToSession($way);
            header('Location: /wiki/' . $_SESSION["start"]);
        } else {
            throw new Exception();
        }
    } else if (empty($_SESSION['start']) || empty($_SESSION['end']) || $title == "Main_Page") {
        $way = WayParser::getRandomWay($cat);
        wayToSession($way, $cat);
        header('Location: /wiki/' . $_SESSION["start"]);
    } else if (!$_SESSION['win']) {
        if (empty($_SERVER['HTTP_REFERER']) && $title != $_SESSION["current"]) {
            header('Location: /wiki/' . $_SESSION["current"]);
        } else if ($title == $_SESSION['end']) {
            $_SESSION['win'] = true;
        } else {
            include_once("classes/PageResolver.php");
            $resolver = new PageResolver();
            $obj = $resolver->isGenerated($title) ? $resolver->getContentFromHtml($title) : $resolver->getContentFromApi($title);
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
} catch (Exception $e) {
    session_unset();
    session_destroy();
    header('Location: /');
}

function escape($str) {
    $str = htmlspecialchars($str); // Escape HTML.
    $str = DBHelper::escape($str); // Escape SQL.
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

    <link rel="stylesheet" type="text/css" href="/w/css/main.css">

	<script type="text/javascript" language="JavaScript" src="/w/js/jquery.min.js"></script>
	<script type="text/javascript" language="JavaScript" src="/w/js/bootstrap.min.js"></script>
    <script type="text/javascript" language="JavaScript" src="/w/js/ie10-viewport-bug-workaround.js"></script>
    <script type="text/javascript" language="JavaScript" src="/w/js/main.js"></script>
</head>
<body>

<?php

if (!$_SESSION['win']) {
    include_once("frame/header.php");
    echo $resolver->printPage($obj["title"], $obj["content"]);
} else {
    include_once('frame/win.php');
}
?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter28976460 = new Ya.Metrika({id:28976460, trackLinks:true, accurateTrackBounce:true, trackHash:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/28976460" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
