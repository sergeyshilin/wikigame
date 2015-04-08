<?php
	session_start();

	if(!$_SESSION["user_connected"])
        header("Location: login.php");

    $config   = 'hybrid/hybridauth/config.php';
    require_once( "hybrid/hybridauth/Hybrid/Auth.php" );

    $hybridauth = new Hybrid_Auth($config);
    $session = Hybrid_Auth::getSessionData();

    print_r($session);

?>