<?php
session_start();
require_once __DIR__ . '/../models/OcorrenciaModel.php';

class OcorrenciaController
{
    private $ocorrenciaModel;

    /**
     * Construtor da classe OcorrenciaController.
     * Inicializa o modelo de ocorrências.
     */
    public function __construct()
    {
        $this->ocorrenciaModel = new OcorrenciaModel();
    }

    /**
     * Carrega as ocorrências de um usuário.
     * @param int $usuario_id ID do usuário.
     * @return array Lista de ocorrências.
     */
    public function loadUserOcorrenciasController($usuario_id)
    {
        if (!is_numeric($usuario_id) || $usuario_id <= 0) {
            error_log("Erro no OcorrenciaController: ID de usuário inválido ($usuario_id)");
            return [];
        }
        return $this->ocorrenciaModel->loadUserOcorrencias($usuario_id);
    }

    /**
     * Processa o registro de uma nova ocorrência.
     * Valida os dados do POST, chama o Model para salvar, armazena mensagens na sessão e redireciona.
     */
    public function registrarOcorrenciaController()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['registrar_ocorrencia'])) {
            $_SESSION['ocorrenciaError'] = 'Método não permitido. Use POST.';
            error_log("Erro no OcorrenciaController: Método inválido ou registrar_ocorrencia não definido.");
            header("Location: /app/views/user/user_dashboard.php");
            exit;
        }

        $data = [
            'dispositivo_id' => trim($_POST['dispositivo_id'] ?? ''),
            'tipo' => trim($_POST['tipo'] ?? ''),
            'data_ocorrencia' => trim($_POST['data_ocorrencia'] ?? ''),
            'local' => trim($_POST['local'] ?? ''),
            'descricao' => trim($_POST['descricao'] ?? '')
        ];

        // Log dos dados recebidos
        error_log("Dados recebidos no OcorrenciaController: " . json_encode($data));

        // Validações
        if (
            empty($data['dispositivo_id']) ||
            !is_numeric($data['dispositivo_id']) ||
            empty($data['tipo']) ||
            !in_array($data['tipo'], ['furto', 'perda']) ||
            empty($data['data_ocorrencia']) ||
            empty($data['local'])
        ) {
            $_SESSION['ocorrenciaError'] = 'Por favor, preencha todos os campos obrigatórios corretamente.';
            error_log("Erro no OcorrenciaController: Campos obrigatórios inválidos ou ausentes.");
            header("Location: /app/views/user/user_dashboard.php");
            exit;
        }

        // Validar data (não futura)
        if (strtotime($data['data_ocorrencia']) > time()) {
            $_SESSION['ocorrenciaError'] = 'A data da ocorrência não pode ser futura.';
            error_log("Erro no OcorrenciaController: Data da ocorrência futura ({$data['data_ocorrencia']}).");
            header("Location: /app/views/user/user_dashboard.php");
            exit;
        }

        try {
            $result = $this->ocorrenciaModel->registrarOcorrencia(72, $data); // ID hardcoded '72'
            if ($result) {
                $_SESSION['ocorrenciaSuccess'] = "Ocorrência registrada com sucesso!";
            } else {
                $_SESSION['ocorrenciaError'] = "Erro ao registrar a ocorrência. Tente novamente.";
                error_log("Erro no OcorrenciaController: Falha ao registrar ocorrência para dispositivo_id {$data['dispositivo_id']}.");
            }
        } catch (Exception $e) {
            $_SESSION['ocorrenciaError'] = "Erro interno: " . $e->getMessage();
            error_log("Erro no OcorrenciaController: " . $e->getMessage());
        }

        header("Location: /app/views/user/user_dashboard.php");
        exit;
    }
}

// Processar a requisição diretamente
if (basename($_SERVER['SCRIPT_NAME']) === 'OcorrenciaController.php') {
    $controller = new OcorrenciaController();
    $controller->registrarOcorrenciaController();
}
?>