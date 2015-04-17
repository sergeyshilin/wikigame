<?php
session_start();

if ($_POST && session_id() && !empty($_SESSION["hash"])) {
    require_once('../w/classes/WayUtils.php');

    $user_id = empty($_SESSION["user_id"]) ? session_id() : $_SESSION["user_id"];
    $way_hash = $_SESSION["hash"];
    $utils = new WayUtils();
    $like = $utils->getLike($user_id, $way_hash);
    if ($like != NULL)
        echo $like["like"];
    else
        echo "bad";
} else {
    echo 'need post';
}
?>