
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
    <script src="/application/js/bootstrap.min.js"></script>
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
            float:left;
            margin-top:-70px;
        }
        #stats{
            margin-top:34px;
        }
        .for-thumbs {
            width: 760px !important;
            text-shadow: none;
            float:left;
            margin-top: -40px;
        }
        .thumbnail{
            float:left;
            margin: 5px;
            width:200px;
        }
        .small-notif{
            padding-left:5px;
            font-size:0.8em;
        }
        .for-thumbs a:hover {
            text-decoration: none;
        }
        .upd-stats:hover{
            cursor:pointer;
        }
        .striped-div{
            background:
                repeating-linear-gradient(
                    45deg,
                    transparent,
                    transparent 10px,
                    #ccc 10px,
                    #ccc 20px
                ),
                    /* on "bottom" */
                linear-gradient(
                    to bottom,
                    #eee,
                    #999
                );
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
            </div>

        </div>
        <div class="row">
            <div class="container for-thumbs">
                <?php foreach($data as $key=>$value):?>
                    <div class="thumbnail <?php if((!$loggedIn)&&($value['opened'] == 0)):?> striped-div<?php endif;?> ">
                        <?php if(((int)$loggedIn != $value['opened']) || ($value['opened']) == 1):?><a href="<?=$value['link']?>"><?php endif; ?>
                        <div class="caption">
                            <?php if((!$loggedIn)&&($value['opened'] == 0)):?>
                                <span class="glyphicon glyphicon-ban-circle closed-mode"></span><span class="small-notif">авторизуйтесь</span>
                            <?php endif; ?>
                            <h3><?=$value["name"]?></h3>
                            <p><?=$value["desc"]?></p>
                        </div>
                        <?php if(((int)$loggedIn != $value['opened']) || ($value['opened']) == 1):?></a><?php endif; ?>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4" style="float:right; margin-top: -450px;"><div id="stats" class="carousel slide">
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        <div class="active item">
                            <div class="list-group" id="top-users">
                                <a class="list-group-item active">
                                    <span class="upd-stats badge">Обновить</span>
                                    <h4 class="list-group-item-heading">Лучшие игроки</h4>
                                </a>
                                <?php $i=0; foreach($info as $key=>$value) : ?>
                                    <a class="list-group-item">
                                        <span class="badge"> <?=$value["value"]?></span>
                                        <h4 class="list-group-item-heading"><i class="fa fa-user"></i><?=$value["nick"]?></h4>
                                        <p class="list-group-item-text">Сыграно игр: <?=$value["count"]?></p>
                                    </a>
                                    <?php $i++; endforeach; ?>


                                <a class="list-group-item">
                                    <h4 class="list-group-item-heading"></h4>
                                    <p class="list-group-item-text">
                                    </p><div class="carousel-control left" href="#stats" data-slide="prev">‹</div>
                                    <div class="carousel-control right" href="#stats" data-slide="next">›</div>
                                    <p></p>
                                </a>
                            </div>

                        </div>
                        <div class="item">
                            <div class="list-group" id="top-users">
                                <a class="list-group-item active">
                                    <span class="upd-stats badge">Обновить</span>
                                    <h4 class="list-group-item-heading">Популярное сегодня</h4>
                                </a>
                                <?php $i=0; foreach($data2 as $key=>$value) : ?>
                                    <a class="list-group-item" href="<?=$value['way_link']?>">
                                        <span class="badge"> <?=$value["rating"]?></span>
                                        <h4 class="list-group-item-heading"><?=$value["start"]?></h4>
                                        <p class="list-group-item-text"><i class="fa fa-angle-right"></i>
                                            <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> <?=$value["end"]?></p>
                                    </a>
                                    <?php $i++; endforeach; ?>


                                <a class="list-group-item">
                                    <h4 class="list-group-item-heading"></h4>
                                    <p class="list-group-item-text">
                                    </p><div class="carousel-control left" href="#stats" data-slide="prev">‹</div>
                                    <div class="carousel-control right" href="#stats" data-slide="next">›</div>
                                    <p></p>
                                </a>
                            </div>

                        </div>
                        <div class="item">
                            <div class="list-group" id="top-users">
                                <a class="list-group-item active">
                                    <span class="upd-stats badge">Обновить</span>
                                    <h4 class="list-group-item-heading">Самое популярное</h4>
                                </a>
                                <?php $i=0; foreach($data3 as $key=>$value) : ?>
                                    <a class="list-group-item" href="<?=$value['way_link']?>">
                                        <span class="badge"> <?=$value["rating"]?></span>
                                        <h4 class="list-group-item-heading"><?=$value["start"]?></h4>
                                        <p class="list-group-item-text"><i class="fa fa-angle-right"></i>
                                            <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> <?=$value["end"]?></p>
                                    </a>
                                    <?php $i++; endforeach; ?>


                                <a class="list-group-item">
                                    <h4 class="list-group-item-heading"></h4>
                                    <p class="list-group-item-text">
                                    </p><div class="carousel-control left" href="#stats" data-slide="prev">‹</div>
                                    <div class="carousel-control right" href="#stats" data-slide="next">›</div>
                                    <p></p>
                                </a>
                            </div>

                        </div>
                    </div>

                </div></div>
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
                    <a href="/wiki/Main_Page" class="list-group-item active" onclick="yaCounter28976460.reachGoal('classic'); return true;">
                        <h4 class="list-group-item-heading">Классический</h4>

                        <p class="list-group-item-text">Стандартный режим игры. Без ограничений по времени</p>
                    </a>
                    <a class="list-group-item" onclick="yaCounter28976460.reachGoal('One_minute'); return true;" disabled>
                        <h4 class="list-group-item-heading">На время</h4>

                        <p class="list-group-item-text">Стандартный режим игры. За одну минуту</p>
                    </a>
                    <a class="list-group-item" onclick="yaCounter28976460.reachGoal('Htiler'); return true;" disabled>
                        <h4 class="list-group-item-heading">Гитлер</h4>

                        <p class="list-group-item-text">Просто доберитесь до Адольфа</p>
                    </a>
                    <a class="list-group-item" onclick="yaCounter28976460.reachGoal('custom_way'); return true;" disabled>
                        <h4 class="list-group-item-heading">Свой маршрут</h4>

                        <p class="list-group-item-text"></p>
                    </a>
                    <a class="list-group-item" onclick="yaCounter28976460.reachGoal('challenge'); return true;" disabled>
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
<script>
    $(".upd-stats").click(function(){
        $.ajax({
            url: "/main/upd-stats"
        }).done(function(){
            location.href = "/";
        });
    })
</script>