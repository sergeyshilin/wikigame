
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header pull-left">
            <a class="navbar-brand" href="/">
                <img class="header_logo" src="/application/images/logo/logo_white.svg" title="WikiWalker - найди свой путь">
            </a>
        </div>
        <div class="navbar-header pull-right">
            <?php if (!$loggedIn) {?>
                    <a href="/login/register" class="btn btn-primary btn-join">Зарегистрироваться</a>
                    <a href="/login" class="btn btn-default btn-white">Войти</a>
            <?php } else {?>
                <a href="/account" class="btn btn-default btn-info"><span class="glyphicon glyphicon-user"></span>&nbspМой аккаунт</a>
                <a href="/login/exit" class="btn btn-default btn-white">Выйти</a>
            <?php } ?>
        </div>
    </div>
</nav>