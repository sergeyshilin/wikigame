<?php
class Route{
	static function start(){
		$controller_name = "Main";
		$action_name = 'index';
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		// print_r($routes);	
		//ПОЛУЧАЕМ ИМЯ КОНТРОЛЛЕРА

		if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done'])) {
			require 'application/vendor/hybridauth/config.php';
			$config = HybridConfig::getProviders();
			require_once( "application/vendor/hybridauth/Hybrid/Auth.php" );
			require_once( "application/vendor/hybridauth/Hybrid/Endpoint.php" );
			Hybrid_Endpoint::process();
		}
		 if(!empty($routes[1])){
			$controller_name = $routes[1];
		 }
		//ПОЛУЧАЕМ ИМЯ ДЕЙСТВИЯ-ЭКШЕНА
		// if(!empty($routes[3])){
		// 	$action_name= $routes[3];
		// }
		 $action_param = null;
		// if(!empty($routes[4])){
		// 	$action_param= $routes[4];
		// }
		$action_data = null;
		 if(!empty($routes[3])){
		 	$action_data= $routes[3];
		 }
		if(isset($routes[2]) && isset($routes[4])) {
			if($routes[2] == "title"){ $title = $routes[3];}
			if($routes[4] == "cat") { $cat  = $routes[5]; }
		}
		else if(isset($routes[2])) { $title = $routes[2]; }
		// echo $_SERVER['REQUEST_URI'];
		//ПРОЦЕСС ДОБАВЛЕНИЯ ПРЕФИКСОВ
		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;
		// echo $controller_name; echo $action_param;
		//ТЕПЕРЬ ПОДКЛЮЧАЕМ ФАЙЛЫ-КЛАССЫ: МОДЕЛЬ-КОНТРОЛЛЕР
		//СНАЧАЛА МОДЕЛЬ
		$model_file = strtolower($model_name).'.php';
		
		$model_path = "application/models/".$model_file;
		if(file_exists($model_path)){
			include "application/models/".$model_file;
		}
		//ПОТОМ КОНТРОЛЛЕР
		$controller_file = strtolower($controller_name).'.php';
		
		$controller_path = "application/controllers/".$controller_file;

		if(file_exists($controller_path)){
			include "application/controllers/".$controller_file;
		}
		// echo "application/controllers/".$controller_file;
		//ЕСЛИ ЗАПРОС ЮЗЕРА ОКАЗАЛСЯ НЕВЕРНЫМ - ВЫЗЫВАЕМ МЕТОД КЛАССА ROUTE
		 else{
		 	Route::ErrorPage404();
		}
		$controller = new $controller_name;
		$action = $action_name;
		// echo '>>>'.$action;
		// var_dump($_POST);
		if(isset($title) && isset($cat)) {$action_param = $title; $action_data = $cat;}
		else if(isset($title)){$action_param = $title; }

		//ЕСЛИ ЮЗЕР ОШИБСЯ, НО УЖЕ ВО ВТОРОЙ ЧАСТИ УРЛА
		if(method_exists($controller, $action)){
			$controller->$action($action_param, $action_data);
		}
		else{
		 	Route::ErrorPage404();
		}

	}
	
	static function ErrorPage404(){
		$host = "http://".$_SERVER["HTTP_HOST"]."/";
		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header("Location:".$host.'404');
	}
}