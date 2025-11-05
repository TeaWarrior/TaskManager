<?php
// app/Controllers/UserController.php

class UserController {
    
    private $userModel;

    public function __construct() {
       
        $this->userModel = new UserModel(); 
     
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
   
    private function render($viewPath, $data = []) {
        extract($data); 
        $filePath = ROOT_PATH . '/app/Views/' . $viewPath . '.php';

        if (file_exists($filePath)) {
            require $filePath;
        } else {
            die("Error: View file **$filePath** not found."); 
        }
    }

   
    public function login() {
        $this->render('user/login');
    }

   
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /user/login'); 
            return;
        }

        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $error = '';

        $user = $this->userModel->findByUsername($username);

        if ($user && $this->userModel->verifyPassword($password, $user['password'])) {
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: /'); 
            return;
        } else {
            $error = 'Invalid username or password.';
        }
        
       
        $this->render('user/login', ['error' => $error, 'username' => $username]);
    }
    
   
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /user/login');
    }

    
    public function register() {
      
        $this->render('user/register', ['error' => '', 'username' => '']);
    }

    
    public function handleRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /user/register'); 
            return;
        }

        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $error = '';
        
      
        if (empty($username) || empty($password)) {
            $error = 'Username and password are required.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters long.';
        } elseif ($this->userModel->findByUsername($username)) {
            $error = 'This username is already taken.';
        }

        if ($error) {
           
            $this->render('user/register', ['error' => $error, 'username' => $username]);
            return;
        }

       
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        if ($this->userModel->register($username, $hashedPassword)) {
            
            
           
            $user = $this->userModel->findByUsername($username);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            header('Location: /'); 
        } else {
            $error = 'Registration failed. Please try again.';
            $this->render('user/register', ['error' => $error, 'username' => $username]);
        }
    }


}