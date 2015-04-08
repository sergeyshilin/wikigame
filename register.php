<?php
    session_start();

      if($_SESSION["user_connected"])
        header("Location: /");

      $error = false;
      $error_msg = "";
      require_once('hybrid_connect.php');

    if($_REQUEST) {
        if( !empty( $_REQUEST["email"] ) && 
                !empty( $_REQUEST["password"] ) && 
                    !empty( $_REQUEST["password_confirmation"] ) ) {
            $user_exist = get_user_by_email( $_REQUEST["email"] );
            if($user_exist) {
                $error = !$error;
                $error_msg = "Пользователь с таким е-мэйл уже существует";
            } else if($_REQUEST["password"] != $_REQUEST["password_confirmation"]) {
                $error = !$error;
                $error_msg = "Пароли не совпадают";
            } else {
                create_new_simple_user(
                    $_REQUEST["email"],
                    $_REQUEST["password"]
                );

                $_SESSION["user_connected"] = true;
                header("Location: /");

            }
        } else {
            $error = !$error;
            $error_msg = "Заполните все поля";
        }
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
    <meta property="og:url" content="http://wikiwalker.ru/register.php"/>
    <meta property="og:image" content="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>
    <meta property="og:image:url" content="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>

    <meta name="title" content="WikiWalker - Пройди свой путь"/>
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <link rel="image_src" href="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>

    <title>WikiWalker - Создание учетной записи</title>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/wiki/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="/wiki/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/wiki/css/main.css">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="/wiki/css/cover.css" >
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand">WikiWalker</h3>
                    </div>
                </div>

                <div class="inner cover">
                      <div class="col-md-6 col-md-offset-3">
                        <form method="POST" action="register.php" id="registerform" accept-charset="UTF-8" role="form" class="form-signin">
                            <fieldset>
                                <h3 class="sign-up-title" style="color:#fff; text-align: center">Новый пользователь</h3>
                                <?php if($error) {
                                    echo <<<EOF
                                  <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span></button>
                                    <strong>Ошибка!</strong> $error_msg.
                                  </div>
EOF;
                                } ?>
                                <input class="form-control" placeholder="Е-мэйл" name="email" type="text">
                                <input class="form-control middle" placeholder="Пароль" name="password" type="password" value="">
                                <input class="form-control bottom" placeholder="Повторить пароль" name="password_confirmation" type="password" value="">
                                <input class="btn btn-lg btn-primary btn-block submit-button" type="submit" value="Регистрация">
                                <br>
                                <p class="text-center"><a href="login.php">Уже есть учетная запись?</a></p>
                            </fieldset>
                        </form>
                      </div>
                </div>

                <div class="mastfoot">
                    <div class="inner">
                        <p>Содержимое взято с сайта <a target="_blank" href="http://wikipedia.org/wiki/Main_Page">Wikipedia.org</a><br>
                            Поддержи проект! Вступай в группу
                            <a class='vklink' target="_blank" href="http://vk.com/wikiwalker">Вконтакте</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/wiki/js/jquery.min.js"></script>
<script src="/wiki/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="/wiki/js/ie10-viewport-bug-workaround.js"></script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter28976460 = new Ya.Metrika({id:28976460, trackLinks:true, accurateTrackBounce:true, trackHash:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/28976460" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
