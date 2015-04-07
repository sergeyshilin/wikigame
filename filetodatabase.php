<?php
header('Content-Type: text/html; charset=utf-8');
include 'authorize.php';
require_once('w/WayParser.php');

$parser = new WayParser('wikigame/scripts/results/1_april_route.txt');
$parser->setLang('ru');
$parser->writeWays(3);
