<?php
require_once __DIR__ . '/../config/setup.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAll() { //Get all users
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $email, $pass, $role) {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$name, $email, $pass, $role]);
        return $result;
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $email, $role) {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

}