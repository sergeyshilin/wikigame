<?php
	session_start();

	if(isset($_GET['page']) && !empty($_GET['page'])) {
		require_once('DBHelper.php');
		require_once('WayParser.php');

		$cat = 0;

		$page = $_GET['page'];
        $page = htmlspecialchars($page); // Escape HTML.
        $page = DBHelper::escape($page); // Escape SQL.

        if(isset($_GET["cat"]) && !empty($_GET["cat"])) {
        	$cat = $_GET["cat"];
        	$cat = htmlspecialchars($cat); // Escape HTML.
	        $cat = DBHelper::escape($cat); // Escape SQL.
        }

		if(WayParser::isMD5Hash($page)) {
			$way = WayParser::getWayByHash($page);
			if(!empty($way)) {
				$_SESSION['end'] = Way::getName($way->getEndPoint());
				$_SESSION['start'] = Way::getName($way->getStartPoint());
				$_SESSION['startlink'] = $way->getStartPoint();
				$_SESSION['endlink'] = $way->getEndPoint();
				$_SESSION['win'] = false;
				$_SESSION['lang'] = $way->getLang();
				$_SESSION['hash'] = $way->getHash();
				header('Location: '.$_SESSION["start"]);
			} else {
				header('Location: /');
			}
		}


		if(empty($_SESSION['start']) || empty($_SESSION['end']) || $page == "Main_Page") {
			$way = WayParser::getRandomWay($cat);
			$_SESSION['cat'] = $cat;
			$_SESSION['end'] = Way::getName($way->getEndPoint());
			$_SESSION['start'] = Way::getName($way->getStartPoint());
			$_SESSION['startlink'] = $way->getStartPoint();
			$_SESSION['endlink'] = $way->getEndPoint();
			$_SESSION['win'] = false;
			$_SESSION['lang'] = $way->getLang();
			$_SESSION['hash'] = $way->getHash();
			header('Location: '.$_SESSION["start"]);
		}

		$_SESSION['previous'] = $_SESSION['current'];
		$_SESSION['current'] = $page;
		if ($_SESSION['current'] != $_SESSION['previous'] && !$_SESSION['win'])
			$_SESSION['counter'] += 1;
		if ($_SESSION['current'] == $_SESSION['start']) {
			$_SESSION['counter'] = 0;
			$_SESSION['previous'] = "";
            $_SESSION['current'] = $page;
		}
		if($_SESSION['current'] == $_SESSION['end'] && !empty($_SERVER['HTTP_REFERER'])) {
			$_SESSION['win'] = true;
		} else if($_SESSION['current'] == $_SESSION['end'] && empty($_SERVER['HTTP_REFERER'])) {
			$_SESSION['counter'] = 0;
			header('Location: '.$_SESSION["start"]);
		}

	} else {
		session_unset();
		session_destroy();
		header('Location: /');
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<!-- made by www.metatags.org -->
	<meta name="description" content="Пройди путь от одной страницы Википедии до другой за минимальное количество шагов." />
    <meta name="keywords" content="википедия, вики, игра, интерактив, развлечение, образование, ссылка, переход, клик" />
    <meta name="author" content="Sergey Shilin & Dmitriy Verbitskiy">
    <meta name="robots" content="index, nofollow">
    <meta name="revisit-after" content="3 days">
    <meta property="og:image" content="http://wikiwalker.ru/assets/img/forsocials.jpg" />
    <meta property="og:title" content="WikiWalker - Пройди свой путь" />
    <?php 
    	if($_SESSION['win']) {
    		echo '<meta property="og:url" content="http://wikiwalker.ru/'.$_SESSION["hash"].'" />';
    		echo '<meta property="og:description" content="
    			Congrats! You have completed your way from '.str_replace("_", " ", $_SESSION["start"]).' 
				to '.str_replace("_", " ", $_SESSION["end"]).' with '.$_SESSION["counter"].' steps. 
    		" />';
    	}
    ?>
    <title>WikiWalker - Пройди свой путь</title>
    <!-- wikipedia, game, walk -->
	
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="image_src" href="http://wikiwalker.ru/assets/img/forsocials.jpg" />
	<script type="text/javascript" language="JavaScript" src="js/jquery.min.js"></script>
	<script src="js/main.js" type="text/javascript"></script>
</head>
<body>
	
		<?php 
			if(!$_SESSION['win'])
				echo "
				<div id='page_header'>
					<p class='text'>Ваша цель: <a href='".$_SESSION['endlink']."' target='_blank'>". str_replace("_", " ", $_SESSION['end']). "</a></p>
					<p class='text'>&nbsp;&nbsp;Количество шагов: ".$_SESSION['counter']."</p>
					<p class='text right'>
						<span class='label startpage_button label-danger'><a href='/wiki/".$_SESSION['start']."'>Начать заново</a></span>
						<span class='label newgame_button label-success'><a href='/wiki/Main_Page?cat=".$_SESSION["cat"]."'>Новая игра</a></span>
					</p>
				</div>";
		?>
	<?php 
		include_once('simple_html_dom.php');
 
		if(!$_SESSION['win']) {
			$url = "https://".$_SESSION['lang'].".wikipedia.org/wiki/".$page;
			$html = file_get_html($url);
			foreach($html->find('link') as $element) { //выборка всех тегов img на странице
			       echo $element; // построчный вывод содержания всех найденных атрибутов src
			}
			foreach($html->find('script') as $element) { //выборка всех тегов img на странице
			       echo $element; // построчный вывод содержания всех найденных атрибутов src
			}

			foreach ($html->find('span.mw-editsection') as $element) {
		        $element->outertext = '';
		    }

			$html->find('div[id=content]', 0)->class = 'mw-body zeromargin';
			$content = $html->find('div[id=content]', 0);
			// $content = str_replace($editsection, "", $content);	
			echo $content;
		} else {
			$count = $_SESSION['counter'];
			$hash = $_SESSION['hash'];
			$url = "http://wikiwalker.ru/".$hash;
			$title = "WikiWalker - Пройди свой путь!";
			$desc = "Поздравляем! Вы прошли от страницы ".str_replace("_", " ", $_SESSION["start"])." 
			до страницы ".str_replace("_", " ", $_SESSION["end"]).". Количество шагов: ".$_SESSION["counter"].". ";
			$img = "http://wikiwalker.ru/assets/img/forsocials.jpg";
			echo <<<EOF
			    <link href="css/bootstrap.min.css" rel="stylesheet">

			    <!-- Custom styles for this template -->
			    <link href="css/cover.css" rel="stylesheet">
			    <script src="assets/js/ie-emulation-modes-warning.js"></script>
			    <script type="text/javascript" src="assets/share42/share42.js"></script>
			    <script type="text/javascript">
			    	window.history.pushState("", "Title", "/?game=$hash");
			    </script>

				<div class="site-wrapper">

			      <div class="site-wrapper-inner">

			        <div class="cover-container">

			          <div class="masthead clearfix">
			            <div class="inner">
			              <h3 class="masthead-brand">WikiWalker</h3>
			              <!-- <nav>
			                <ul class="nav masthead-nav">
			                  <li class="active"><a href="#">Home</a></li>
			                  <li><a href="#">Features</a></li>
			                  <li><a href="#">Contact</a></li>
			                </ul>
			              </nav> -->
			            </div>
			          </div>

			          <div class="inner cover">
			            <h1 class="cover-heading">Поздравляем!</h1>
			            <p class="lead">
			            	Вы завершили свой маршрут! Количество переходов: <span class="label label-danger">$count</span> 
			            	Понравилось? <br>Поделись результатом с друзьями!
			            	<div class="share42init" data-description="$desc" data-image="$img" data-url="$url" data-title="$title"></div>
			            <p class="lead">
			              <a href="/wiki/Main_Page" class="btn btn-lg btn-success congrats_playagain">Играть снова</a>
			            </p>
			          </div>

			          <div class="mastfoot">
			            <div class="inner">
			              <p>Содержимое взято с сайта <a href="http://wikipedia.org/wiki/Main_Page">Wikipedia.org</a></br>
			              Поддержи проект! Вступай в группу <a class='vklink' target="_blank" href="http://vk.com/wikiwalker">Вконтакте</a>
			                <!-- , by <a href="http://vk.com/true_pk">true_pk</a> <a href="http://vk.com/id210883700">dimas</a> -->
			              .</p>
			            </div>
			          </div>

			        </div>

			      </div>

			    </div>

			    <!-- Bootstrap core JavaScript
			    ================================================== -->
			    <!-- Placed at the end of the document so the pages load faster -->
			    <script src="js/jquery.min.js"></script>
			    <script src="js/bootstrap.min.js"></script>
			    <script src="assets/js/docs.min.js"></script>
			    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
			    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>

EOF;
			// "
			// 	<div id='content' class='mw-body zeromargin'>
			// 	<h2 class='win'>You win! Your score is". $_SESSION['counter']." points</h2>
			// 	<h2><a href='wiki/".$_SESSION['start']."'>Play another game?</a></h2></div>
			// ";
		}
	?>	    
</body>
</html>
