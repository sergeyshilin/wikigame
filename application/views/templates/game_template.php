<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <meta name="keywords" content="википедия, вики, игра, интерактив, развлечение, образование, ссылка, переход, клик"/>
    <meta name="robots" content="index, nofollow">
    <meta name="revisit-after" content="3 days">

    <meta property="og:title" content="WikiWalker - Пройди свой путь"/>
    <meta property="og:description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <meta property="og:url" content="http://<?= $_SERVER['SERVER_NAME']?>"/>
    <meta property="og:image" content="http://<?= $_SERVER['SERVER_NAME']?>/application/images/forsocials.jpg"/>

    <meta name="title" content="WikiWalker - Пройди свой путь"/>
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <link rel="image_src" href="http://<?= $_SERVER['SERVER_NAME']?>/application/images/forsocials.jpg"/>
    <title>WikiWalker - Пройди свой путь</title>

    <link rel="icon" href="/application/images/favicon.png">
    <link rel="apple-touch-icon" href="/application/images/apple-touch-favicon.png"/>

    <link rel="stylesheet" type="text/css" href="/application/css/bootstrap-scope.min.css">
    <link rel="stylesheet" type="text/css" href="/application/css/wiki-site.min.css">
    <link rel="stylesheet" type="text/css" href="/application/css/wiki-modules.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/application/css/timeTo.css">
    <link rel="stylesheet" type="text/css" href="/application/css/game.css">

    <script src="/application/js/jquery.min.js"></script>
    <script src="/application/js/jquery.time-to.min.js"></script>

    <style>
        ul[style]{
            line-height: 30.24px!important;
        }
        #countdown{
            margin-top: 10px;
            margin-left: 10px;
            font-weight: normal;
        }
        #backarrow:hover{
            cursor: hand;
        }
    </style>
</head>
<body>
<?php include 'application/views/' . $content_view; ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter28976460 = new Ya.Metrika({
                    id: 28976460,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    trackHash: true
                });
            } catch (e) {
            }
        });
        var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () {
            n.parentNode.insertBefore(s, n);
        };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");</script>
<noscript>
    <div><img src="//mc.yandex.ru/watch/28976460" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>

