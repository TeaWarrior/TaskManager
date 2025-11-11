<?php


class TaskController {
    
    
    private function render($viewPath, $data = []) {
    extract($data); 
    $contentPath = ROOT_PATH . '/app/Views/' . $viewPath . '.php';

    if (!file_exists($contentPath)) {
        die("Error: View file **$contentPath** not found."); 
    }
    $layoutPath = ROOT_PATH . '/app/Views/layout/main.php';

    if (file_exists($layoutPath)) {
        require $layoutPath; 
    } else {
        require $contentPath; 
    }
    }

    
    
    public function __construct() {
        
        Auth::startSession(); 
    }
 
    public function index() {
       
        Auth::requireLogin();
        $userId = Auth::userId();
        
        $taskModel = new TaskModel();
        
        $tasks = $taskModel->getAllTasks($userId);
     
        $this->render('task/index', ['tasks' => $tasks]);

    }

    public function apiindex() {
    Auth::requireLogin(); 
    $userId = Auth::userId();
    try {
        
        $taskModel = new TaskModel();
        $tasks = $taskModel->getAllTasks($userId);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'count' => count($tasks),
            'data' => $tasks
        ]);

    } catch (\Exception $e) {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
    }
    exit;
    }

    public function add() {
        Auth::requireLogin(); 
        $this->render('task/add', ['error' => '']);
    }

    public function apistore() { 
    Auth::requireLogin();
    $userId = Auth::userId();
    
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        
        header('HTTP/1.1 405 Method Not Allowed');
        return;
    }
    
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true); 

    $title = trim($data['title'] ?? '');
    $description = trim($data['description'] ?? '');
    $priority = $data['priority'] ?? 'Medium';
    
    if (empty($title)) {
        header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Title is required.']);
        exit;
    }

    try {
        $taskModel = new TaskModel();
        $newTask = $taskModel->create($title, $description, $priority, $userId);

        header('HTTP/1.1 201 Created'); 
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Task created successfully.', 'data' => $newTask]);

    } catch (\Exception $e) {
        
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
    }

    exit;
    }
    
    public function store() {
        Auth::requireLogin(); 
        $userId = Auth::userId();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /task/add');
            return;
        }
        
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $priority = $_POST['priority'] ?? 'Medium';
        if (empty($title)) {
            $this->render('task/add', ['error' => 'Task title cannot be empty.']);
            return;
        }
        
        $taskModel = new TaskModel();
        $taskModel->create($title, $description,$priority,$userId);
        
        
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
        $priority = $_POST['priority'] ?? 'Medium';
        $isCompleted = isset($_POST['is_completed']) ? 1 : 0; 
        
        if (empty($title)) {
           
            $taskModel = new TaskModel();
            $task = $taskModel->getTaskById($id);
            $this->render('task/edit', ['task' => $task, 'error' => 'Title cannot be empty.']);
            return;
        }
        
        $taskModel = new TaskModel();
        $taskModel->update($id, $title, $description, $priority, $isCompleted);
        
        header('Location: /'); 
        exit;
    }

    
    public function apiToggleComplete($id) { 
    Auth::requireLogin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
        header('HTTP/1.1 405 Method Not Allowed');
        return;
    }
    
  
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true); 

    $isCompleted = isset($data['is_completed']) ? (int)$data['is_completed'] : null; 
    
    if (!in_array($isCompleted, [0, 1])) {
        header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Invalid is_completed value.']);
        exit;
    }

    try {
        $taskModel = new TaskModel();
       
        $task = $taskModel->getTaskById($id);
        if (!$task || (int)$task['user_id'] !== Auth::userId()) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['status' => 'error', 'message' => 'Task not found or unauthorized.']);
            exit;
        }
        
        $success = $taskModel->toggleCompleteStatus($id, $isCompleted);

        if ($success) {
            header('HTTP/1.1 200 OK');
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Task status updated.']);
        } else {
             throw new \Exception("Database update failed.");
        }

    } catch (\Exception $e) {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
    }

    exit;
    }

    public function apiDelete($id) { 
    Auth::requireLogin();
    header('Content-Type: application/json');
    
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed.']);
        return;
    }

    try {
        $taskModel = new TaskModel();
        
        
        $task = $taskModel->getTaskById($id);
        if (!$task || (int)$task['user_id'] !== Auth::userId()) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['status' => 'error', 'message' => 'Task not found or unauthorized.']);
            exit;
        }
        
        
        $taskModel->delete($id);

        
        header('HTTP/1.1 200 OK');
        echo json_encode(['status' => 'success', 'message' => 'Task deleted successfully.']);

    } catch (\Exception $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
    }

    exit;
}

    public function delete($id) {
        Auth::requireLogin();
        
       
        
        $taskModel = new TaskModel();
        $taskModel->delete($id);
        
        header('Location: /');
        exit;
    }

    public function completed() {
    Auth::requireLogin();
    $userId = Auth::userId();
    $model = new TaskModel();
    $completedTasks = $model->getCompletedTasks($userId); 
    $this->render('task/completed', ['tasks' => $completedTasks]);
      } 
}