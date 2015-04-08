<html lang="en">
<head>
    <meta charset="utf-8">
</head>

<body>
<?php

include_once("w/classes/DBHelper.php");
include_once("w/classes/PageResolver.php");
include_once("w/classes/Way.php");

session_start();
$_SESSION['lang'] = "ru";

$resolver = new PageResolver();

$ways = DBHelper::getAssoc("SELECT * FROM ways");

$file = file('1.txt');
foreach ($file as $line_num => $line) {
    $arr = explode(",", $line);
    echo DBHelper::update("UPDATE way_nodes SET link = 'http://ru.wikipedia.org/wiki/" . urlencode($arr[1]) . "' WHERE link = 'http://ru.wikipedia.org/wiki/" . urlencode($arr[1]) . "%0D%0A';");
    echo DBHelper::update("UPDATE way_nodes SET link = 'https://ru.wikipedia.org/wiki/" . urlencode($arr[1]) . "' WHERE link = 'https://ru.wikipedia.org/wiki/" . urlencode($arr[1]) . "%0D%0A';");
}
DBHelper::run("commit;");

?>
</body>
</html>