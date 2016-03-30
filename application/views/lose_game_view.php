<?php
$playlink = $_SESSION["playlink"];
?>

<div class="row" style="text-align:center; color: #fff;">
    <h1 class="cover-heading">
        <?php if ($info== "/one_minute") : ?>Упс... Вы не успели пройти маршрут за одну минуту<?php endif; ?>
        <?php if ($info== "/compete") : ?>К сожалению, время турнира истекло<?php endif; ?>
    </h1>

    <p class="lead">
        <?php if ($info== "/one_minute") : ?>
            Но, вы можете попробовать снова пройти игру на этом маршруте. У вас получится!
        <?php endif;
        if ($info== "/compete") : ?>
            Но, попробуйте пройти турнир еще раз! У вас обязательно получится!
        <?php endif; ?>
    </p>

    <p class="lead">
        <a href="/one_minute" class="btn btn-lg btn-success congrats_playagain"
           onclick="yaCounter28976460.reachGoal('newgame'); return true;">Новая игра</a>
        <a href="/<?= $playlink ?>" class="btn btn-lg btn-success congrats_playagain"
           onclick="yaCounter28976460.reachGoal('newgame'); return true;">Попробовать еще раз</a>
    </p>
</div>

<script type="text/javascript">
    window.history.pushState("", "", "/<?=$playlink?>");
    history.pushState(null, null, location.href);
    window.onpopstate = function (event) {
        history.go(1);
    };
</script>