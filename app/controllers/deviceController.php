<?php
session_start();
require_once __DIR__ . '/../models/DeviceModel.php';

class DeviceController
{
    private $deviceModel;
    private $uploadDir = __DIR__ . '/../../assets/uploads/devices/';
    private $model;

    public function __construct()
    {
        $this->deviceModel = new DeviceModel();
        $this->model = new DeviceModel();
    }

    public function loadUserDevicesController($user_id)
    {
        if (!is_numeric($user_id) || $user_id <= 0) {
            error_log("Erro no DeviceController: ID de usuário inválido ($user_id)");
            return [];
        }
        return $this->deviceModel->loadUserDevices($user_id);
    }

    public function registerDeviceController()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['register_device'])) {
            $_SESSION['registerError'] = 'Método não permitido. Use POST.';
            error_log("Erro no DeviceController: Método inválido ou register_device não definido.");
            header("Location: /app/views/user/user_dashboard.php");
            exit;
        }

        $data = [
            'imei' => trim($_POST['imei'] ?? ''),
            'marca' => trim($_POST['marca'] ?? ''),
            'modelo' => trim($_POST['modelo'] ?? ''),
            'cor' => trim($_POST['cor'] ?? ''),
            'tipo_dispositivo' => trim($_POST['tipo_dispositivo'] ?? ''),
            'status' => 'ativo',
            'fotos' => null
        ];

        error_log("Dados recebidos no DeviceController: " . json_encode($data));

        if (
            empty($data['imei']) ||
            empty($data['marca']) ||
            empty($data['modelo']) ||
            empty($data['tipo_dispositivo']) ||
            !in_array($data['tipo_dispositivo'], ['celular', 'laptop'])
        ) {
            $_SESSION['registerError'] = 'Por favor, preencha todos os campos obrigatórios corretamente.';
            error_log("Erro no DeviceController: Campos obrigatórios inválidos ou ausentes.");
            header("Location: /app/views/user/user_dashboard.php");
            exit;
        }

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxFileSize = 5 * 1024 * 1024;

            $file = $_FILES['foto'];
            $fileType = $file['type'];
            $fileSize = $file['size'];
            $fileTmp = $file['tmp_name'];

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['registerError'] = 'Formato de imagem inválido. Use JPEG, PNG ou GIF.';
                error_log("Erro no DeviceController: Formato de imagem inválido ($fileType).");
                header("Location: /app/views/user/user_dashboard.php");
                exit;
            }

            if ($fileSize > $maxFileSize) {
                $_SESSION['registerError'] = 'Imagem muito grande. O tamanho máximo é 5MB.';
                error_log("Erro no DeviceController: Imagem excede o tamanho máximo ($fileSize bytes).");
                header("Location: /app/views/user/user_dashboard.php");
                exit;
            }

            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = $data['imei'] . '_' . date('YmdHis') . '.' . $fileExtension;
            $filePath = $this->uploadDir . $fileName;
            $relativePath = '/assets/uploads/devices/' . $fileName;

            if (!move_uploaded_file($fileTmp, $filePath)) {
                $_SESSION['registerError'] = 'Erro ao fazer upload da imagem. Tente novamente.';
                error_log("Erro no DeviceController: Falha ao mover imagem para $filePath.");
                header("Location: /app/views/user/user_dashboard.php");
                exit;
            }

            $data['fotos'] = $relativePath;
        }

        try {
            $user_id = $_SESSION['user_id'] ?? 72; // Usar ID da sessão, fallback para 72
            $result = $this->deviceModel->registerDevice($user_id, $data);
            if ($result) {
                $_SESSION['registerSuccess'] = "Dispositivo registrado com sucesso!";
            } else {
                $_SESSION['registerError'] = "Erro ao registrar o dispositivo. Tente novamente.";
                error_log("Erro no DeviceController: Falha ao registrar dispositivo com IMEI {$data['imei']}.");
            }
        } catch (Exception $e) {
            $_SESSION['registerError'] = "Erro interno: " . $e->getMessage();
            error_log("Erro no DeviceController: " . $e->getMessage());
        }

        header("Location: /app/views/user/user_dashboard.php");
        exit;
    }

    public function uploadDevicePhotoController()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['upload_photo'])) {
            $_SESSION['photoError'] = 'Método não permitido. Use POST.';
            error_log("Erro no DeviceController: Método inválido ou upload_photo não definido.");
            header("Location: /app/views/user/user_dashboard.php");
            exit;
        }

        $device_id = trim($_POST['device_id'] ?? '');
        if (!is_numeric($device_id) || $device_id <= 0) {
            $_SESSION['photoError'] = 'ID do dispositivo inválido.';
            error_log("Erro no DeviceController: ID do dispositivo inválido ($device_id).");
            header("Location: /app/views/user/user_dashboard.php");
            exit;
        }

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxFileSize = 5 * 1024 * 1024;

            $file = $_FILES['foto'];
            $fileType = $file['type'];
            $fileSize = $file['size'];
            $fileTmp = $file['tmp_name'];

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['photoError'] = 'Formato de imagem inválido. Use JPEG, PNG ou GIF.';
                error_log("Erro no DeviceController: Formato de imagem inválido ($fileType).");
                header("Location: /app/views/user/user_dashboard.php");
                exit;
            }

            if ($fileSize > $maxFileSize) {
                $_SESSION['photoError'] = 'Imagem muito grande. O tamanho máximo é 5MB.';
                error_log("Erro no DeviceController: Imagem excede o tamanho máximo ($fileSize bytes).");
                header("Location: /app/views/user/user_dashboard.php");
                exit;
            }

            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = $device_id . '_' . date('YmdHis') . '.' . $fileExtension;
            $filePath = $this->uploadDir . $fileName;
            $relativePath = '/assets/uploads/devices/' . $fileName;

            if (!move_uploaded_file($fileTmp, $filePath)) {
                $_SESSION['photoError'] = 'Erro ao fazer upload da imagem. Tente novamente.';
                error_log("Erro no DeviceController: Falha ao mover imagem para $filePath.");
                header("Location: /app/views/user/user_dashboard.php");
                exit;
            }

            try {
                $result = $this->deviceModel->updateDevicePhoto($device_id, $relativePath);
                if ($result) {
                    $_SESSION['photoSuccess'] = "Foto do dispositivo atualizada com sucesso!";
                } else {
                    $_SESSION['photoError'] = "Erro ao atualizar a foto do dispositivo. Tente novamente.";
                    error_log("Erro no DeviceController: Falha ao atualizar foto para dispositivo ID $device_id.");
                }
            } catch (Exception $e) {
                $_SESSION['photoError'] = "Erro interno: " . $e->getMessage();
                error_log("Erro no DeviceController: " . $e->getMessage());
            }
        } else {
            $_SESSION['photoError'] = 'Nenhuma imagem selecionada ou erro no upload.';
            error_log("Erro no DeviceController: Nenhuma imagem válida para dispositivo ID $device_id.");
        }

        header("Location: /app/views/user/user_dashboard.php");
        exit;
    }

    public function deleteDevice($device_id, $user_id) {
        try {
            error_log("Tentativa de deletar dispositivo ID $device_id com user_id $user_id");
            // Verificar se o dispositivo pertence ao usuário
            $device = $this->model->getDeviceById($device_id);
            if (!$device || $device['usuario_id'] != $user_id) {
                error_log("Erro no DeviceController: Dispositivo ID $device_id não encontrado ou não pertence ao usuário ID $user_id");
                $_SESSION['deleteError'] = 'Dispositivo não encontrado ou não pertence ao usuário.';
                header('Location: /app/views/user/user_dashboard.php');
                exit;
            }

            // Deletar o dispositivo usando um método público do DeviceModel
            $result = $this->model->deleteDevice($device_id);
            if ($result) {
                $_SESSION['deleteSuccess'] = 'Dispositivo deletado com sucesso.';
            } else {
                error_log("Erro no DeviceController: Falha ao deletar dispositivo ID $device_id");
                $_SESSION['deleteError'] = 'Erro ao deletar o dispositivo.';
            }
        } catch (Exception $e) {
            error_log("Erro no DeviceController: Falha ao deletar dispositivo ID $device_id - " . $e->getMessage());
            $_SESSION['deleteError'] = 'Erro ao deletar o dispositivo: ' . $e->getMessage();
        }
        header('Location: /app/views/user/user_dashboard.php');
        exit;
    }

    public function searchDeviceController()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['search_imei'])) {
            $_SESSION['searchError'] = 'Método não permitido. Use POST.';
            error_log("Erro no DeviceController: Método inválido ou search_imei não definido.");
            header("Location: /app/views/user/user_dashboard.php");
            exit;
        }

        $imei = trim($_POST['imei'] ?? '');
        $user_id = $_SESSION['user_id'] ?? 72; // Usar ID da sessão, fallback para 72
        error_log("Pesquisa de IMEI recebida: $imei, usuário ID: $user_id");

        if (empty($imei)) {
            $_SESSION['searchError'] = 'Por favor, insira um IMEI válido.';
            error_log("Erro no DeviceController: IMEI vazio.");
            header("Location: /app/views/user/user_dashboard.php");
            exit;
        }

        try {
            $device = $this->deviceModel->searchDeviceByIMEI($imei, $user_id);
            if ($device) {
                $_SESSION['searchResult'] = $device;
                $_SESSION['searchSuccess'] = "Dispositivo encontrado!";
            } else {
                $_SESSION['searchError'] = "Nenhum dispositivo encontrado com o IMEI informado.";
                error_log("Erro no DeviceController: Nenhum dispositivo encontrado para IMEI $imei e usuário ID $user_id.");
            }
        } catch (Exception $e) {
            $_SESSION['searchError'] = "Erro interno: " . $e->getMessage();
            error_log("Erro no DeviceController: " . $e->getMessage());
        }

        header("Location: /app/views/user/user_dashboard.php");
        exit;
    }

    public function updateDeviceController()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['update_device'])) {
            $_SESSION['updateError'] = 'Método não permitido. Use POST.';
            error_log("Erro no DeviceController: Método inválido ou update_device não definido.");
            header("Location: /app/views/user/user_dashboard.php");
            exit;
        }

        $device_id = trim($_POST['device_id'] ?? '');
        $user_id = $_SESSION['user_id'] ?? 72;
        $data = [
            'imei' => trim($_POST['imei'] ?? ''),
            'marca' => trim($_POST['marca'] ?? ''),
            'modelo' => trim($_POST['modelo'] ?? ''),
            'cor' => trim($_POST['cor'] ?? ''),
            'tipo_dispositivo' => trim($_POST['tipo_dispositivo'] ?? '')
        ];

        error_log("Dados recebidos para atualização: " . json_encode($data));

        if (
            !is_numeric($device_id) || $device_id <= 0 ||
            empty($data['imei']) ||
            empty($data['marca']) ||
            empty($data['modelo']) ||
            empty($data['tipo_dispositivo']) ||
            !in_array($data['tipo_dispositivo'], ['celular', 'laptop'])
        ) {
            $_SESSION['updateError'] = 'Por favor, preencha todos os campos obrigatórios corretamente.';
            error_log("Erro no DeviceController: Campos obrigatórios inválidos ou ausentes para dispositivo ID $device_id.");
            header("Location: /app/views/user/user_dashboard.php");
            exit;
        }

        try {
            $result = $this->deviceModel->updateDevice($device_id, $user_id, $data);
            if ($result) {
                $_SESSION['updateSuccess'] = "Dispositivo atualizado com sucesso!";
            } else {
                $_SESSION['updateError'] = "Erro ao atualizar o dispositivo. Tente novamente.";
                error_log("Erro no DeviceController: Falha ao atualizar dispositivo ID $device_id.");
            }
        } catch (Exception $e) {
            $_SESSION['updateError'] = "Erro interno: " . $e->getMessage();
            error_log("Erro no DeviceController: " . $e->getMessage());
        }

        header("Location: /app/views/user/user_dashboard.php");
        exit;
    }
}

$controller = new DeviceController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register_device']) && $_POST['register_device'] == '1') {
        $controller->registerDeviceController();
    } elseif (isset($_POST['upload_photo']) && $_POST['upload_photo'] == '1') {
        $controller->uploadDevicePhotoController();
    } elseif (isset($_POST['search_imei']) && $_POST['search_imei'] == '1') {
        $controller->searchDeviceController();
    } elseif (isset($_POST['delete_device']) && $_POST['delete_device'] == '1') {
        $deviceId = $_POST['device_id'] ?? null;
        $userId = $_SESSION['user_id'] ?? 72;
        if ($deviceId) {
            $controller->deleteDevice($deviceId, $userId);
        } else {
            $_SESSION['deleteError'] = "ID do dispositivo não fornecido.";
            header("Location: /app/views/user/user_dashboard.php");
            exit;
        }
    } elseif (isset($_POST['update_device']) && $_POST['update_device'] == '1') {
        $controller->updateDeviceController();
    }
}
?>