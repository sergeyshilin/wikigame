<?php
  session_start();

      $error = false;
      $error_msg = "";
      require_once('hybrid_connect.php');

      if( isset( $_REQUEST["email"] ) && isset( $_REQUEST["password"] ) ) {
        $user_exist = get_user_by_email_and_password( $_REQUEST["email"], md5($_REQUEST["password"]));
       
        if( $user_exist ) {
          $_SESSION["user_connected"] = true;
          header("Location: /");
        } else {
          $error = !$error;
          $error_msg = "Неверно указаны е-мэйл или пароль";
        }
      } elseif( isset( $_REQUEST["provider"] ) ) {

        $provider_name = $_REQUEST["provider"];
       
        try {
          // inlcude HybridAuth library
          $config   = 'hybrid/hybridauth/config.php';
          require_once( "hybrid/hybridauth/Hybrid/Auth.php" );
       
          $hybridauth = new Hybrid_Auth( $config );
          $adapter = $hybridauth->authenticate( $provider_name );
          $user_profile = $adapter->getUserProfile();
        } catch( Exception $e ) {
          echo $e;
          // header("Location: http://www.example.com/login-error.php");
        }
       
        // check if the current user already have authenticated using this provider before
        $user_exist = get_user_by_provider_and_id( $provider_name, $user_profile->identifier );
       
        // if the used didn't authenticate using the selected provider before
        // we create a new entry on database.users for him
        if( ! $user_exist ) {
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

  if (isset($_GET['game']) && !empty($_GET['game'])) {
      $game = $_GET['game'];
      $game = htmlspecialchars($game); // Escape HTML.
      require_once('w/classes/DBHelper.php');
      $game = DBHelper::escape($game); // Escape SQL.
      header('Location: /wiki/' . $game);
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
    <meta property="og:url" content="http://wikiwalker.ru/"/>
    <meta property="og:image" content="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>
    <meta property="og:image:url" content="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>

    <meta name="title" content="WikiWalker - Пройди свой путь"/>
    <meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов."/>
    <link rel="image_src" href="http://wikiwalker.ru/wiki/img/forsocials.jpg"/>

    <title>WikiWalker - Пройди свой путь</title>
    <!-- wikipedia, game, walk -->

    <link rel="icon" href="../../favicon.ico">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="/wiki/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/wiki/css/main.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      /*
      * Base structure
      */

      html,
      body {
        height: 100%;
        background: url('/wiki/img/background.jpg') no-repeat #333 center center;
      }

      body {
        color: #fff;
        text-shadow: 0 1px 3px rgba(0,0,0,.5);
      }

      .page-header {
        margin-top: 60px;
        border-bottom: 0px solid rgba(50, 50, 50, 0.4) !important;
      }

      .greating {
        text-align: center;
      }

      a, a:hover { 
        color: #fff;
      }

      .container {
        padding-top: 0 !important;
      }

      @media (min-width: 992px) {
      /* Pull out the header and footer */
      .mastfoot {
        position: fixed;
        bottom: 0;
        margin-bottom: 10px;
      }

      .greating {
        margin-top: 50px;
      }
      /* Start the vertical centering */
      .site-wrapper-inner {
        vertical-align: middle;
      }
      /* Handle the widths */
      .mastfoot {
        width: 100%; /* Must be percentage or pixels for horizontal alignment */
      }
    }

    @media (min-width: 992px) {
      .mastfoot  {
        width: 700px;
      }
    }
    </style>
</head>

<body>
    <div class="container">
      <div class="page-header">
        <div class="left-menu">
          <h2><img class="main_logo" src="logo/logo_white.svg" title="WikiWalker - найди свой путь"></h2>
        </div>
   <!--      <div class="right-menu">
          <?php if (!$_SESSION["user_connected"]) { ?>
          <h5 class="login-button"><a href="login.php">Вход / Регистрация</a></h5>
          <?php } else { ?>
          <h5 class="login-button"><a href="profile.php">Профиль</a></h5>
          <?php } ?>
        </div> -->
      </div>

      <div class="row">
        <div class="col-md-8 greating">
          <h1 class="cover-heading">Пройди свой путь.</h1>

          <p class="lead">Пройди путь от одной страницы Википедии до другой за минимальноe количество шагов.
              Думаешь, это просто? <br>Попробуй сыграть прямо сейчас!</p>

          <p class="lead">
              <button type="button" class="btn btn-lg btn-success" data-toggle="modal" data-target="#cats"
                      onclick="yaCounter28976460.reachGoal('playgame')">Играть</button>
          </p>
        </div>
        <div class="col-md-4">
          <?php if(!$_SESSION["user_connected"]) { ?>
            <form method="POST" action="" accept-charset="UTF-8" role="form" id="loginform" class="form-signin">
              <fieldset>
                  <h3 class="sign-up-title" style="color:#fff; text-align: center">Авторизация</h3>
                      <?php 
                        if ($error) {
                          echo <<<EOF
                      <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                        <strong>Ошибка!</strong> $error_msg.
                      </div>
EOF;
                      } ?>
                  <input class="form-control login-email" placeholder="Е-мейл" name="email" type="text" value="<?php echo $_SESSION["user_connected"] ?>">
                  <input class="form-control login-password" placeholder="Пароль" name="password" type="password" value="">
                  <a class="pull-right" href="password.php">Забыли пароль?</a>
                <div class="checkbox" style="width:140px;">
                    <label><input name="remember" type="checkbox" value="Remember Me"> Запомнить меня</label>
                  </div>
                  <div class="row" id="loginsoc">
                    <div class="col-md-3">
                      <input class="btn btn-success btn-block" type="submit" value="Войти">
                    </div>
                  </div>
                  <p class="text-center">ИЛИ ВОЙТИ ЧЕРЕЗ</p>
                    <div class="row socials">
                      <div class="col-md-2">
                      </div>
                      <div class="col-md-2 soclogin">
                        <a class="btn btn-primary btn-block" href="login.php?provider=Vkontakte">
                          <i class="fa fa-vk"></i></a>
                      </div>
                      <div class="col-md-2 soclogin">
                        <a class="btn btn-primary btn-block" href="login.php?provider=Facebook">
                          <i class="fa fa-facebook"></i></a>
                      </div>
                      <div class="col-md-2 soclogin">
                        <a class="btn btn-info btn-block" href="login.php?provider=Twitter">
                          <i class="fa fa-twitter"></i></a>
                      </div>
                      <div class="col-md-2 soclogin">
                        <a class="btn btn-danger btn-block" href="login.php?provider=google">
                          <i class="fa fa-google-plus"></i></a>
                      </div>
                      <div class="col-md-2">
                      </div>
                    </div>
                  <br>
                  <p class="text-center"><a href="register.php">У вас еще нет учетной записи?</a></p>
                </fieldset>
              </form>  
            <?php } else { ?>
            <p class="text-center"><h3>Вы вошли! Здесь могла бы быть ваша реклама</h3></p>          
            <?php } ?>
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

<!-- Modal Categories-->
<div class="modal fade" id="cats" tabindex="-1" role="dialog" aria-labelledby="categories" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="categories">Категория</h4>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <a href="/wiki/Main_Page" class="list-group-item active" onclick="yaCounter28976460.reachGoal('cat0'); return true;">
                        <h4 class="list-group-item-heading">Случайный</h4>
                        <p class="list-group-item-text">Будет выбран случайный маршрут</p>
                    </a>
                    <?php

                    require_once('w/classes/WayUtils.php');
                    $utils = new WayUtils();
                    $cats = $utils->getCategories();

                    foreach ($cats as $cat) {
                        echo "<a href='/wiki/Main_Page?cat=" . $cat["id"] . "' class='list-group-item' onclick='yaCounter28976460.reachGoal(\"cat" . $cat["id"] . "\"); return true;'>";
                        echo "<h4 class='list-group-item-heading'>" . $cat["name"] . "</h4>";
                        echo "<p class='list-group-item-text'>" . $cat["description"] . "</p>";
                        echo "</a>";
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/w/js/jquery.min.js"></script>
<script src="/w/js/bootstrap.min.js"></script>
<script src="/w/js/ie10-viewport-bug-workaround.js"></script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter28976460 = new Ya.Metrika({id:28976460, trackLinks:true, accurateTrackBounce:true, trackHash:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/28976460" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
