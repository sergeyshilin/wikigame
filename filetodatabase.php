<?php
header('Content-Type: text/html; charset=utf-8');
include 'authorize.php';
require_once('wikigame/WayParser.php');

$parser = new WayParser('wikigame/scripts/results/1.txt');
$parser->setLang('ru');
$parser->writeWays(5);