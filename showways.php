<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once('wikigame/WayParser.php');
	require_once('wikigame/Way.php');

	$parser = new WayParser('wikigame/scripts/russians.txt');
	$parser->setLang('ru');

	$ways = $parser->getWays();

	for($i = 0; $i < count($ways); $i++) {
		echo $i+1 . "\t||\t";
		foreach ($ways[$i]->getWay() as $node) {
			echo "&nbsp;---->&nbsp;<a href='".Way::getUrl($node)."'>".Way::getName($node)."</a>";
		}

		echo "\t||\t".$ways[$i]->getDepth(). "\t||\t".$ways[$i]->getLinksCount()."<br>";
	}
?>