<body>
<div class="wrapper">
    <?php
    include_once('topbar_frame.php');
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <form method="POST" action="/login/register" id="registerform" accept-charset="UTF-8" role="form" class="form-signin">
                    <fieldset>
                        <h3 class="sign-up-title" style="color:#fff; text-align: center">Зарегистрироваться</h3>
                        <?php if (isset($data) && $data) {
                            echo <<<EOF
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <strong>Ошибка!</strong> $info.
        </div>
EOF;
                        } ?>
                        <input class="form-control" placeholder="Email" name="email" type="text" required>
                        <input class="form-control" placeholder="Пароль" name="password" type="password" value="" required>
                        <input class="form-control" placeholder="Повторить пароль" name="password_confirmation" type="password" value="" required>
                        <button class="btn btn-lg btn-primary btn-block submit-button" type="submit">Регистрация</button>

                        <h5 class="sign-up-title" style="color:#fff; text-align: center">Или войти через:</h5>

                        <div class="row socials">
                            <div class="col-xs-4 soclogin">
                                <a class="btn btn-primary btn-block" href="/login/provider/Vkontakte">
                                    <i class="fa fa-vk"></i></a>
                            </div>
                            <div class="col-xs-4 soclogin">
                                <a class="btn btn-primary btn-block" href="/login/provider/Facebook" disabled>
                                    <i class="fa fa-facebook"></i></a>
                            </div>
                            <div class="col-xs-4 soclogin">
                                <a class="btn btn-danger btn-block" href="/login/provider/google" disabled>
                                    <i class="fa fa-google-plus"></i></a>
                            </div>
                        </div>
                    </fieldset>
                </form>
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

<script src="/application/js/jquery.min.js"></script>
<script src="/application/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="/application/js/ie10-viewport-bug-workaround.js"></script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter28976460 = new Ya.Metrika({id:28976460, trackLinks:true, accurateTrackBounce:true, trackHash:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/28976460" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
