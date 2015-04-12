<form method="POST" action="join.php" id="registerform" accept-charset="UTF-8" role="form" class="form-signin">
    <fieldset>
        <h4 class="sign-up-title" style="color:#fff; text-align: center">Зарегистрироваться</h4>
        <?php if (isset($error) && $error) {
            echo <<<EOF
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <strong>Ошибка!</strong> $error_msg.
        </div>
EOF;
        } ?>
        <input class="form-control" placeholder="Email" name="email" type="text">
        <input class="form-control" placeholder="Пароль" name="password" type="password" value="">
        <input class="form-control" placeholder="Повторить пароль" name="password_confirmation" type="password" value="">
        <button class="btn btn-lg btn-primary btn-block submit-button" type="submit">Регистрация</button>

        <h4 class="sign-up-title" style="color:#fff; text-align: center">Или войти через:</h4>

        <div class="row socials">
            <div class="col-xs-4 soclogin">
                <a class="btn btn-primary btn-block" href="index.php?provider=Vkontakte">
                    <i class="fa fa-vk"></i></a>
            </div>
            <div class="col-xs-4 soclogin">
                <a class="btn btn-primary btn-block" href="index.php?provider=Facebook">
                    <i class="fa fa-facebook"></i></a>
            </div>
            <div class="col-xs-4 soclogin">
                <a class="btn btn-danger btn-block" href="index.php?provider=google">
                    <i class="fa fa-google-plus"></i></a>
            </div>
        </div>
    </fieldset>
</form>