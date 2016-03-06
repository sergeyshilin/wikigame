<?php
session_start();

if ($_POST && !empty($_SESSION["user_id"]) && !empty($_SESSION["hash"]) && !empty($_SESSION["counter"])) {
    require_once('../w/classes/WayUtils.php');

    $user_id = $_SESSION["user_id"];
    $way_hash = $_SESSION["hash"];
    $count = $_SESSION["counter"];
    $utils = new WayUtils();
    if ($utils->setWaySteps($user_id, $way_hash, $count))
        echo "ok";
    else
        echo "bad";
} else {
    echo 'need post';
}
?>