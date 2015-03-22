<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    <title>WikiWalker - Проверь свой путь</title>
	    <link rel="stylesheet" type="text/css" href="wikigame/css/main.css">
	    <script type="text/javascript" src="wikigame/js/jquery.min.js"></script>
	    <script type="text/javascript" src="wikigame/js/main.js"></script>
   	</head>
   	<body>
   		<div id="showways">
<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once('wikigame/WayUtils.php');
	require_once('wikigame/Way.php');

	$editor = new WayUtils();

	if(isset($_GET['cat']) && !empty($_GET['cat'])) {
		$id = $_GET['cat'];

		$ways = $editor->getWaysByCat($id);

		for($i = 0; $i < count($ways); $i++) {
			$number = $i + 1;
			$checked = $ways[$i]["verified"] ? "checked" : "";
			echo "<div class='way'>";
			echo "<div class='number'>".$number."</div>";
			echo "<div class='hash'>".$ways[$i]["hash"]."</div>";
			echo "<div class='way_nodes'>";

			foreach ($ways[$i]["way"] as $node) {
				echo "<div class='node'><a href='".Way::getUrl($node)."' target='_blank'>";
				echo Way::getName($node)."</a></div>";
			}

			echo "</div>";
			echo "<div class='depth'>".$ways[$i]["depth"]. "</div><div class='links'>".$ways[$i]["links"]."</div>";
			echo "<div class='verified'><input type='checkbox' ".$checked."/></div>";
			echo "<div class='delete'><a href='#' class='link'>Удалить</a></div>";
			echo "</div>";
		}

	} else {
		$cats = $editor->getCategories();

		foreach ($cats as $cat) {
			echo "<h3><a href='?cat=".$cat["id"]."'>".$cat["name"]."</a></h3>";
		}
	}

?>
		</div>
	</body>
</html>