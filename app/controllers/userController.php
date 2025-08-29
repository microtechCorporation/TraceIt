<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Device.php';

class UserController {
    private $userModel;
    private $deviceModel;

    public function __construct() {
        $this->userModel = new User();
        $this->deviceModel = new Device();
    }

    public function dashboard() {
        // // Iniciar a sessão
        // session_start();

        // // Verificar se o usuário está logado
        // if (!isset($_SESSION['user_id'])) {
        //     header('Location: /TraceIt/login.php'); // Redireciona para login se não estiver logado
        //     exit;
        // }

        // Obter dados do usuário 
        $user_id = 1; // Aqui substituir por $_SESSION['user_id'] quando o login estiver implementado
        $user = $this->userModel->getUserById($user_id);

        // Obter dispositivos do usuário
        $devices = $this->deviceModel->getDevicesByUserId($user_id);

        // Carregar a visão com os dados
        require_once __DIR__ . '/../views/user/user_dashboard.php';
    }
}


$controller = new UserController();
$controller->dashboard();

?>