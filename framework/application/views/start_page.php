
<?php $loggedIn = isset($_SESSION['user_connected']) && $_SESSION['user_connected'] === true; ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- made by www.metatags.org -->
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <meta name="keywords" content="википедия, вики, игра, интерактив, развлечение, образование, ссылка, переход, клик"/>
    <meta name="author" content="Sergey Shilin & Dmitriy Verbitskiy">
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
    <!-- wikipedia, game, walk -->

    <link rel="icon" href="../../favicon.ico">
    <!-- Bootstrap core CSS -->
    <script src="application/js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="application/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="application/css/index.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .jumbotron{
            background-color: rgba(0, 0, 0, 0);
            width: 60%;
            margin:0 auto;

        }
    </style>
</head>

<body>
<script>
    $('.carousel').carousel({
        interval: 300
    });
    window.fbAsyncInit = function () {
        FB.init({
            appId: '828289110577673',
            xfbml: true,
            version: 'v2.3'
        });
    };
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<div class="wrapper">
    <?php
        include_once('application/views/topbar_frame.php');
    ?>

    <div class="container">
        <div class="row">
            <div class="jumbotron greating greating"> <h1 class="cover-heading">Пройди свой путь</h1>
            <p class="lead">Пройди путь от одной страницы Википедии до другой за минимальноe количество шагов.
                Думаешь, это просто? <br>Попробуй сыграть прямо сейчас!</p>
            <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#cats"
            onclick="yaCounter28976460.reachGoal('playgame')">Одиночная игра</button>
            <button type="button" class="btn btn-lg btn-default btn-white" data-toggle="modal" data-target="#multi"
            onclick="yaCounter28976460.reachGoal('playmulti')" disabled>Мультиплеер</button>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>Содержимое взято с сайта
                <a target="_blank" href="http://wikipedia.org/wiki/Main_Page">Wikipedia.org</a><br>
                Поддержи проект! Вступай в группу
                <a class='vklink' target="_blank" href="http://vk.com/wikiwalker">Вконтакте</a>
            </p>
        </div>
    </div>
</div>


<!-- Modal Categories-->
<div class="modal fade" id="cats" tabindex="-1" role="dialog" aria-labelledby="categories" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="categories">Категория</h4>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <a href="/wiki/Main_Page" class="list-group-item active" onclick="yaCounter28976460.reachGoal('cat0'); return true;">
                        <h4 class="list-group-item-heading">Классический</h4>

                        <p class="list-group-item-text">Стандартный режим игры. Без ограничений по времени</p>
                    </a>
                    <a class="list-group-item" onclick="yaCounter28976460.reachGoal('cat0'); return true;" disabled>
                        <h4 class="list-group-item-heading">На время</h4>

                        <p class="list-group-item-text">Стандартный режим игры. За одну минуту</p>
                    </a>
                    <a class="list-group-item" onclick="yaCounter28976460.reachGoal('cat0'); return true;" disabled>
                        <h4 class="list-group-item-heading">Гитлер</h4>

                        <p class="list-group-item-text">Просто доберитесь до Адольфа</p>
                    </a>
                    <a class="list-group-item" onclick="yaCounter28976460.reachGoal('cat0'); return true;" disabled>
                        <h4 class="list-group-item-heading">Свой маршрут</h4>

                        <p class="list-group-item-text"></p>
                    </a>
                    <a class="list-group-item" onclick="yaCounter28976460.reachGoal('cat0'); return true;" disabled>
                        <h4 class="list-group-item-heading">Дуэль</h4>

                        <p class="list-group-item-text">Player vs Player</p>
                    </a>
                    <a class="list-group-item" onclick="yaCounter28976460.reachGoal('cat0'); return true;" disabled>
                        <h4 class="list-group-item-heading">Турнир</h4>

                        <p class="list-group-item-text"></p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="application/js/jquery.min.js"></script>
<script src="application/js/bootstrap.min.js"></script>
<script src="application/js/ie10-viewport-bug-workaround.js"></script>
