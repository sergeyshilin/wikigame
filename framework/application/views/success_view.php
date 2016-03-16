<?php
$cat = $_SESSION["cat"] ? "?cat=" . $_SESSION["cat"] : "";
$count = $_SESSION['counter'];
$hash = $_SESSION['hash'];
$url = "http://wikiwalker.ru/" . $hash;
$title = "WikiWalker - Пройди свой путь!";
$desc = "Поздравляем! Вы прошли от страницы " . str_replace("_", " ", $_SESSION["start"]) . " до страницы " . str_replace("_", " ", $_SESSION["end"]) . ". Количество шагов: " . $_SESSION["counter"] . ".";
$start_page = str_replace("_", " ", $_SESSION["start"]);
$end_page = str_replace("_", " ", $_SESSION["end"]);
// require_once('../classes/WayUtils.php');
/**
 *   Здесь нужно учитывать статистику о пройденном маршруте.
 *   Либо просто записывать минимальное кол-во шагов, за которые пользователь
 *   прошел данный маршрут, либо кол-во шагов, за которые пользователь прошел данный маршрут
 *   в этот день (таким образом можно разбивать статистику по времени (день, месяц, год?) )
 */
?>
<body>
<!---->
<!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
<!--<link href="/application/css/cover.css" rel="stylesheet">-->
<script type="text/javascript">
    window.history.pushState("", "Title", "/wiki/<?=$hash?>");
</script>
<div class="wrapper">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
<?php include_once("topbar_frame.php"); ?>
                <h1 class="cover-heading">Поздравляем! <?=$data?></h1>

                <p class="lead" style="margin-bottom: 0">
                    Вы завершили свой маршрут! Количество переходов: <span class="label label-danger"><?= $count ?></span><br>
                    Начальная страница: <span class="label label-warning"><?= $start_page ?></span><br>
                    Конечная страница: <span class="label label-warning"><?= $end_page ?></span><br>
                    Понравился маршрут?
                    <span class="label label-success link-button like"><i class="fa fa-thumbs-o-up"></i></span>
                    <span class="label label-danger link-button dislike"><i class="fa fa-thumbs-o-down"></i></span>
                    </br>
                    Поделись результатом с друзьями!
                </p>

                <div id="sharebtns" style="margin-bottom: 20px">
                    <a id="share_vk" class="sharebtn vk"></a>
                    <a id="share_fb" class="sharebtn fb"></a>
                    <a id="share_gp" class="sharebtn gp"></a>
                    <a id="share_tw" class="sharebtn tw"></a>
                </div>
                <p class="lead">
                    <a href="/wiki/Main_Page<?= $cat ?>" class="btn btn-lg btn-success congrats_playagain"
                       onclick="yaCounter28976460.reachGoal('newgame'); return true;">Новая игра</a>
                </p>
            </div>

            <div class="mastfoot">
                <div class="inner">
                    <p>Содержимое взято с сайта <a target="_blank" href="http://wikipedia.org/wiki/Main_Page">Wikipedia.org</a><br>
                        Следи за интересными маршрутами в нашей группе
                        <a class='vklink' target="_blank" href="http://vk.com/wikiwalker">Вконтакте</a>
                        <!-- , by <a href="http://vk.com/true_pk">true_pk</a> <a href="http://vk.com/id210883700">dimas</a> -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/application/js/parse-1.4.0.min.js"></script>
<script src="/application/js/Share.js"></script>
<script type="text/javascript">
    <?php if($_SESSION["user_connected"]) { ?>
    setWaySteps();
    <?php } ?>
    loadLike();
</script>
<script language="JavaScript">
    Parse.initialize("NuuzdEmcbtxcB3AwGOshxD455GTV0EUVbEFL2S4C", "2rwODwVyiSYls9P66iRdZmAlNUL6mlmz5j11dC0R");
    var url = "<?=$url?>";
    var title = "<?=$title?>";
    var description = "<?=$desc?>";
    var share = new Share(url, title, description);

        yaCounter28976460.reachGoal('wingame');

        share.makeImage("<?=$count?>", "<?=$start_page?>", "<?=$end_page?>", function (base64img) {
            var parseFile = new Parse.File("share.png", {base64: base64img});
            parseFile.save().then(function () {
                share.pimg = parseFile.url();
                $("#share_vk").click(function () {
                    yaCounter28976460.reachGoal('sharevk');
                    share.vkontakte();
                });
                $("#share_fb").click(function () {
                    yaCounter28976460.reachGoal('sharefb');
                    share.facebook();
                });
                $("#share_gp").click(function () {
                    yaCounter28976460.reachGoal('sharegoogle');
                    share.googleplus();
                });
                $("#share_tw").click(function () {
                    yaCounter28976460.reachGoal('sharetwit');
                    share.twitter();
                });
            }, function (error) {
                console.log(error);
            });
        });
</script>
</body>
