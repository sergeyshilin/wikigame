<body>
<div class="wrapper">
    <?php
    include_once("topbar_frame.php");
    ?>
    <div class="row"></div>
    <div class="col-md-4">
        <h2>Общая информация</h2>
        <h4>Ваш ник: <span id="nickval"><?= $data["nick"][0] ?></span><input type="text" id="nickform" style="color:black" value=""> <a id="editnick"><span class="glyphicon glyphicon-pencil"></span></a><a id="savenick"><span class="glyphicon glyphicon-floppy-disk"></span></a></h4>
        <h4>Ваш рейтинг: <? echo ($data["rating"] == null)? 0 : $data["rating"]; ?></h4>
        <h4>Ваш уровень: <?= $data["rank"] ?></h4>
        <h4>Позиция среди всех игроков: <?=$data["order"]?></h4>
        <hr class="hr">
        <h3>Статистика по режимам</h3>
        <?php foreach($data2 as $k=>$v): ?>
        <h4><?=$v[0]?>: <?php echo(isset($v[1])) ? $v[1] : 0 ?></h4>
        <?php endforeach; ?>
    </div>
    <div class="col-md-4">
        <h2>Ваша история игр</h2>
        <table class="table">
            <thead>
            <tr><td>Старт</td><td>Конец</td><td>Шаги</td></tr>
            </thead>
        <?php
            foreach($info["played"] as $key=>$value){
                $start = StringUtils::pageTitle($value["start"]);
                $end = StringUtils::pageTitle($value["end"]);
                echo "<tr><Td><a target='_blank' href='$value[start]'>".$start."</a></Td>
                <td><a target='_blank' href='$value[end]'>".$end."</a></td><td>$value[steps]" . $value["hash"]."</td></tr>";
            }
        ?>
        </table>
    </div>
    <div class="col-md-4">
        <h2>Список созданных вами маршрутов</h2>
        <table class="table">
            <thead>
            <tr><td>Старт</td><td>Конец</td><td>Действие</td></tr>
            </thead>
            <?php
            foreach($info["custom_ways"] as $key=>$value){
                $start = StringUtils::pageTitle($value["startlink"]);
                $end = StringUtils::pageTitle($value["endlink"]);
                echo "<tr><Td><a target='_blank' href='$value[startlink]'>".$start."</a></Td>
                <td><a target='_blank' href='$value[endlink]'>".$end."</a></td><td>
                <a href=/one_minute/".$value["hash"]."><span class='glyphicon glyphicon-time' title='На время'></span></a>".
                "<a href=/challenge/custom/".$value["hash"]."><span class='glyphicon glyphicon-send' title='Дуэль'></span></a>".
                "<a href=/wiki/custom_way/".$value["hash"]."><span class='glyphicon glyphicon-copyright-mark' title='Классический'></span></a>".
                "</td></tr>";
            }
            ?>
        </table>
    </div>
    </div>
</div>
<script>
    $("#nickform").css("visibility", "hidden");
    $("#savenick").css("visibility", "hidden");
    $("#editnick").click(function(){
        var temp = $("#nickval").text();
        $("#nickval").hide();
        $("#nickform").css("visibility", "visible");
        $("#savenick").css("visibility", "visible");
        $("#nickform").val(temp);
        $("#editnick").hide();
    });
    $("#savenick").click(function(){
        $.ajax({
            url: "/account/savenick",
            data: { nick : $("#nickform").val() },
            method: "POST"
        }).done(function(data){
            if(data == "exists"){
                alert("Такой ник уже занят");
            }
            else{
                $("#nickval").show();
                $("#nickform").css("visibility", "hidden");
                $("#savenick").css("visibility", "hidden");
                $("#editnick").show();
                $("#nickval").text(data);
            }
        })
    })
</script>
</body>
