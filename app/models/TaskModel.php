<?php

class TaskModel {
    private $db;

    public function __construct() {

        $this->db = DB::getInstance(); 
    }


    public function getAllTasks($userId) {
      $sql = "SELECT * FROM tasks WHERE is_completed = 0 AND user_id = ? ORDER BY created_at DESC"; 
      $stmt = $this->db->query($sql, [$userId]);
        return $stmt->fetchAll();
    }


    public function getTaskById($id) {
        $sql = "SELECT * FROM tasks WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }

    public function create($title, $description ,$priority,$userId) {
        $sql = "INSERT INTO tasks (title, description, priority, user_id) VALUES (?, ?, ?, ?)"; 
        return $this->db->query($sql, [$title, $description, $priority, $userId]);
    }

    public function update($id, $title, $description, $priority, $isCompleted) {
  
    $sql = "UPDATE tasks SET title = ?, description = ?, priority = ?, is_completed = ?"; 
    $params = [$title, $description, $priority, (int)$isCompleted];
    
    if ((int)$isCompleted === 1) {
        
        $sql .= ", completed_at = NOW()";
    } else {
        $sql .= ", completed_at = NULL";
    }
    $sql .= " WHERE id = ?";
    $params[] = $id; 
    return $this->db->query($sql, $params);
}

    public function delete($id) {
        $sql = "DELETE FROM tasks WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function getCompletedTasks($userId) {

    $sql = "SELECT id, title, description, priority, completed_at FROM tasks WHERE is_completed = 1 AND user_id = ? ORDER BY completed_at DESC";
    $stmt = $this->db->query($sql, [$userId]);
    return $stmt->fetchAll(); 
}

}