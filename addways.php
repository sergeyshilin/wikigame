<?php
header('Content-Type: text/html; charset=utf-8');
//include 'authorize.php';
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WikiWalker - Добавление маршрутов</title>
    <link href="/w/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">WikiWalker</a>
        </div>
    </div>
</nav>
<div class="container">
    <h1>Добавление категории</h1>
    <?php
    if (isset($_POST['add_category']) && isset($_POST['newCategoryName']) && isset($_POST['newCategoryDescription'])) {
        require_once('w/classes/WayUtils.php');
        $utils = new WayUtils();
        $id = $utils->addCategory($_POST['newCategoryName'], $_POST['newCategoryDescription']);
        if ($id != null) {
            echo <<<END
    <div class="alert alert-info" role="alert">
      <span class="sr-only">Info:</span>
      Категория добавлена с id $id
    </div>
END;
        } else {
            echo <<<END
    <div class="alert alert-danger" role="alert">
      <span class="sr-only">Error:</span>
      Категория не была добавлена
    </div>
END;
        }
    }
    ?>
    <form class="form-inline" action="addways.php" method="post">
        <input class="form-control" placeholder="Имя новой категории" type="text" name="newCategoryName" required>
        <input class="form-control" placeholder="Описание" type="text" name="newCategoryDescription" required>
        <button name="add_category" type="submit" class="btn btn-default">Создать</button>
    </form>


    <h1>Добавление маршрутов</h1>
    <?php
    if (isset($_POST['add_ways']) && $_FILES["fileToUpload"] && isset($_POST['category'])) {
        require_once('w/classes/WayParser.php');
        $parser = new WayParser($_FILES["fileToUpload"]["tmp_name"]);
        $parser->setLang('ru');
        try {
            $hashes = $parser->writeWays($_POST['category']);
            echo '<div class="alert alert-info" role="alert"><span class="sr-only">Info:</span>Новые пути добавлены:<br>';
            foreach($hashes as $hash) {
                echo 'wikiwalker.ru/' . $hash . '<br>';
            }
            echo '</div>';
        } catch (Exception $e) {
            $msg = $e->getMessage();
            echo <<<END
    <div class="alert alert-danger" role="alert">
      <span class="sr-only">Error:</span>
      Маршруты не были добавлены<br>
      $msg
    </div>
END;
        }
    }
    ?>
    <form class="form-inline" action="addways.php" method="post" enctype="multipart/form-data">
        <select class="form-control" name="category" required>
            <?php
            require_once('w/classes/WayUtils.php');
            $utils = new WayUtils();
            $cats = $utils->getCategories();
            foreach ($cats as $cat) {
                echo "<option value='" . $cat["id"] . "'>" . $cat["name"] . "</option>";
            }
            ?>
        </select>
        <input class="form-control" type="file" name="fileToUpload" required>
        <button name="add_ways" type="submit" class="btn btn-default">Отправить</button>
    </form>
</div>
</body>
</html>