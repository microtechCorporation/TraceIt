<?php
require_once __DIR__ . '/app/configs/database.php';
require_once __DIR__ . '/app/models/userModel.php';
session_start();

if (!isset($_GET['token']) || empty($_GET['token'])) {
    $_SESSION['error'] = 'Token de verificação inválido.';
    header('Location: auth');
    exit;
}

$token = $_GET['token'];
$userModel = new UserModel();

// Verificar token
$usuario = $userModel->verifiedTokenModel($token);

if ($usuario) {
    $sucesso = $userModel->activeUsersModel($usuario['id']);
    
    if ($sucesso) {
        $_SESSION['success'] = 'Email verificado com sucesso! Sua conta agora está ativa.';
        header('Location: /dashboard');
        exit;
    } else {
        $_SESSION['error'] = 'Erro ao ativar conta. Tente novamente.';
    }
} else {
    $_SESSION['error'] = 'Token inválido ou expirado.';
}
?>
<script src="assets/js/signup.js"></script>
