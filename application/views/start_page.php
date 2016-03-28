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
            <?php if (!$loggedIn) { ?>
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
            <?php } else { ?>
                <a href="/account" class="btn btn-default btn-info"><span class="glyphicon glyphicon-user"></span>&nbspМой аккаунт</a>
                <a href="/login/exit" class="btn btn-default btn-white">Выйти</a>
            <?php } ?>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9">
            <div class="greating">
                <h1>Пройди свой путь</h1>
                <p class="lead">Пройди путь от одной страницы Википедии до другой за минимальноe количество шагов.<br>
                    Думаешь, это просто? Попробуй сыграть прямо сейчас!</p>
            </div>
            <div id="game-type-grid">
                <div class="row row-eq-height">
                    <div class="game-type col-sm-4">
                        <img src="application/images/game_types/wki_icon-02.png" onclick="goto('wiki/Main_Page', false)">
                        <div class="game-type-text" onclick="goto('wiki/Main_Page', false)">
                            <h3>Классический</h3>
                            <p>Стандартная игра без ограничений</p>
                        </div>
                    </div>
                    <div class="game-type col-sm-4">
                        <img src="application/images/game_types/wki_icon-01.png" onclick="goto('one_minute', false)">
                        <div class="game-type-text" onclick="goto('one_minute', false)">
                            <h3>На время</h3>
                            <p>Пройдите маршрут за 1 минуту. Слабо?</p>
                        </div>
                    </div>
                    <div class="game-type col-sm-4">
                        <img src="application/images/game_types/wki_icon-05.png" onclick="goto('hitler', false)">
                        <div class="game-type-text" onclick="goto('hitler', false)">
                            <h3>Гитлер</h3>
                            <p>Доберитесь до Гитлера любой ценой!</p>
                        </div>
                    </div>
                </div>
                <div class="row row-eq-height">
                    <div class="game-type col-sm-4">
                        <img src="application/images/game_types/wki_icon-03.png" onclick="goto('custom_ways', true)">
                        <div class="game-type-text" onclick="goto('custom_ways', true)">
                            <h3>Свой маршрут</h3>
                            <p>Проложите свой маршут, соревнуйтесь со своими друзьями</p>
                        </div>
                    </div>
                    <div class="game-type col-sm-4">
                        <img src="application/images/game_types/wki_icon-04.png" onclick="goto('challenge', true)">
                        <div class="game-type-text" onclick="goto('challenge', true)">
                            <h3>Дуэль</h3>
                            <p>Найдите себе соперника и пройдите маршрут первым!</p>
                        </div>
                    </div>
                    <div class="game-type col-sm-4">
                        <img src="application/images/game_types/wki_icon-06.png" onclick="goto('compete', true)">
                        <div class="game-type-text" onclick="goto('compete', true)">
                            <h3>Турнир</h3>
                            <p>Пройдите 5 маршрутов подряд за 10 минут и получите 1500 очков!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div id="stats" class="carousel slide">
                <div class="carousel-inner">
                    <div class="active item">
                        <div class="list-group" id="top-users">
                            <a class="list-group-item active">
                                <span class="upd-stats badge">Обновить</span>
                                <h4 class="list-group-item-heading">Лучшие игроки</h4>
                            </a>
                            <?php $i = 0; foreach ($info as $key => $value) : ?>
                            <a class="list-group-item">
                                <span class="badge"> <?= $value["value"] ?></span>
                                <h4 class="list-group-item-heading"><i class="fa fa-user"></i><?= $value["nick"] ?></h4>
                                <p class="list-group-item-text">Сыграно игр: <?= $value["count"] ?></p>
                            </a>
                            <?php $i++; endforeach; ?>
                            <?php while ($i < 7) : ?>
                                <a class="list-group-item">
                                    <h4 class="list-group-item-heading">&nbsp</h4>
                                    <p class="list-group-item-text">&nbsp</p>
                                </a>
                            <?php $i++; endwhile; ?>

                            <a class="list-group-item">
                                <div class="carousel-control left" href="#stats" data-slide="prev">‹</div>
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
                            <?php $i = 0; foreach ($data2 as $key => $value): ?>
                            <a class="list-group-item" href="<?= $value['way_link'] ?>">
                                <span class="badge"> <?= $value["rating"] ?></span>
                                <h4 class="list-group-item-heading"><?= $value["start"] ?> <i class="fa fa-arrow-right"></i> </h4>
                                <p class="list-group-item-text"><i class="fa fa-arrow-right"></i> <?= $value["end"] ?></p>
                            </a>
                            <?php $i++; endforeach; ?>
                            <?php while ($i < 7) : ?>
                                <a class="list-group-item">
                                    <h4 class="list-group-item-heading">&nbsp</h4>
                                    <p class="list-group-item-text">&nbsp</p>
                                </a>
                            <?php $i++; endwhile; ?>

                            <a class="list-group-item">
                                <div class="carousel-control left" href="#stats" data-slide="prev">‹</div>
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
                            <?php $i = 0; foreach ($data3 as $key => $value) : ?>
                            <a class="list-group-item" href="<?= $value['way_link'] ?>">
                                <span class="badge"> <?= $value["rating"] ?></span>
                                <h4 class="list-group-item-heading"><?= $value["start"] ?> <i class="fa fa-arrow-right"></i></h4>
                                <p class="list-group-item-text"><i class="fa fa-arrow-right"></i> <?= $value["end"] ?></p>
                            </a>
                            <?php $i++; endforeach; ?>
                            <?php while ($i < 7) : ?>
                            <a class="list-group-item">
                                <h4 class="list-group-item-heading">&nbsp</h4>
                                <p class="list-group-item-text">&nbsp</p>
                            </a>
                            <?php $i++; endwhile; ?>

                            <a class="list-group-item">
                                <div class="carousel-control left" href="#stats" data-slide="prev">‹</div>
                                <div class="carousel-control right" href="#stats" data-slide="next">›</div>
                                <p></p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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

<script>
    function goto(url, need_be_logged_in) {
        if (need_be_logged_in && <?= ($loggedIn) ? 'true' : 'false' ?> == false) {
            $('.bs-example-modal-sm').modal("show");
        } else {
            window.location.href = url;
        }
    }
</script>

<!--    MODALS ----------------------------------------------------------------------------------------------------------->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Вход в систему</h4>
            </div>
            <div class="modal-body">
                <p>Чтобы играть в этом режиме, вам необходимо залогиниться.</p>
                <p>Вы можете войти через:</p>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>