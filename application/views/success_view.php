<?php
$is_compete = isset($_SESSION["compete"]);

$title = "WikiWalker - Пройди свой путь!";
if (!$is_compete) {
    $count = $_SESSION['counter'];
    $start_page = str_replace("_", " ", $_SESSION["start"]);
    $end_page = str_replace("_", " ", $_SESSION["end"]);
    $description = "Поздравляем! Вы прошли от страницы " . $start_page . " до страницы " . $end_page . ". Количество шагов: " . $count . ".";
} else {
    $count = 0;
    $start_page = "";
    $end_page = "";
    $description = "Поздравляем! Вы прошли турнир!";
}

$playlink = $_SESSION["playlink"];
$url = "http://".$_SERVER["SERVER_NAME"]."/".$playlink;
//echo $start_page . $end_page. "&nbsp".$count;
//echo $playlink;
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
    window.history.pushState("", "", "/<?=$playlink?>");
    history.pushState(null, null, location.href);
    window.onpopstate = function(event) {
        history.go(1);
    };
</script>
        <div class="row" style="text-align:center; color: #fff;">

            <h1 class="cover-heading">Поздравляем!</h1>

            <p class="lead" style="margin-bottom: 0">
                <?php if (!$is_compete): ?>
                    Вы завершили свой маршрут!
                    Количество переходов: <span class="label label-danger"><?= $count ?></span><br>
                    Начальная страница: <span class="label label-warning"><?= $start_page ?></span><br>
                    Конечная страница: <span class="label label-warning"><?= $end_page ?></span><br>
                <?php else: ?>
                    Вы завершили турнир!<br>
                <?php endif; ?>
                <?php if (isset($_SESSION["user_connected"]) && !empty($data2)): ?>
                    Ваш рейтинг теперь: <?= $data2["new_rating"] ?><br>
                    <?php if ($data2["old_rank"] == $data2["new_rank"]): ?>
                        Ваш уровень: <?= $data2["old_rank"] ?><br>
                    <?php endif; ?>
                    <?php if ($data2["old_rank"] < $data2["new_rank"]): ?>
                        Ура! Теперь вы на <b><?= $data2["new_rank"] ?></b> уровне<br>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!$is_compete): ?>
                    Понравился маршрут?
                    <span id="like" class="label label-success link-button" style="cursor:pointer;"><i class="fa fa-thumbs-o-up"></i></span>
                    <span id="dislike" class="label label-danger link-button" style="cursor:pointer;"><i class="fa fa-thumbs-o-down"></i></span>
                    <br>
                <?php endif; ?>
                Поделись результатом с друзьями!
            </p>

            <div id="sharebtns" style="margin-bottom: 20px">
                <a id="share_vk" class="sharebtn vk"></a>
                <a id="share_fb" class="sharebtn fb"></a>
                <a id="share_gp" class="sharebtn gp"></a>
                <a id="share_tw" class="sharebtn tw"></a>
            </div>
            <p class="lead">
                <a href="<?=$url?>" class="btn btn-lg btn-success congrats_playagain"
                   onclick="yaCounter28976460.reachGoal('newgame'); return true;">Новая игра</a>
            </p>
        </div>

<script>
    syncLikes();
    Parse.initialize("NuuzdEmcbtxcB3AwGOshxD455GTV0EUVbEFL2S4C", "2rwODwVyiSYls9P66iRdZmAlNUL6mlmz5j11dC0R");
    var url = "<?=$url?>";
    var title = "<?=$title?>";
    var description = "<?=$description?>";
    var share = new Share(url, title, description);

    $(window).load(function () {
        yaCounter28976460.reachGoal('wingame');
    });
    $(document).ready(function(){
        share.makeImage("<?=$count?>", "<?=$start_page?>", "<?=$end_page?>", <?=$is_compete?>, function (base64img) {
            var parseFile = new Parse.File("share.png", {base64: base64img});
            parseFile.save().then(function () {
                share.pimg = parseFile.url();
            }, function (error) {
                console.log(error);
            });
        });

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
    });

    function syncLikes() {
        $.ajax({
            url: "/main/like/check"
        }).done(function (data) {
            console.log(data);
            window.like = data;
            $("#like").css("border", "none");
            $("#dislike").css("border", "none");
            $("#like i").removeClass("fa-thumbs-o-up fa-thumbs-up");
            $("#dislike i").removeClass("fa-thumbs-o-down fa-thumbs-down");
            if (data == 1) {
                $("#like").css("border", "2px solid white");
                $("#like i").addClass("fa-thumbs-up");
                $("#dislike i").addClass("fa-thumbs-o-down");
            } else if (data == -1) {
                $("#dislike").css("border", "2px solid white");
                $("#like i").addClass("fa-thumbs-o-up");
                $("#dislike i").addClass("fa-thumbs-down");
            } else {
                $("#like i").addClass("fa-thumbs-o-up");
                $("#dislike i").addClass("fa-thumbs-o-down");
            }
        });
    }
    $("#dislike").click(function () {
        if (window.like == "-1") {
            $.ajax({url: "/main/like"}).done(function () {
                syncLikes();
            });
        } else if (window.like == "0" || window.like == "1") {
            $.ajax({url: "/main/like/-1"}).done(function () {
                syncLikes();
            });
        }
    });
    $("#like").click(function () {
        if (window.like == "1") {
            $.ajax({url: "/main/like"}).done(function () {
                syncLikes();
            });
        } else if (window.like == "0" || window.like == "-1") {
            $.ajax({url: "/main/like/1"}).done(function () {
                syncLikes();
            });
        }
    });
</script>
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
