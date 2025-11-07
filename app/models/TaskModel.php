<?php

class TaskModel {
    private $db;

    public function __construct() {

        $this->db = DB::getInstance(); 
    }


    public function getAllTasks() {
        $sql = "SELECT * FROM tasks WHERE is_completed = 0 ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }


    public function getTaskById($id) {
        $sql = "SELECT * FROM tasks WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }

    public function create($title, $description ,$priority) {
        $sql = "INSERT INTO tasks (title, description, priority) VALUES (?, ?, ?)";
        return $this->db->query($sql, [$title, $description,$priority]);
    }

    public function update($id, $title, $description, $isCompleted) {
        $sql = "UPDATE tasks SET title = ?, description = ?, is_completed = ? WHERE id = ?";     
        $isCompleted = (int)$isCompleted; 
        return $this->db->query($sql, [$title, $description, $isCompleted, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM tasks WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function getCompletedTasks() {

    $sql = "SELECT id, title, description, priority FROM tasks WHERE is_completed = 1 ORDER BY id DESC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(); 
}

}