<?php

require_once __DIR__ . '/../configs/database.php';

class User {
    private $conn;
    private $table = 'usuarios';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getUserById($id) {
        $query = "SELECT id, nome, email FROM " . $this->table . " WHERE id = :id AND ativo = TRUE";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
}

?>