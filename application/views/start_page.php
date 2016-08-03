<div class="row">
    <div class="col-lg-8">
        <div class="greating">
            <h1>Пройди свой путь</h1>
            <p class="lead">Пройди путь от одной страницы Википедии до другой за минимальноe количество шагов.<br>
                Думаешь, это просто? Попробуй сыграть прямо сейчас!</p>
        </div>
        <div class="game-type-grid">
            <div class="row row-eq-height">
                <div class="game-type col-sm-4">
                    <img src="application/images/game_types/wki_icon-02.png" onclick="goto('classic')">
                    <div class="game-type-text" onclick="goto('classic'); yaCounter28976460.reachGoal('classic')">
                        <h3>Классический</h3>
                        <p>Стандартная игра без ограничений</p>
                    </div>
                </div>
                <div class="game-type col-sm-4">
                    <img src="application/images/game_types/wki_icon-01.png" onclick="goto('one_minute');
                     yaCounter28976460.reachGoal('one_minute')">
                    <div class="game-type-text" onclick="goto('one_minute')">
                        <h3>На время</h3>
                        <p>Пройдите маршрут за 1 минуту. Слабо?</p>
                    </div>
                </div>
                <div class="game-type col-sm-4">
                    <img src="application/images/game_types/wki_icon-05.png" onclick="showHitlerModal();
                    yaCounter28976460.reachGoal('hitler_popup')">
                    <div class="game-type-text" onclick="showHitlerModal()">
                        <h3>Гитлер</h3>
                        <p>Доберитесь до Гитлера любой ценой!</p>
                    </div>
                </div>
            </div>
            <div class="row row-eq-height">
                <div class="game-type col-sm-4">
                    <img src="application/images/game_types/wki_icon-03.png" onclick="runIfLoggedIn(showCustomWayModal);
                    yaCounter28976460.reachGoal('custom_way'); saveRefererMode('custom')">
                    <div class="game-type-text" onclick="runIfLoggedIn(showCustomWayModal); saveRefererMode('custom')">
                        <h3>Свой маршрут</h3>
                        <p>Проложите свой маршут, соревнуйтесь с друзьями</p>
                    </div>
                </div>
                <div class="game-type col-sm-4">
                    <img src="application/images/game_types/wki_icon-04.png" onclick="runIfLoggedIn(showChallengeModal); saveRefererMode('challenge')">
                    <div class="game-type-text" onclick="runIfLoggedIn(showChallengeModal); saveRefererMode('challenge');
                    yaCounter28976460.reachGoal('challenge_modal')">
                        <h3>Дуэль</h3>
                        <p>Найдите себе соперника и пройдите маршрут первым!</p>
                    </div>
                </div>
                <div class="game-type col-sm-4">
                    <img src="application/images/game_types/wki_icon-06.png" onclick="runIfLoggedIn(goto, 'compete'); saveRefererMode('compete')">
                    <div class="game-type-text" onclick="runIfLoggedIn(goto, 'compete'); saveRefererMode('compete');
                    yaCounter28976460.reachGoal('compete')">
                        <h3>Турнир</h3>
                        <p>Пройдите 5 маршрутов за 15 минут и получите 1500 очков!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div id="stats" class="carousel slide" data-ride="carousel" data-interval="10000">
            <div class="carousel-inner">
                <div class="active item">
                    <div class="list-group" id="top-users">
                        <a class="list-group-item active">
                            <span class="upd-stats badge">Обновить</span>
                            <h4 class="list-group-item-heading">Лучшие игроки</h4>
                        </a>
                        <?php $i = 1;
                        foreach ($info["all_leaders"] as $key => $value) : ?>
                            <a class="list-group-item">
                                <span class="badge"> <?= $value["value"] ?></span>
                                <h4 class="list-group-item-heading"><?= $i . ". " ?><i class="fa fa-user"></i>&nbsp<?= $value["nick"] ?></h4>
                                <p class="list-group-item-text">Сыграно игр: <?= $value["count"] ?></p>
                            </a>
                            <?php $i++; endforeach; ?>
                        <?php while ($i < 9) : ?>
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
                            <h4 class="list-group-item-heading">Популярное за все время</h4>
                        </a>
                        <?php $i = 1;
                        foreach ($info["all_pop_ways"] as $key => $value): ?>
                            <a class="list-group-item" href="<?= $value['way_link'] ?>">
                                <span class="badge"> <?= $value["rating"] ?></span>
                                <h4 class="list-group-item-heading"><?= $i . ". " . $value["start"] ?> <i class="fa fa-arrow-right"></i></h4>
                                <p class="list-group-item-text"><i class="fa fa-arrow-right"></i> <?= $value["end"] ?></p>
                            </a>
                            <?php $i++; endforeach; ?>
                        <?php while ($i < 9) : ?>
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
                            <h4 class="list-group-item-heading">Лучшие игроки за сегодня</h4>
                        </a>
                        <?php $i = 1;
                        foreach ($info["leaders"] as $key => $value) : ?>
                            <a class="list-group-item" href="<?= $value['way_link'] ?>">
                                <span class="badge"> <?= $value["value"] ?></span>
                                <h4 class="list-group-item-heading"><?= $i . ". " ?><i class="fa fa-user"></i>&nbsp<?= $value["nick"] ?></h4>
                                <p class="list-group-item-text">Сыграно игр: <?= $value["count"] ?></p>
                            </a>
                            <?php $i++; endforeach; ?>
                        <?php while ($i < 9) : ?>
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
                            <h4 class="list-group-item-heading">Популярное за сегодня</h4>
                        </a>
                        <?php $i = 1;
                        foreach ($info["pop_ways"] as $key => $value) : ?>
                            <a class="list-group-item" href="<?= $value['way_link'] ?>">
                                <span class="badge"> <?= $value["rating"] ?></span>
                                <h4 class="list-group-item-heading"><?= $i . ". " . $value["start"] ?> <i class="fa fa-arrow-right"></i></h4>
                                <p class="list-group-item-text"><i class="fa fa-arrow-right"></i> <?= $value["end"] ?></p>
                            </a>
                            <?php $i++; endforeach; ?>
                        <?php while ($i < 9) : ?>
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


<script>
    function getParameterByName(name) {
        name = name.replace(/[\[\]]/g, "\\$&").toLowerCase();
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(window.location.href);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    $(document).ready(function () {
        var action = getParameterByName('action');
        switch (action) {
            case 'custom-way-modal':
                showCustomWayModal();
                break;
        }
    });

    function goto(url) {
        window.location.href = url;
    }

    function runIfLoggedIn(func, arg) {
        if (!<?= ($loggedIn) ? 'true' : 'false' ?>) {
            showLoginModal();
        } else {
            func(arg);
        }
    }

    function saveRefererMode(mode){
        window.referer_mode = mode;
    }
    $(".upd-stats").click(function(){
        $.ajax({
            url: "/main/upd-stats"
        }).done(function(){
            location.href = "/";
        });
    });

    $(document).ready(function(){
        window.referer_mode_ = "<?=$data2?>";
        switch (window.referer_mode_) {
            case "custom":
                showCustomWayModal();
                break;
            case "challenge":
                showChallengeModal();
                break;
            case "compete":
                goto("compete");
                break;
            case "login_modal":
                showLoginModal();
                break;
            default:
                break;
        }
    });


</script>

<?php
include 'modals/login_modal.php';
include 'modals/custom_way_modal.php';
include 'modals/hitler_modal.php';
include 'modals/challenge_modal.php';?>


