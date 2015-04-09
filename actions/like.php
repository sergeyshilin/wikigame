<?php
session_start();

if ($_POST && !empty($_SESSION["user_id"]) && !empty($_SESSION["hash"])) {
    require_once('../w/classes/WayUtils.php');

    $user_id = $_SESSION["user_id"];
    $way_hash = $_SESSION["hash"];
    $like = $_POST["like"];

    $utils = new WayUtils();
    if ($utils->likeWay($user_id, $way_hash, $like))
        echo "ok";
    else
        echo "bad";
} else {
    echo 'need post';
}
?>