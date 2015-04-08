<?php
header('Content-Type: text/html; charset=utf-8');
include 'authorize.php';
require_once('w/classes/WayParser.php');

$parser = new WayParser('scripts/results/1.txt');
$parser->setLang('ru');
$parser->writeWays(4);
