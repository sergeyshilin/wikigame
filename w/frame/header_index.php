<?php
    $loggedIn = isset($_SESSION['user_connected']) && $_SESSION['user_connected'] === true;
?>

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header pull-left">
            <a class="navbar-brand" href="/">
                <img class="header_logo" src="logo/logo_white.svg" title="WikiWalker - найди свой путь">
            </a>
        </div>
        <div class="navbar-header pull-right">
            <?php if (!$loggedIn) {
                echo '<a href="join.php" class="btn btn-primary btn-join">Зарегистрироваться</a>
                    <a href="login.php" class="btn btn-default btn-signin">Войти</a>';
            } else {
                echo '<a href="/wiki/" class="btn btn-default btn-signin">Выйти</a>';
            }
            ?>

        </div>
    </div>
</nav>