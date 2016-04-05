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
    <meta property="og:url" content="http://wikiwalker.ru/"/>
    <meta property="og:image" content="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>
    <meta property="og:image:url" content="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>

    <meta name="title" content="WikiWalker - Пройди свой путь"/>
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <link rel="image_src" href="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>
    <title>WikiWalker - Пройди свой путь</title>

    <link rel="icon" href="/application/images/favicon.png">
    <link rel="apple-touch-icon" href="/application/images/apple-touch-favicon.png"/>

    <link rel="stylesheet" type="text/css" href="/application/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/application/css/template_with_background.css">
    <link rel="stylesheet" type="text/css" href="/application/css/start-page.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <script src="/application/js/jquery.min.js"></script>
    <script src="/application/js/parse-1.4.0.min.js"></script>
    <script src="/application/js/Share.js"></script>
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
                                <a class="btn btn-primary btn-block" href="/login/provider/Facebook" disabled>
                                    <i class="fa fa-facebook"></i></a>
                            </div>
                            <div class="soclogin col-xs-4">
                                <a class="btn btn-danger btn-block" href="/login/provider/Google" disabled>
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
                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progress ?>%">
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


</body>
</html>
