<body>
<div class="wrapper">
    <?php
    include_once("topbar_frame.php");
    ?>
    <div class="row"></div>
    <div class="col-md-4">
        <h2>Общая информация</h2>
        <h4>Ваш ник: <?= $data["nick"][0] ?></h4>
        <h4>Ваш рейтинг: <? echo ($data["rating"][0] == null)? 0 : $data["rating"][0]; ?></h4>
        <h4>Ваш уровень: <?= $data["rank"] ?></h4>
    </div>
    <div class="col-md-4">
        <h2>Ваша история игр</h2>
        <table class="table">
            <thead>
            <tr><td>Старт</td><td>Конец</td><td>Кол-во переходов</td></tr>
            </thead>
        <?php
            foreach($info as $key=>$value){
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
    </div>
    </div>
</div>
</body>
