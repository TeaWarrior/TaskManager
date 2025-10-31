<?php


define('ROOT_PATH', dirname(__DIR__));


require ROOT_PATH . '/app/Core/Autoloader.php'; 


$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $uri);


$controllerName = !empty($segments[0]) ? ucfirst(strtolower($segments[0])) : 'Task'; 

$actionName = !empty($segments[1]) ? strtolower($segments[1]) : 'index';

$params = array_slice($segments, 2);


try {
   
    $controller = loadController($controllerName);

   
    if (method_exists($controller, $actionName)) {
      
        call_user_func_array([$controller, $actionName], $params);
    } else {
     
        header("HTTP/1.0 404 Not Found");
        echo "Ошибка 404: Действие **$actionName** не найдено в контроллере **$controllerName**.";
    }

} catch (Exception $e) {
   
    header("HTTP/1.0 404 Not Found");
    echo "Ошибка 404: " . htmlspecialchars($e->getMessage());
}