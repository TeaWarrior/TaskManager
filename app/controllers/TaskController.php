<?php


class TaskController {
    
    
    private function render($viewPath, $data = []) {
        extract($data); 
        $filePath = ROOT_PATH . '/app/Views/' . $viewPath . '.php';

        if (file_exists($filePath)) {
            require $filePath;
        } else {
          
            die("Error: View file **$filePath** not found."); 
        }
    }
    
    public function __construct() {
        
        Auth::startSession(); 
    }
 
    public function index() {
       
        Auth::requireLogin();
        
        $taskModel = new TaskModel();
        
        $tasks = $taskModel->getAllTasks();
     
        $this->render('task/index', ['tasks' => $tasks]);

    }
}