<?php
header('Content-Type: text/html; charset=utf-8');
include 'authorize.php';
require_once('w/WayParser.php');

$parser = new WayParser('/w/scripts/results/programming_unsorted.txt');
$parser->setLang('ru');
$parser->writeWays(7);