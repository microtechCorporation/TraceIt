<?php
require_once __DIR__ . '/../configs/database.php';

class OcorrenciaModel
{
    private $db;
    private $table = "ocorrencias";

    /**
     * Construtor da classe OcorrenciaModel.
     * Inicializa a conexão com o banco de dados.
     */
    public function __construct()
    {
        $this->db = getConnection();
        if (!$this->db) {
            error_log("Erro no OcorrenciaModel: Falha na conexão com o banco de dados.");
            throw new Exception("Falha na conexão com o banco de dados.");
        }
    }

    /**
     * Registra uma nova ocorrência no banco de dados e atualiza o status do dispositivo.
     * @param int $usuario_id ID do usuário.
     * @param array $data Dados da ocorrência (dispositivo_id, tipo, data_ocorrencia, local, descricao).
     * @return bool Retorna true se o registro for bem-sucedido, false caso contrário.
     */
    public function registrarOcorrencia($usuario_id, $data)
    {
        try {
            // Validar entrada
            if (!is_numeric($usuario_id) || $usuario_id <= 0) {
                error_log("Erro no OcorrenciaModel: ID de usuário inválido ($usuario_id)");
                return false;
            }
            if (!is_numeric($data['dispositivo_id']) || $data['dispositivo_id'] <= 0) {
                error_log("Erro no OcorrenciaModel: dispositivo_id inválido ({$data['dispositivo_id']})");
                return false;
            }

            // Iniciar transação
            $this->db->beginTransaction();

            // Validar se o dispositivo pertence ao usuário
            $stmt = $this->db->prepare("SELECT id FROM dispositivos WHERE id = ? AND usuario_id = ?");
            $stmt->execute([$data['dispositivo_id'], $usuario_id]);
            if (!$stmt->fetch()) {
                error_log("Erro no OcorrenciaModel: Dispositivo ID {$data['dispositivo_id']} não encontrado ou não pertence ao usuário ID $usuario_id");
                throw new Exception("Dispositivo não encontrado ou não pertence ao usuário.");
            }

            // Inserir ocorrência com status 'registrado'
            $stmt = $this->db->prepare("
                INSERT INTO " . $this->table . " (dispositivo_id, usuario_id, tipo, data_ocorrencia, local, descricao, status, criado_em, atualizado_em)
                VALUES (?, ?, ?, ?, ?, ?, 'registrado', NOW(), NOW())
            ");
            $result = $stmt->execute([
                $data['dispositivo_id'],
                $usuario_id,
                $data['tipo'],
                $data['data_ocorrencia'],
                $data['local'],
                $data['descricao'] ?? null
            ]);

            if (!$result) {
                error_log("Erro no OcorrenciaModel: Falha ao inserir ocorrência para dispositivo_id {$data['dispositivo_id']}");
                throw new Exception("Erro ao registrar a ocorrência.");
            }

            // Mapear tipo de ocorrência para status do dispositivo
            $deviceStatus = ($data['tipo'] === 'furto') ? 'roubado' : 'perdido';

            // Atualizar o status do dispositivo
            $stmt = $this->db->prepare("UPDATE dispositivos SET status = ?, atualizado_em = NOW() WHERE id = ?");
            $result = $stmt->execute([$deviceStatus, $data['dispositivo_id']]);

            if (!$result) {
                error_log("Erro no OcorrenciaModel: Falha ao atualizar status do dispositivo ID {$data['dispositivo_id']} para $deviceStatus");
                throw new Exception("Erro ao atualizar o status do dispositivo.");
            }

            // Commit da transação
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Erro no OcorrenciaModel: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Carrega as ocorrências de um usuário.
     * @param int $usuario_id ID do usuário.
     * @return array Lista de ocorrências.
     */
    public function loadUserOcorrencias($usuario_id)
    {
        try {
            if (!is_numeric($usuario_id) || $usuario_id <= 0) {
                error_log("Erro no OcorrenciaModel: ID de usuário inválido ($usuario_id)");
                return [];
            }
            $stmt = $this->db->prepare("
                SELECT o.*, d.imei, d.marca, d.modelo
                FROM " . $this->table . " o
                JOIN dispositivos d ON o.dispositivo_id = d.id
                WHERE o.usuario_id = ?
                ORDER BY o.criado_em DESC
            ");
            $stmt->execute([$usuario_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao carregar ocorrências para usuário ID $usuario_id: " . $e->getMessage());
            return [];
        }
    }
}
?>