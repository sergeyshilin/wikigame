<?php
header('Content-Type: text/html; charset=utf-8');
include 'authorize.php';
require_once('wikigame/WayParser.php');

$parser = new WayParser('wikigame/scripts/results/programming_unsorted.txt');
$parser->setLang('ru');
$parser->writeWays(7);