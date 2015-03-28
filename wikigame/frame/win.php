<?php
$cat = $_SESSION["cat"] ? "?cat=" . $_SESSION["cat"] : "";
$count = $_SESSION['counter'];
$hash = $_SESSION['hash'];
$url = "http://wikiwalker.ru/" . $hash;
$title = "WikiWalker - Пройди свой путь!";
$desc = "Поздравляем! Вы прошли от страницы " . str_replace("_", " ", $_SESSION["start"]) . "
до страницы " . str_replace("_", " ", $_SESSION["end"]) . ". Количество шагов: " . $_SESSION["counter"] . ". ";
$img = "http://wikiwalker.ru/assets/img/forsocials.jpg";
$start_page = str_replace("_", " ", $_SESSION["start"]);
$start_page_link = $_SESSION["startlink"];
$end_page = str_replace("_", " ", $_SESSION["end"]);
$end_page_link = $_SESSION["endlink"];
?>

<link rel="stylesheet" type="text/css" href="/wiki/css/bootstrap.min.css">
<!-- Custom styles for this template -->
<link href="/wiki/css/cover.css" rel="stylesheet">
<script src="assets/js/ie-emulation-modes-warning.js"></script>
<script type="text/javascript" src="assets/share42/share42.js"></script>
<script type="text/javascript">
    window.history.pushState("", "Title", "/?game=<?=$hash?>");
</script>

<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">
            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand">WikiWalker</h3>
                    <!-- <nav>
                      <ul class="nav masthead-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">Features</a></li>
                        <li><a href="#">Contact</a></li>
                      </ul>
                    </nav> -->
                </div>
            </div>

            <div class="inner cover">
                <h1 class="cover-heading">Поздравляем!</h1>

                <p class="lead">
                    Вы завершили свой маршрут! Количество переходов: <span
                        class="label label-danger"><?= $count ?></span>
                    Начальная страница: <span class="label label-warning"><?= $start_page ?></span><br>
                    Конечная страница: <span class="label label-warning"><?= $end_page ?></span><br>
                    Понравилось? Поделись результатом с друзьями!

                <div class="share42init" data-description="<?= $desc ?>" data-image="<?= $img ?>" data-url="<?= $url ?>"
                     data-title="<?= $title ?>"></div>
                <p class="lead">
                    <a href="/<?= $hash ?>" class="btn btn-lg btn-success congrats_playagain">Повторить</a>
                    <a href="/wiki/Main_Page<?= $cat ?>" class="btn btn-lg btn-success congrats_playagain">Новая
                        игра</a>
                </p>
            </div>

            <div class="mastfoot">
                <div class="inner">
                    <p>Содержимое взято с сайта <a target="_blank" href="http://wikipedia.org/wiki/Main_Page">Wikipedia.org</a></br>
                        Следи за интересными маршрутами в нашей группе <a class='vklink' target="_blank"
                                                                          href="http://vk.com/wikiwalker">Вконтакте</a>
                        <!-- , by <a href="http://vk.com/true_pk">true_pk</a> <a href="http://vk.com/id210883700">dimas</a> -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="assets/js/docs.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
