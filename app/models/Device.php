<?php

require_once __DIR__ . '/../configs/database.php';

class Device {
    private $conn;
    private $table = 'dispositivos';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getDevicesByUserId($user_id) {
        $query = "SELECT id, imei, marca, modelo, cor, status, criado_em FROM " . $this->table . " WHERE usuario_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>