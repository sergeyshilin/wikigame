<?php

header('Content-Type: text/html; charset=utf-8');

include 'authorize.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>WikiWalker - Проверь свой путь</title>
    <link rel="stylesheet" type="text/css" href="w/res/css/main.css">
    <script type="text/javascript" src="w/res/js/jquery.min.js"></script>
    <script type="text/javascript" src="w/res/js/main.js"></script>
</head>
<body>
<div id="showways">
    <?php
    // xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

    require_once('w/WayUtils.php');
    require_once('w/Way.php');

    $editor = new WayUtils();

    if (isset($_GET['cat']) && !empty($_GET['cat'])) {
        $id = $_GET['cat'];

        $ways = $editor->getWaysByCat($id);

        echo "<div class='way'>
				<div class='number'>Number</div>
				<div class='hash'>Hash</div>
				<div class='way_nodes'>Links</div>
				<div class='depth'>Depth</div>
				<div class='links'>Links</div>
				<div class='verified'>
					<input type='checkbox' class='all' />Verify All
				</div>
				<div class='delete'>Delete</div>
			</div>";

        for ($i = 0; $i < count($ways); $i++) {
            $number = $i + 1;
            $checked = $ways[$i]["verified"] ? "checked" : "";
            echo "<div class='way' id='" . $ways[$i]["hash"] . "'>";
            echo "<div class='number'>" . $number . "</div>";
            echo "<div class='hash'><a href='/" . $ways[$i]["hash"] . "' target='_blank'>" . $ways[$i]["hash"] . "</a></div>";
            echo "<div class='way_nodes'>";

            foreach ($ways[$i]["way"] as $node) {
                echo "<div class='node'><a href='" . Way::getUrl($node) . "' target='_blank'>";
                echo Way::getName($node) . "</a></div>";
            }

            echo "</div>";
            echo "<div class='depth'>" . $ways[$i]["depth"] . "</div><div class='links'>" . $ways[$i]["links"] . "</div>";
            echo "<div class='verified'><input type='checkbox' class='check' disabled " . $checked . "/></div>";
            echo "<div class='delete'><a onclick='deleteWay(\"" . $ways[$i]["hash"] . "\")' class='link jslink'>Удалить</a></div>";
            echo "</div>";
        }

        echo "<a class='jslink' onclick='saveAllInCat(" . $id . ");'>Сохранить</a>";

    } else {
        $cats = $editor->getCategories();

        foreach ($cats as $cat) {
            echo "<h3><a href='?cat=" . $cat["id"] . "'>" . $cat["name"] . "</a></h3>";
        }
    }

    // $xhprof_data = xhprof_disable('/tmp');

    // $XHPROF_ROOT = "/var/www/xhprof/";
    // include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
    // include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

    // $xhprof_runs = new XHProfRuns_Default();
    // $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_testing");

    // echo "<a href='http://domain1/xhprof/index.php?run={$run_id}&source=xhprof_testing' target='_blank'>XHProf report</a>";

    ?>
</div>
</body>
</html>