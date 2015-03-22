<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once('wikigame/WayParser.php'); 

	$parser = new WayParser('wikigame/scripts/results/films_unsorted.txt');
	$parser->setLang('ru');
	$parser->writeWays(3);
?>