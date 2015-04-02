<?php
    $cat = $_SESSION["cat"] ? "?cat=" . $_SESSION["cat"] : "";
    $count = $_SESSION['counter'];
    $start_page =$_SESSION["start"];
    $start_page_link = $_SESSION["startlink"];
    $end_page = str_replace("_", " ", $_SESSION["end"]);
    $end_page_link = $_SESSION["endlink"];
    $referer = $_SERVER['HTTP_REFERER'];
?>

<link rel="stylesheet" type="text/css" href="/w/css/bootstrap-scope.min.css">
<link rel="stylesheet" type="text/css" href="/w/css/wiki2.css">
<link rel="stylesheet" type="text/css" href="/w/css/wiki1.css">

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
                <a class="navbar-brand" href="/">WikiWalker</a>
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
                    <li class="dropdown hovered">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Сменить категорию <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/wiki/Main_Page">Случайный маршрут</a></li>
                            <li class="divider"></li>
                            <?php
                            require_once('WayUtils.php');
                            $utils = new WayUtils();
                            $cats = $utils->getCategories();

                            foreach ($cats as $cat) {
                                echo "<li><a href='/wiki/Main_Page?cat=" . $cat["id"] . "'>" . $cat["name"] . "</a></li>";
                            }
                            ?>
                        </ul>
                    </li
                </ul>
            </div>
        </div>
    </nav>
</div>