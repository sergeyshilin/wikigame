<?php
if ($_POST) {
    require_once('../classes/WayUtils.php');

    $user_id = $_POST["user_id"];
    $way_id = $_POST["way_id"];
    $like = $_POST["like"];

    $utils = new WayUtils();
    if ($utils->likeWay($user_id, $way_id, $like))
        echo "ok";
    else
        echo "bad";
} else {
    echo 'need post';
}
?>