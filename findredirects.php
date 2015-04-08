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

$counter = 0;
foreach ($ways as $way) {
    $way = new Way($way["id"], $way["depth"], $way["links"]);
    $endLink = Way::getName($way->getEndPoint());
    $obj = $resolver->getContentFromApi($endLink);
    $title = $obj["title"];
    $content = $obj["content"];
    if ($resolver->isRedirect($content)) {
        $counter++;
        $redirect = $resolver->extractRedirectPageName($content);
        echo $endLink . "," . $redirect . "</br>";
    }
}

echo "Count: " . $counter;
?>
</body>
</html>