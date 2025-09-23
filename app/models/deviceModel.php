<?php
require_once __DIR__ . '/../configs/database.php';

class DeviceModel
{
    private $db;
    private $table = "dispositivos";

    public function __construct()
    {
        $this->db = getConnection();
        if (!$this->db) {
            error_log("Erro no DeviceModel: Falha na conexão com o banco de dados.");
            throw new Exception("Falha na conexão com o banco de dados.");
        }
    }

    public function loadUserDevices($user_id)
    {
        try {
            if (!is_numeric($user_id) || $user_id <= 0) {
                error_log("Erro no DeviceModel: ID de usuário inválido ($user_id)");
                return [];
            }
            $stmt = $this->db->prepare("SELECT id, usuario_id, imei, marca, modelo, cor, tipo_dispositivo, fotos, status, criado_em, atualizado_em 
                                        FROM " . $this->table . " 
                                        WHERE usuario_id = ? ORDER BY criado_em DESC");
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao carregar dispositivos para usuário ID $user_id: " . $e->getMessage());
            return [];
        }
    }

    public function registerDevice($user_id, $data)
    {
        try {
            if (!is_numeric($user_id) || $user_id <= 0) {
                error_log("Erro no DeviceModel: ID de usuário inválido ($user_id)");
                return false;
            }

            $stmt = $this->db->prepare("
                INSERT INTO dispositivos (usuario_id, imei, marca, modelo, cor, tipo_dispositivo, fotos, status, criado_em, atualizado_em)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            $result = $stmt->execute([
                $user_id,
                $data['imei'],
                $data['marca'],
                $data['modelo'],
                $data['cor'] ?? null,
                $data['tipo_dispositivo'],
                $data['fotos'] ?? null,
                $data['status']
            ]);

            if ($result) {
                return true;
            } else {
                error_log("Erro no DeviceModel: Nenhum registro inserido para usuário ID $user_id");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro ao registrar dispositivo para usuário ID $user_id: " . $e->getMessage());
            return false;
        }
    }

    public function updateDevicePhoto($device_id, $photo_path)
    {
        try {
            if (!is_numeric($device_id) || $device_id <= 0) {
                error_log("Erro no DeviceModel: ID de dispositivo inválido ($device_id)");
                return false;
            }

            $stmt = $this->db->prepare("
                UPDATE " . $this->table . "
                SET fotos = ?, atualizado_em = NOW()
                WHERE id = ?
            ");
            $result = $stmt->execute([$photo_path, $device_id]);

            if ($result) {
                return true;
            } else {
                error_log("Erro no DeviceModel: Nenhum registro atualizado para dispositivo ID $device_id");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro ao atualizar foto do dispositivo ID $device_id: " . $e->getMessage());
            return false;
        }
    }

    public function searchDeviceByIMEI($imei, $user_id = null)
    {
        try {
            $query = "
                SELECT d.id, d.usuario_id, d.imei, d.marca, d.modelo, d.cor, d.tipo_dispositivo, d.fotos, d.status, 
                       d.criado_em, d.atualizado_em, o.id AS ocorrencia_id, o.tipo AS ocorrencia_tipo, 
                       o.data_ocorrencia, o.local, o.descricao, o.status AS ocorrencia_status, o.criado_em AS ocorrencia_criado_em
                FROM " . $this->table . " d
                LEFT JOIN ocorrencias o ON d.id = o.dispositivo_id
                WHERE d.imei = ?
            ";
            $params = [$imei];

            if ($user_id !== null && is_numeric($user_id) && $user_id > 0) {
                $query .= " AND d.usuario_id = ?";
                $params[] = $user_id;
            }

            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($results)) {
                error_log("Erro no DeviceModel: Nenhum dispositivo encontrado para IMEI $imei" . ($user_id ? " e usuário ID $user_id" : ""));
                return null;
            }

            $device = [
                'id' => $results[0]['id'],
                'usuario_id' => $results[0]['usuario_id'],
                'imei' => $results[0]['imei'],
                'marca' => $results[0]['marca'],
                'modelo' => $results[0]['modelo'],
                'cor' => $results[0]['cor'],
                'tipo_dispositivo' => $results[0]['tipo_dispositivo'],
                'fotos' => $results[0]['fotos'],
                'status' => $results[0]['status'],
                'criado_em' => $results[0]['criado_em'],
                'atualizado_em' => $results[0]['atualizado_em'],
                'ocorrencias' => []
            ];

            foreach ($results as $row) {
                if ($row['ocorrencia_id']) {
                    $device['ocorrencias'][] = [
                        'id' => $row['ocorrencia_id'],
                        'tipo' => $row['ocorrencia_tipo'],
                        'data_ocorrencia' => $row['data_ocorrencia'],
                        'local' => $row['local'],
                        'descricao' => $row['descricao'],
                        'status' => $row['ocorrencia_status'],
                        'criado_em' => $row['ocorrencia_criado_em']
                    ];
                }
            }

            return $device;
        } catch (PDOException $e) {
            error_log("Erro ao buscar dispositivo por IMEI $imei: " . $e->getMessage());
            return null;
        }
    }

    public function updateDevice($device_id, $user_id, $data)
    {
        try {
            if (!is_numeric($device_id) || $device_id <= 0 || !is_numeric($user_id) || $user_id <= 0) {
                error_log("Erro no DeviceModel: ID de dispositivo ($device_id) ou usuário ($user_id) inválido.");
                return false;
            }

            $stmt = $this->db->prepare("
                UPDATE " . $this->table . "
                SET imei = ?, marca = ?, modelo = ?, cor = ?, tipo_dispositivo = ?, atualizado_em = NOW()
                WHERE id = ? AND usuario_id = ?
            ");
            $result = $stmt->execute([
                $data['imei'],
                $data['marca'],
                $data['modelo'],
                $data['cor'] ?? null,
                $data['tipo_dispositivo'],
                $device_id,
                $user_id
            ]);

            if ($result) {
                return true;
            } else {
                error_log("Erro no DeviceModel: Nenhum registro atualizado para dispositivo ID $device_id e usuário ID $user_id.");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro ao atualizar dispositivo ID $device_id: " . $e->getMessage());
            return false;
        }
    }

    public function deleteDevice($device_id) {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id = :device_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':device_id', $device_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Erro ao deletar dispositivo: ' . $e->getMessage());
            return false;
        }
    }

    public function getDeviceById($device_id) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE id = :device_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':device_id', $device_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Erro ao buscar dispositivo: ' . $e->getMessage());
            return false;
        }
    }
}
?>