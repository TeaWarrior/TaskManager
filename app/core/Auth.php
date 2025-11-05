<?php
// app/Core/Auth.php

class Auth {
    
    
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    
    public static function check() {
        self::startSession();
        return isset($_SESSION['user_id']);
    }

   
    public static function userId() {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }

    
    public static function requireLogin() {
        if (!self::check()) {
            header('Location: /user/login');
            exit; 
        }
    }
}