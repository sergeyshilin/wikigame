<?php
    $playlink = $_SESSION["playlink"];
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
<div class="wrapper">
    <?php include_once("topbar_frame.php"); ?>
    <div class="container">
        <div class="row" style="text-align:center;">

            <h1 class="cover-heading">
                <?php if($data == "/one_minute") :?>Упс... Вы не успели пройти маршрут за одну минуту<?php endif;?>
                <?php if($data == "/compete") :?>К сожалению, время турнира истекло<?php endif;?>

            </h1>

            <p class="lead" style="margin-bottom: 0">
                <?php if($data == "/one_minute") :?>
                Но, вы можете попробовать снова пройти игру на этом маршруте. У вас получится!
                <?php endif; if($data == "/compete") :?>
                Но, попробуйте пройти турнир еще раз! У вас обязательно получится!
                <?php endif;?>

            </p>
            <p class="lead">
                <a href="/one_minute" class="btn btn-lg btn-success congrats_playagain"
                   onclick="yaCounter28976460.reachGoal('newgame'); return true;">Новая игра</a>
                <a href="/<?=$playlink?>" class="btn btn-lg btn-success congrats_playagain"
                   onclick="yaCounter28976460.reachGoal('newgame'); return true;">Попробовать еще раз</a>
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
</body>