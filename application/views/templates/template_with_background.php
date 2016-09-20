<?php $loggedIn = isset($_SESSION['user_connected']) && $_SESSION['user_connected'] === true; ?>

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
    <link rel="image_src" href="/application/images/forsocials.jpg"/>
    <title>WikiWalker - Пройди свой путь</title>

    <link rel="icon" href="/application/images/favicon.png">
    <link rel="apple-touch-icon" href="/application/images/apple-touch-favicon.png"/>

    <link rel="stylesheet" type="text/css" href="/application/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/application/css/template_with_background.css">
    <link rel="stylesheet" type="text/css" href="/application/css/start-page.css">
    <!-- Social Share Kit CSS -->
    <link rel="stylesheet" href="/application/css/social-share-kit.css" type="text/css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <script src="/application/js/jquery.min.js"></script>
    <script src="/application/js/parse-1.4.0.min.js"></script>
    <script type="text/javascript" src="/application/js/social-share-kit.min.js"></script>
</head>

<body>
<div class="wrapper">
    <nav class="header navbar navbar-default">
        <div class="container">
            <a href="/">
                <img class="header_logo" src="/application/images/logo_white.svg" title="WikiWalker - найди свой путь">
            </a>
            <?php if (!$loggedIn) { ?>
                <div class="pull-right">
                    <div id="social-login">
                        <div class="socials row">
                            <div class="soclogin col-xs-4">
                                <a class="btn btn-primary btn-block" href="/login/provider/Vkontakte">
                                    <i class="fa fa-vk"></i></a>
                            </div>
                            <div class="soclogin col-xs-4">
                                <a class="btn btn-primary btn-block" href="#" disabled>
                                    <i class="fa fa-facebook"></i></a>
                            </div>
                            <div class="soclogin col-xs-4">
                                <a class="btn btn-danger btn-block" href="#" disabled>
                                    <i class="fa fa-google-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="socials pull-right">
                    <div class="soclogin" style="display: inline-block; font-size: 16px">
                        <a class="btn btn-primary btn-block user-progress" href="/account">
                            <div class="progress">
                                <?php
                                    $nextLevelScore = (floatval($data["rank"]) + 1)*(floatval($data["rank"]) + 1);
                                    $progress = floatval($data["rating"])/$nextLevelScore
                                ?>
                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?=$data["progress"]?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $data["progress"] ?>%">
                                    <span class="sr-only"><?= $progress ?>%</span>
                                </div>
                            </div>
                            <p><?= $data["rank"] ?></p>
                            <i class="fa fa-user"></i>
                        </a>
                    </div>
                    <div class="soclogin" style="display: inline-block">
                        <a class="btn btn-danger btn-block" href="/login/exit">
                            <i class="fa fa-sign-out"></i></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </nav>

<div class="content container">
    <?php include 'application/views/' . $content_view; ?>
</div>

<div class="footer container">
    <p>
        Игра основана на контенте сайта
        <a target="_blank" href="http://wikipedia.org/wiki/Main_Page">Wikipedia.org</a><br>
        Поддержи проект! Вступай в группу
        <a class='vklink' target="_blank" href="http://vk.com/wikiwalker">Вконтакте</a>
    </p>
</div>
</div>
<script src="/application/js/bootstrap.min.js"></script>
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
