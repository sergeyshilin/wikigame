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
                echo '<a id="signup" href="join.php" class="btn btn-success">Зарегистрироваться</a>
                    <a href="login.php" class="btn btn-default">Войти</a>';
            } else {
                echo '<a id="signup" href="/wiki/" class="btn btn-default">Выйти</a>';
            }
            ?>

        </div>
    </div>
</nav>