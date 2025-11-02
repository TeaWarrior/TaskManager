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

    public function add() {
        Auth::requireLogin(); 
        $this->render('task/add', ['error' => '']);
    }

    
    public function store() {
        Auth::requireLogin(); 
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /task/add');
            return;
        }
        
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($title)) {
            $this->render('task/add', ['error' => 'Task title cannot be empty.']);
            return;
        }
        
        $taskModel = new TaskModel();
        $taskModel->create($title, $description);
        
        
        header('Location: /');
        exit;
    }

    public function edit($id) {
        Auth::requireLogin();
        
        $taskModel = new TaskModel();
        $task = $taskModel->getTaskById($id); 
        
        if (!$task) {
            header('Location: /'); 
            exit;
        }
        
        $this->render('task/edit', ['task' => $task, 'error' => '']);
    }

    public function update($id) {
        Auth::requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /task/edit/' . $id);
            return;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
       
        $isCompleted = isset($_POST['is_completed']) ? 1 : 0; 
        
        if (empty($title)) {
           
            $taskModel = new TaskModel();
            $task = $taskModel->getTaskById($id);
            $this->render('task/edit', ['task' => $task, 'error' => 'Title cannot be empty.']);
            return;
        }
        
        $taskModel = new TaskModel();
        $taskModel->update($id, $title, $description, $isCompleted);
        
        header('Location: /'); 
        exit;
    }

    public function delete($id) {
        Auth::requireLogin();
        
       
        
        $taskModel = new TaskModel();
        $taskModel->delete($id);
        
        header('Location: /');
        exit;
    }
}