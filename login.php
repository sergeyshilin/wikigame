<?php
session_start();

$loggedIn = isset($_SESSION['user_connected']) && $_SESSION['user_connected'] === true;

if ($loggedIn)
    header("Location: /");

$error = false;
$error_msg = "";
require_once('hybrid_connect.php');

if (isset($_REQUEST["email"]) && isset($_REQUEST["password"])) {
    $user_exist = get_user_by_email_and_password($_REQUEST["email"], md5($_REQUEST["password"]));

    if ($user_exist) {
        $_SESSION["user_connected"] = true;
        header("Location: /");
    } else {
        $error = !$error;
        $error_msg = "Неверно указаны е-мэйл или пароль";
    }
} elseif (isset($_REQUEST["provider"])) {

    $provider_name = $_REQUEST["provider"];

    try {
        // inlcude HybridAuth library
        $config = 'hybrid/hybridauth/config.php';
        require_once("hybrid/hybridauth/Hybrid/Auth.php");

        $hybridauth = new Hybrid_Auth($config);
        $adapter = $hybridauth->authenticate($provider_name);
        $user_profile = $adapter->getUserProfile();
    } catch (Exception $e) {
        echo $e;
        // header("Location: http://www.example.com/login-error.php");
    }

    // check if the current user already have authenticated using this provider before
    $user_exist = get_user_by_provider_and_id($provider_name, $user_profile->identifier);

    // if the used didn't authenticate using the selected provider before
    // we create a new entry on database.users for him
    if (!$user_exist) {
        create_new_hybridauth_user(
            $user_profile->email,
            $user_profile->firstName,
            $user_profile->lastName,
            $provider_name,
            $user_profile->identifier
        );
    }

    // set the user as connected and redirect him
    $_SESSION["user_connected"] = true;
    $_SESSION["user_adapter"] = $provider_name;

    header("Location: /");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- made by www.metatags.org -->
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <meta name="keywords" content="википедия, вики, игра, интерактив, развлечение, образование, ссылка, переход, клик"/>
    <meta name="author" content="Sergey Shilin & Dmitriy Verbitskiy">
    <meta name="robots" content="index, nofollow">
    <meta name="revisit-after" content="3 days">

    <meta property="og:title" content="WikiWalker - Пройди свой путь"/>
    <meta property="og:description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <meta property="og:url" content="http://wikiwalker.ru/login.php"/>
    <meta property="og:image" content="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>
    <meta property="og:image:url" content="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>

    <meta name="title" content="WikiWalker - Пройди свой путь"/>
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <link rel="image_src" href="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>

    <title>WikiWalker - Авторизация</title>

    <link rel="stylesheet" type="text/css" href="w/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="w/css/index.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="wrapper">
    <?php
    include_once('w/frame/header_index.php');
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?php
                include_once('w/frame/login.php');
                ?>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>Содержимое взято с сайта
                <a target="_blank" href="http://wikipedia.org/wiki/Main_Page">Wikipedia.org</a><br>
                Поддержи проект! Вступай в группу
                <a class='vklink' target="_blank" href="http://vk.com/wikiwalker">Вконтакте</a>
            </p>
        </div>
    </div>
</div>

<script src="w/js/jquery.min.js"></script>
<script src="w/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="w/js/ie10-viewport-bug-workaround.js"></script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter28976460 = new Ya.Metrika({id:28976460, trackLinks:true, accurateTrackBounce:true, trackHash:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/28976460" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
