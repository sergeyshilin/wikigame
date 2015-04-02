<?php
if (isset($_GET['game']) && !empty($_GET['game'])) {
    $game = $_GET['game'];
    $game = htmlspecialchars($game); // Escape HTML.
    require_once('wikigame/DBHelper.php');
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

    <!-- Custom styles for this template -->
    <link href="/wiki/css/cover.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="bootstrap-scope">
<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">
            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand">WikiWalker</h3>
                    <h5 class="login-button"><a href="#signup" data-toggle="modal" data-target=".bs-modal-sm">Вход / Регистрация</a></h5>
                </div>
            </div>

            <div class="inner cover">
                <h1 class="cover-heading">Пройди свой путь.</h1>

                <p class="lead">Пройди путь от одной страницы Википедии до другой за минимальноe количество шагов.
                    Думаешь, это просто? <br>Попробуй сыграть прямо сейчас!</p>

                <p class="lead">
                    <button type="button" class="btn btn-lg btn-success" data-toggle="modal" data-target="#cats"
                            onclick="yaCounter28976460.reachGoal('playgame')">Играть</button>
                </p>
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

                    require_once('wikigame/WayUtils.php');
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


<!-- Modal Sign-in/Sign-up -->
<div class="modal fade bs-modal-sm" id="signinup-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <br>
        <div class="bs-example bs-example-tabs">
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#signin" data-toggle="tab">Sign In</a></li>
              <li class=""><a href="#signup" data-toggle="tab">Register</a></li>
              <li class=""><a href="#why" data-toggle="tab">Why?</a></li>
            </ul>
        </div>
        <div class="modal-body">
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in" id="why">
                    <p>We need this information so that you can receive access to the site and its content. Rest assured your information will not be sold, traded, or given to anyone.</p>
                    <p></p><br> Please contact <a mailto:href="JoeSixPack@Sixpacksrus.com"></a>JoeSixPack@Sixpacksrus.com</a> for any other inquiries.</p>
                </div>
                <div class="tab-pane fade active in" id="signin">
                    <form class="form-horizontal">
                    <fieldset>
                    <!-- Sign In Form -->
                    <!-- Text input-->
                    <div class="control-group">
                      <label class="control-label" for="userid">Alias:</label>
                      <div class="controls">
                        <input required="" id="userid" name="userid" type="text" class="form-control" placeholder="JoeSixpack" class="input-medium" required="">
                      </div>
                    </div>

                    <!-- Password input-->
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">Password:</label>
                      <div class="controls">
                        <input required="" id="passwordinput" name="passwordinput" class="form-control" type="password" placeholder="********" class="input-medium">
                      </div>
                    </div>

                    <!-- Multiple Checkboxes (inline) -->
                    <div class="control-group">
                      <label class="control-label" for="rememberme"></label>
                      <div class="controls">
                        <label class="checkbox inline" for="rememberme-0">
                          <input type="checkbox" name="rememberme" id="rememberme-0" value="Remember me">
                          Remember me
                        </label>
                      </div>
                    </div>

                    <!-- Button -->
                    <div class="control-group">
                      <label class="control-label" for="signin"></label>
                      <div class="controls">
                        <button id="signin" name="signin" class="btn btn-success">Sign In</button>
                      </div>
                    </div>
                    </fieldset>
                    </form>
                </div>
                <div class="tab-pane fade" id="signup">
                    <form class="form-horizontal">
                    <fieldset>
                    <!-- Sign Up Form -->
                    <!-- Text input-->
                    <div class="control-group">
                      <label class="control-label" for="Email">Email:</label>
                      <div class="controls">
                        <input id="Email" name="Email" class="form-control" type="text" placeholder="JoeSixpack@sixpacksrus.com" class="input-large" required="">
                      </div>
                    </div>
                    
                    <!-- Text input-->
                    <div class="control-group">
                      <label class="control-label" for="userid">Alias:</label>
                      <div class="controls">
                        <input id="userid" name="userid" class="form-control" type="text" placeholder="JoeSixpack" class="input-large" required="">
                      </div>
                    </div>
                    
                    <!-- Password input-->
                    <div class="control-group">
                      <label class="control-label" for="password">Password:</label>
                      <div class="controls">
                        <input id="password" name="password" class="form-control" type="password" placeholder="********" class="input-large" required="">
                        <em>1-8 Characters</em>
                      </div>
                    </div>
                    
                    <!-- Multiple Radios (inline) -->
                    <br>
                    <div class="control-group">
                      <label class="control-label" for="humancheck">Humanity Check:</label>
                      <div class="controls">
                        <label class="radio inline" for="humancheck-0">
                          <input type="radio" name="humancheck" id="humancheck-0" value="robot" checked="checked">I'm a Robot</label>
                        <label class="radio inline" for="humancheck-1">
                          <input type="radio" name="humancheck" id="humancheck-1" value="human">I'm Human</label>
                      </div>
                    </div>
                    
                    <!-- Button -->
                    <div class="control-group">
                      <label class="control-label" for="confirmsignup"></label>
                      <div class="controls">
                        <button id="confirmsignup" name="confirmsignup" class="btn btn-success">Sign Up</button>
                      </div>
                    </div>
                    </fieldset>
                    </form>
                </div>
            </div>
        </div>
      <div class="modal-footer">
        <center>
            <button id="cancel-button" name="cancelbut" class="btn btn-default" data-dismiss="modal">Close</button>
        </center>
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
