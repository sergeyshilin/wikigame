<?php
	session_start();

	if(isset($_GET['page']) && !empty($_GET['page'])) {
		if(empty($_SESSION['start']) || empty($_SESSION['end']) || $_GET['page'] == "Main_Page") {
			require_once('WayParser.php'); 
			$way = (new WayParser())->getRandomWay();
			$_SESSION['end'] = $way->getEndPoint();
			$_SESSION['start'] = $way->getStartPoint();
			$_SESSION['win'] = false;
			header('Location: '.$_SESSION["start"]);
		}

		$page = $_GET['page'];
		$_SESSION['previous'] = $_SESSION['current'];
		$_SESSION['current'] = $page;
		if ($_SESSION['current'] != $_SESSION['previous'] && !$_SESSION['win'])
			$_SESSION['counter'] += 1;
		if ($_SESSION['current'] == $_SESSION['start']) {
			$_SESSION['counter'] = 0;
			$_SESSION['previous'] = "";
            $_SESSION['current'] = $page;
		}
		if($_SESSION['current'] == $_SESSION['end']) {
			$_SESSION['win'] = true;
			// unset($_SESSION['start']);
			// unset($_SESSION['end']);
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
	<title>Wikipedia Game</title>
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" language="JavaScript" src="js/jquery.min.js"></script>
	<script src="js/main.js" type="text/javascript"></script>
</head>
<body>
	
		<?php 
			if(!$_SESSION['win'])
				echo "
				<div id='page_header'>
				<p class='text counter'>Steps: <span class='label label-danger'>".$_SESSION['counter']."</span></p>
				<p class='text'>Target: <a href='http://en.wikipedia.org/wiki/".$_SESSION['end']."' target='_blank'>". str_replace("_", " ", rawurldecode($_SESSION['end'])). "</a></p>
				<p class='text'><span class='label startpage_button label-danger'><a href='/wiki/".$_SESSION['start']."'>To start page</a></span></p>
				</div>";
		?>
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
			$count = $_SESSION['counter'];
			echo <<<EOF
			    <link href="css/bootstrap.min.css" rel="stylesheet">

			    <!-- Custom styles for this template -->
			    <link href="css/cover.css" rel="stylesheet">
			    <script src="assets/js/ie-emulation-modes-warning.js"></script>
			    <script type="text/javascript" src="assets/share42/share42.js"></script>

				<div class="site-wrapper">

			      <div class="site-wrapper-inner">

			        <div class="cover-container">

			          <div class="masthead clearfix">
			            <div class="inner">
			              <h3 class="masthead-brand">WikiGame</h3>
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
			            <h1 class="cover-heading">Congratulations!</h1>
			            <p class="lead">
			            	You have completed your way with <span class="label label-danger">$count</span> points. 
			            	Like it? <br>Share your result with your friends!
			            	<div class="share42init"></div>
			            <p class="lead">
			              <a href="/wiki/Main_Page" class="btn btn-lg btn-success congrats_playagain">Play again</a>
			            </p>
			          </div>

			          <div class="mastfoot">
			            <div class="inner">
			              <p>Content has taken from  <a href="http://en.wikipedia.org/wiki/Main_Page">en.Wikipedia.org</a>
			                <!-- , by <a href="http://vk.com/true_pk">true_pk</a> -->
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
