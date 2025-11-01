<?php

class TaskModel {
    private $db;

    public function __construct() {

        $this->db = DB::getInstance(); 
    }


    public function getAllTasks() {
        $sql = "SELECT * FROM tasks ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }


    public function getTaskById($id) {
        $sql = "SELECT * FROM tasks WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);

        return $stmt->fetch();
    }

    public function create($title, $description) {
        $sql = "INSERT INTO tasks (title, description) VALUES (?, ?)";
        return $this->db->query($sql, [$title, $description]);
    }

}