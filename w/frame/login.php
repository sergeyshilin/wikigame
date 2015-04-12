<form method="POST" action="login.php" accept-charset="UTF-8" role="form" id="loginform" class="form-signin">
    <fieldset>
        <h3 class="sign-up-title" style="color:#fff; text-align: center">Авторизация</h3>
        <?php if (isset($error) && $error) {
            echo <<<EOF
                      <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                        <strong>Ошибка!</strong> $error_msg.
                      </div>
EOF;
        } ?>
        <input class="form-control login-email" placeholder="Email" name="email" type="text" value="<?php if (isset($_SESSION['user_connected'])) echo $_SESSION["user_connected"] ?>">
        <input class="form-control login-password" placeholder="Пароль" name="password" type="password" value="">

        <div class="row">
            <div class="pull-left" style="width:140px;">
                <label><input name="remember" type="checkbox" value="Remember Me">Запомнить меня</label>
            </div>
            <a class="pull-right" href="password.php">Забыли пароль?</a>
        </div>
        <button class="btn btn-success btn-block" type="submit">Войти</button>
    </fieldset>
</form>