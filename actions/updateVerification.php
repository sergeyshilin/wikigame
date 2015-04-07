<?php
if ($_POST) {
    require_once('../w/WayUtils.php');

    $utils = new WayUtils();
    if ($utils->updateVerificationInCat($_POST["category"], $_POST["verify"]))
        echo "ok";
    else
        echo "bad";
} else {
    echo 'need post';
}
?>