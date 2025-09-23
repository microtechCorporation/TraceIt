<?php
// Arquivo: app/router.php
// Descrição: Roteador simples para mapear ações para Controllers.

session_start();

require_once __DIR__ . '/models/UserModel.php';
require_once __DIR__ . '/models/DeviceModel.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/DeviceController.php';

$action = $_GET['action'] ?? 'dashboard';
$userId = $_SESSION['user_id'] ?? 72; // Fallback para testes

switch ($action) {
    case 'registerDevice':
        $deviceController = new DeviceController();
        $deviceController->registerDeviceController();
        break;
    case 'loadUserData':
        $userController = new UserController();
        $userController->loadUserDataController();
        break;
    default:
        // Renderizar a View (user_dashboard.php)
        require_once __DIR__ . '/views/user/user_dashboard.php';
        break;
}
?>