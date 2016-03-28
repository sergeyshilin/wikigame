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

    <link rel="icon" href="/application/images/logo/favicon.ico">

    <link rel="stylesheet" type="text/css" href="/application/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/application/css/start-page.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>

<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <a href="/">
            <img class="header_logo" src="/application/images/logo/logo_white.svg" title="WikiWalker - найди свой путь">
        </a>
        <div class="pull-right">
            <?php if (!$loggedIn) {?>
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
            <?php } else {?>
                <a href="/account" class="btn btn-default btn-info"><span class="glyphicon glyphicon-user"></span>&nbspМой аккаунт</a>
                <a href="/login/exit" class="btn btn-default btn-white">Выйти</a>
            <?php } ?>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row row-eq-height">
        <div class="col-lg-8">
            <div class="greating">
                <h1>Пройди свой путь</h1>
                <p class="lead">Пройди путь от одной страницы Википедии до другой за минимальноe количество шагов.
                    Думаешь, это просто? Попробуй сыграть прямо сейчас!</p>
            </div>
            <div id="game-type-grid">
                <div class="row row-eq-height">
                    <div id="type-classical" class="game-type col-xs-4">
                        <img src="application/images/game_types/wki_icon-02.png">
                        <div class="game-type-text">
                            <h3>Классический</h3>
                            <p>Стандартная игра без ограничений</p>
                        </div>
                    </div>
                    <div class="game-type col-xs-4">
                        <img src="application/images/game_types/wki_icon-01.png">
                        <div class="game-type-text">
                            <h3>На время</h3>
                            <p>Пройдите маршрут за 1 минуту. Слабо?</p>
                        </div>
                    </div>
                    <div class="game-type col-xs-4">
                        <img src="application/images/game_types/wki_icon-05.png">
                        <div class="game-type-text">
                            <h3>Гитлер</h3>
                            <p>Доберитесь до Гитлера любой ценой!</p>
                        </div>
                    </div>
                </div>
                <div class="row row-eq-height">
                    <div class="game-type col-xs-4">
                        <img src="application/images/game_types/wki_icon-03.png">
                        <div class="game-type-text">
                            <h3>Свой маршрут</h3>
                            <p>Проложите свой маршут, соревнуйтесь со своими друзьями</p>
                        </div>
                    </div>
                    <div class="game-type col-xs-4">
                        <img src="application/images/game_types/wki_icon-04.png">
                        <div class="game-type-text">
                            <h3>Дуэль</h3>
                            <p>Найдите себе соперника и пройдите маршрут первым!</p>
                        </div>
                    </div>
                    <div class="game-type col-xs-4">
                        <img src="application/images/game_types/wki_icon-06.png">
                        <div class="game-type-text">
                            <h3>Турнир</h3>
                            <p>Пройдите 5 маршрутов подряд за 10 минут и получите 1500 очков!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            
        </div>
    </div>
</div>

<div class="footer">
    <div class="container-fluid">
        <p>
            Игра основана на контенте сайта
            <a target="_blank" href="http://wikipedia.org/wiki/Main_Page">Wikipedia.org</a><br>
            Поддержи проект! Вступай в группу
            <a class='vklink' target="_blank" href="http://vk.com/wikiwalker">Вконтакте</a>
        </p>
    </div>
</div>

<script src="application/js/jquery.min.js"></script>
<script src="application/js/bootstrap.min.js"></script>

</body>
</html>