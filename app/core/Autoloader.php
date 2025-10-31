<?php

spl_autoload_register(function ($className) {
    
  
    $className = str_replace('\\', '/', $className);


    $dirs = ['Controllers', 'Models', 'Core']; 

    foreach ($dirs as $dir) {
 
        $file = ROOT_PATH . '/app/' . $dir . '/' . $className . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
    

    $file = ROOT_PATH . '/app/' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
    

});


function loadController($controllerName) {
    $className = $controllerName . 'Controller'; 
    

    $path = ROOT_PATH . '/app/Controllers/' . $className . '.php';
    
    if (file_exists($path)) {
        require_once $path;
   
        return new $className();
    }

    throw new Exception("Контроллер $className не найден по пути $path");
}