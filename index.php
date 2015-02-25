<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Wikipedia Game</title>
	<style type="text/css">
		body, html {
			margin: 0;
			padding: 0;
			width: 100%;
			height: 100%;
			border: 0;
		}

		.zeromargin {
			margin: 0 !important;
			border: 0 !important;
		}
	</style>
	<script type="text/javascript" language="JavaScript" src="js/jquery.min.js"></script>
	<script src="js/main.js" type="text/javascript"></script>
</head>
<body>
	<?php 
		include_once('simple_html_dom.php');

		$html = file_get_html('http://en.wikipedia.org/wiki/Alan_Turing');
		foreach($html->find('link') as $element) { //выборка всех тегов img на странице
		       echo $element; // построчный вывод содержания всех найденных атрибутов src
		}
		foreach($html->find('script') as $element) { //выборка всех тегов img на странице
		       echo $element; // построчный вывод содержания всех найденных атрибутов src
		}

		//$html->find('div[id=mw-page-base]', 0)->class = 'hidden';
		$html->find('div[id=content]', 0)->class = 'mw-body zeromargin';
		$content = $html->find('div[id=content]', 0);
		echo $content;
	?>	
</body>
</html>