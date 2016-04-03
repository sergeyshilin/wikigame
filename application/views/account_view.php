<style>
    .account-view, td, a, a:hover, a:visited {
        color: #fff;
    }

    .panel {
        background-color: rgba(33, 121, 185, 0.4);
        padding: 0 10px;
    }
    h2 {
        margin-top: 10px;
    }
    .way-action {
        margin-right: 3px;
    }
    #nickform {
        padding: 0;
        border-width: 0;
        margin: 0;
        height: 19px;
    }
</style>

<div class="row account-view">
    <div class="col-md-6">
        <div class="panel">
            <h2>Общая информация</h2>
            <p>Ваш ник:
                <span id="nickval"><?= $data["nick"][0] ?></span>
                <input type="text" id="nickform" style="color:black; display: none" value="">
                <a id="editnick"><span class="glyphicon glyphicon-pencil"></span></a>
                <a id="savenick" style="display: none"><span class="glyphicon glyphicon-floppy-disk"></span></a>
            </p>
            <?php
                $rating = ($data["rating"] == null) ? 0 : $data["rating"];
                $nextLevelScore = (floatval($data["rank"]) + 1)*(floatval($data["rank"]) + 1)*100;
                $progress = floatval($rating)/$nextLevelScore;
            ?>
            <p>Ваш уровень: <?= $data["rank"] ?></p>
            <p>Ваш рейтинг: <? echo $rating . " / " . $nextLevelScore . " (" . intval($progress*100) . "%)" ?></p>
            <p>Позиция среди всех игроков: <?= $data["order"] ?></p>
            <p>&nbsp;</p>
        </div>

        <div class="panel">
            <h2>Ваша история игр</h2>
            <table class="table">
                <thead>
                <tr>
                    <td>Старт</td>
                    <td>Конец</td>
                    <td>Шаги</td>
                    <td>Действие</td>
                </tr>
                </thead>
                <?php
                foreach ($info["played"] as $key => $value) {
                    $start = StringUtils::pageTitle($value["start"]);
                    $end = StringUtils::pageTitle($value["end"]);
                    echo "<tr><Td><a target='_blank' href='$value[start]'>" . $start . "</a></Td>
            <td><a target='_blank' href='$value[end]'>" . $end . "</a></td><td>" . $value["steps"] . "</td>" .
                        "<td><a href = '$value[gamelink]'><span class='glyphicon glyphicon-play-circle'></span></a></td></tr>";
                }
                ?>
<!--                <tr>-->
<!--                    <td colspan="4" style="text-align: center"><a href="#">Загрузить еще</a></td>-->
<!--                </tr>-->
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel">
            <h2>Статистика по режимам</h2>
            <?php foreach ($data2 as $k => $v): ?>
                <p><?= $v[0] ?>: <?php echo (isset($v[1])) ? $v[1] : 0 ?></p>
            <?php endforeach; ?>
        </div>

        <div class="panel">
            <h2>Список созданных вами маршрутов</h2>
            <table class="table">
                <thead>
                <tr>
                    <td>Старт</td>
                    <td>Конец</td>
                    <td>Действие</td>
                </tr>
                </thead>
                <?php
                foreach ($info["custom_ways"] as $key => $value) {
                    $start = StringUtils::pageTitle($value["startlink"]);
                    $end = StringUtils::pageTitle($value["endlink"]);
                    echo "<tr>
                        <td><a target='_blank' href='$value[startlink]'>" . $start . "</a></td>
                        <td><a target='_blank' href='$value[endlink]'>" . $end . "</a></td>
                        <td>
                            <a class='way-action' href=/one_minute/custom_way/" . $value["hash"] . ">
                                <span class='glyphicon glyphicon-time' title='На время'></span>
                            </a>
                            <a class='way-action' href=/challenge/custom/" . $value["hash"] . ">
                                <span class='glyphicon glyphicon-send' title='Дуэль'></span>
                            </a>
                            <a class='way-action' href=/classic/custom_way/" . $value["hash"] . ">
                                <span class='glyphicon glyphicon-copyright-mark' title='Классический'></span>
                            </a>
                        </td></tr>";
                }
                ?>
<!--                <tr>-->
<!--                    <td colspan="3" style="text-align: center"><a href="#">Загрузить еще</a></td>-->
<!--                </tr>-->
            </table>
        </div>
    </div>
</div>

<script>
    function swapElem(data) {
        window.nick = $("#nickval").text(data);
        $("#nickval").show();
        $("#nickform").css("display", "none");
        $("#savenick").css("display", "none");
        $("#editnick").show();
        $("#nickval").text(data);
    }
    
    window.nick = "";
    $("#nickform").css("display", "none");
    $("#savenick").css("display", "none");
    $("#editnick").click(function () {
        window.nick = $("#nickval").text();
        $("#nickval").hide();
        $("#nickform").css("display", "inline-block");
        $("#savenick").css("display", "inline-block");
        $("#nickform").val(window.nick);
        $("#editnick").hide();
    });
    $("#savenick").click(function () {
        var temp = $("#nickform").val();
        if (window.nick === temp) {
            swapElem(window.nick);
        }
        else {
            $.ajax({
                url: "/account/savenick",
                data: {nick: $("#nickform").val()},
                method: "POST"
            }).done(function (data) {
                if (data == "exists") {
                    alert("Такой ник уже занят");
                }
                else {
                    swapElem(data);
                }
            })
        }

    })
</script>