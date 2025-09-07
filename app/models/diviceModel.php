<?php
require_once __DIR__ . '/../configs/database.php';

class DeviceModel
{
    private $db;

    public function __construct()
    {
        $this->db = getConnection();
    }

    public function loadUserDevices($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM dispositivos WHERE usuario_id = ? ORDER BY criado_em DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
