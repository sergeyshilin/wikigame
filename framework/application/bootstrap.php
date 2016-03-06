<?php
// var_dump($_POST); //!DEBUG
include 'core/logger_mod.php';
require_once("core/model.php");
require_once("core/view.php");
require_once("core/controller.php");
require_once("core/route.php");
require_once("vendor/Way.php");
require_once("vendor/WayParser.php");
require_once("vendor/PageResolver.php");
require_once("vendor/WayUtils.php");
require_once('vendor/simple_html_dom.php');
require_once('vendor/StringUtils.php');
// var_dump($_SESSION);
Route::start();
