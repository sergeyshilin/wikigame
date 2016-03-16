<?php
$cat = $_SESSION["cat"] ? "?cat=" . $_SESSION["cat"] : "";
$start_page = $_SESSION["start"];
$end_page = str_replace("_", " ", $_SESSION["end"]);
$end_page_link = $_SESSION["endlink"];
$count = $_SESSION['counter'];
$loggedIn = isset($_SESSION['user_connected']) && $_SESSION['user_connected'] === true;
?>
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
    <link rel="stylesheet" type="text/css" href="/application/css/main.css">
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
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/application/css/bootstrap-scope.min.css">
    <link rel="stylesheet" type="text/css" href="/application/css/wiki-site.min.css">
    <link rel="stylesheet" type="text/css" href="/application/css/wiki-modules.min.css">
</head>

<div class="bootstrap-scope">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img class="header_logo" src="/application/images/logo/logo.svg" title="WikiWalker - найди свой путь">
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a target="_blank" href="<?= $end_page_link ?>">Ваша цель: <span class="jslink"><?= $end_page ?></span></a></li>
                    <li><a>Количество шагов: <?= $count ?></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="hovered"><a href="/wiki/<?= $start_page ?>"
                        onclick="yaCounter28976460.reachGoal('header_playagain'); return true;">Начать заново</a></li>
                    <li class="hovered"><a href="/wiki/Main_Page<?= $cat ?>"
                        onclick="yaCounter28976460.reachGoal('header_newgame'); return true;">Новая игра</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<?php echo $data; ?>