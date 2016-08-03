<?php
$playlink = $_SESSION["playlink"];
?>

<div class="row" style="text-align:center; color: #fff;">
    <h1 class="cover-heading">
        <?php if ($info== "/one_minute") : ?>Упс... Вы не успели пройти маршрут за одну минуту<?php endif; ?>
        <?php if ($info== "/compete") : ?>К сожалению, время турнира истекло<?php endif; ?>
        <?php if ($info== "/challenge") : ?>Вы проиграли! Соперник раньше дошел до конца! :)<?php endif; ?>
    </h1>

    <p class="lead">
        <?php if ($info== "/one_minute") : ?>
            Но, вы можете попробовать снова пройти игру на этом маршруте. У вас получится!
        <?php endif;
        if ($info== "/compete") : ?>
            Но, попробуйте пройти турнир еще раз! У вас обязательно получится!
        <?php endif; ?>
        <?php
        if ($info== "/hitler/5_steps") : ?>
        Кажется, вы не смогли добраться до Гитлера за 5 шагов. Жаль. Попробуйте еще раз!
        <?php endif; ?>
        <?php if ($info== "/challenge") : ?>Попробуйте сыграть еще раз, может быть в этот раз вы окажетесь более проворным! ;)<?php endif; ?>

    </p>

    <p class="lead">
        <a href="<?=$info?>" class="btn btn-lg btn-success congrats_playagain"
           onclick="yaCounter28976460.reachGoal('lose_newgame'); return true;">Новая игра</a>
        <?php if ($info!= "/challenge") : ?>
            <a href="/<?= $playlink ?>" class="btn btn-lg btn-success congrats_playagain"
               onclick="yaCounter28976460.reachGoal('lose_playagain'); return true;">Попробовать еще раз</a>
        <?php endif; ?>
    </p>
</div>

<script type="text/javascript">
    window.history.pushState("", "", "/<?=$playlink?>");
    history.pushState(null, null, location.href);
    window.onpopstate = function (event) {
        history.go(1);
    };
    $(window).load(function () {
        yaCounter28976460.reachGoal('lose_game');
    });
</script>