<?php
// app/Models/UserModel.php

class UserModel {
    private $db;

    public function __construct() {
        $this->db = DB::getInstance(); 
    }

   
    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->query($sql, [$username]);
        return $stmt->fetch();
    }

   
    public function register($username, $hashedPassword) {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        
        return $this->db->query($sql, [$username, $hashedPassword]);
    }

    
    public function verifyPassword($inputPassword, $hashedPassword) {
        return password_verify($inputPassword, $hashedPassword);
    }
}