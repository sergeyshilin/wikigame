<?php
	if ($_POST) {
	    require_once('../wikigame/WayUtils.php');
	    
	    $utils = new WayUtils();
	    if($utils->deleteWayByHash($_POST["hash"]))
	    	echo "ok";
	    else
	    	echo "bad";
	} else {
	    echo 'need post';
	}
?>