<!Doctype html>
<html>
<head>
	<meta charset="utf-8">
    <title>Электронная столовая - администратор</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/canteen/application/css/bootstrap-datepicker3.min.css">
  <script src="/canteen/application/js/bootstrap-datepicker.min.js"></script>
  <script src="/canteen/application/js/bootstrap-datepicker.ru.min.js"></script>
  <link rel="stylesheet" type="text/css" href="http://getbootstrap.com/examples/signin/signin.css">
  <link href="http://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic"
rel="stylesheet" type="text/css" />
<style>
.price {
  font-family: 'PT Sans', serif;
  }
</style>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand">Контрольная панель столовой</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/canteen/admin/dishes_control">Блюда</a></li>
            <li><a href="/canteen/admin/menus">Меню</a></li>
            <li><a href="/canteen/admin/users">Пользователи</a></li>
            <li><a href="/canteen/admin/orders">Заказы</a></li>
            <li><?php if(isset($_SESSION["admin"])) { ?><a href="/canteen/admin/logout">Выйти</a> <?php }?></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<div class="container"><!-- <link href="application/css/mainstyle.css" rel="stylesheet"> -->
    
	<?php /*!!!*/include 'application/views/'.$content_view; ?>
</div>
</body>
</html>