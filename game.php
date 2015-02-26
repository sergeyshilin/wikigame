<?php
	session_start();

	$page = "";
	$_SESSION['end'] = "Bishop_of_Tasmania";
	$_SESSION['start'] = "Alan_Turing";
	$_SESSION['win'] = false;

	if(isset($_GET['page']) && !empty($_GET['page'])) {
		$page = $_GET['page'];
		$_SESSION['previous'] = $_SESSION['current'];
		$_SESSION['current'] = $page;
		if ($_SESSION['current'] != $_SESSION['previous'])
			$_SESSION['counter'] += 1;
		if ($_SESSION['current'] == $_SESSION['start']) {
			$_SESSION['counter'] = 0;
			$_SESSION['previous'] = "";
            $_SESSION['current'] = $page;
		}
		if($_SESSION['current'] == $_SESSION['end'])
			$_SESSION['win'] = true;
	} else {
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Wikipedia Game</title>
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" language="JavaScript" src="js/jquery.min.js"></script>
	<script src="js/main.js" type="text/javascript"></script>
</head>
<body>
	<div id="page_header">
		<?php 
				echo "<p class='text counter'>Steps: <span class='label label-danger'>".$_SESSION['counter']."</span></p>
				<p class='text'>Target: <a href='http://en.wikipedia.org/wiki/".$_SESSION['end']."' target='_blank'>". str_replace("_", " ", $_SESSION['end']). "</a></p>
				<p class='text'><span class='label startpage_button label-danger'><a href='/wiki/Alan_Turing'>To start page</a></span></p>";
		?>
	</div>
	<?php 
		include_once('simple_html_dom.php');
 
		if(!$_SESSION['win']) {
			$url = "http://en.wikipedia.org/wiki/".$page;
			$html = file_get_html($url);
			// $html = file_get_html('http://en.wikipedia.org/wiki/Alan_Turing');
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
		} else {
			echo "<h1>Вы выиграли! Ваш счет ". $_SESSION['counter']." очков</h1><br>";
			echo "<h2><a href='/wiki/Alan_Turing'>Начать сначала?</a></h2>";
		}
	?>	    
</body>
</html>