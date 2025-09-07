<?php
session_start();
require_once __DIR__ . '/../models/userModel.php';
class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function createUserAccountController()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->returnJsonResponse(false, 'Método não permitido. Use POST.');
            return;
        }

        $name = filter_var(trim($_POST['name'] ?? ''), FILTER_SANITIZE_STRING);
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $email = strtolower($email);
        $password = $_POST['password'] ?? '';
        $passconfirm = $_POST['passconfirm'] ?? '';
        $checkbox = isset($_POST['checkbox']) ? true : false;

        if (empty($name) || empty($email) || empty($password) || empty($passconfirm)) {
            $this->returnJsonResponse(false, 'Todos os campos são obrigatórios.');
            return;
        }

        if (!$checkbox) {
            $this->returnJsonResponse(false, 'Você deve aceitar os termos e condições.');
            return;
        }


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->returnJsonResponse(false, 'Formato de email inválido.');
            return;
        }

        if ($password !== $passconfirm) {
            $this->returnJsonResponse(false, 'As senhas não coincidem.');
            return;
        }

        if (strlen($password) < 8) {
            $this->returnJsonResponse(false, 'A senha deve ter no mínimo 8 caracteres.');
            return;
        }

        $emailExists = $this->userModel->emailExistsModel($email);

        if ($emailExists) {
            $this->returnJsonResponse(false, 'Email já cadastrado.');
            return;
        }

        // Criar conta e obter código de verifica
        $verificationCode = $this->userModel->createUserAccountModel($name, $email, $password);

        if ($verificationCode) {
            // Armazenar email na sessão para verificao
            $_SESSION['pending_verification_email'] = $email;
            // Enviar email de verifica
            $emailSent = $this->sendVerificationEmail($email, $name, $verificationCode);

            if ($emailSent) {
                $this->returnJsonResponse(true, 'Conta criada com sucesso! Verifique seu email pelo código de verificação.', [
                    'requires_verification' => true,
                    'email' => $email
                ]);
            } else {
                $this->returnJsonResponse(false, 'Conta criada, mas falha ao enviar email de verificação. Entre em contato com o suporte.');
            }
        } else {
            $this->returnJsonResponse(false, 'Ocorreu um erro ao criar a conta.');
        }
    }

    // Verificar code enviado pelo usuário
    public function verifyCodeController()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->returnJsonResponse(false, 'Método não permitido. Use POST.');
            return;
        }

        $email = $_POST['email'] ?? '';
        $code = $_POST['code'] ?? '';

        if (empty($email) || empty($code)) {
            $this->returnJsonResponse(false, 'Email e código são obrigatórios.');
            return;
        }

        // Verificar código
        $usuario = $this->userModel->verifyCodeModel($email, $code);

        if ($usuario) {
            // Ativar conta
            $sucesso = $this->userModel->activeUsersModel($usuario['id']);

            if ($sucesso) {
                unset($_SESSION['pending_verification_email']);
                $_SESSION['user_id'] = $usuario['id'];
                unset($_SESSION['pending_verification_email']);

                $this->returnJsonResponse(true, 'Email verificado com sucesso! Sua conta agora está ativa.');
            } else {
                $this->returnJsonResponse(false, 'Erro ao ativar conta. Tente novamente.');
            }
        } else {
            $this->returnJsonResponse(false, 'Código inválido ou expirado.');
        }
    }

    public function loadUserDataController()
    {
        $userModel = new UserModel();
        $user = $userModel->loadUserDataModel($_SESSION['user_id']);
        $this->returnJsonResponse(true, 'Usuário carregado com sucesso!', $user);
    }

    // Reenviar código de verificação
    public function resendCodeController()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->returnJsonResponse(false, 'Método não permitido. Use POST.');
            return;
        }

        $email = $_POST['email'] ?? '';

        if (empty($email)) {
            $this->returnJsonResponse(false, 'Email é obrigatório.');
            return;
        }

        $newCode = $this->userModel->resendVerificationCodeModel($email);

        if ($newCode) {
            // Buscar nome do usurio para o email
            $user = $this->userModel->getUserByEmail($email);
            $name = $user ? $user['nome'] : 'Usuário';

            $emailSent = $this->sendVerificationEmail($email, $name, $newCode);

            if ($emailSent) {
                $this->returnJsonResponse(true, 'Código reenviado com sucesso! Verifique seu email.');
            } else {
                $this->returnJsonResponse(false, 'Código gerado, mas falha ao enviar email.');
            }
        } else {
            $this->returnJsonResponse(false, 'Erro ao reenviar código. Verifique se o email está correto.');
        }
    }


    private function sendVerificationEmail($email, $name, $code)
    {
        try {
            require_once __DIR__ . '/../../vendor/autoload.php';

            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'microtechcorporationn@gmail.com';
            $mail->Password = 'pvlq frbt rugz nwad';
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('microtechcorporationn@gmail.com', 'TraceMz');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Seu código de verificação - ' . $_SERVER['HTTP_HOST'];
            $mail->Body = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <title>Código de Verificação</title>
            </head>
            <body style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
                    <h2 style='color: #333; text-align: center;'>Olá {$name}!</h2>
                    
                    <p>Seu código de verificação para ativar sua conta é:</p>
                    
                    <div style='text-align: center; margin: 30px 0;'>
                        <div style='background-color: #dc3545; color: white; padding: 15px 30px; 
                                  border-radius: 5px; font-size: 24px; font-weight: bold; 
                                  display: inline-block; letter-spacing: 5px;'>
                            {$code}
                        </div>
                    </div>
                    
                    <p>Digite este código na página de verificação para ativar sua conta.</p>
                    
                    <div style='margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;'>
                        <p style='color: #dc3545; font-size: 15px;'>
                            <strong>Importante:</strong> Este código expira em 10 minutos.<br>
                            Se você não se cadastrou, ignore este email.
                        </p>
                    </div>
                </div>
            </body>
            </html>
        ";
            $mail->AltBody = "Olá {$name}!\n\nSeu código de verificação é: {$code}\n\nDigite este código para ativar sua conta.\n\nEste código expira em 10 minutos.";

            return $mail->send();
        } catch (Exception $e) {
            error_log("Erro ao enviar email para {$email}: " . $e->getMessage());
            return false;
        }
    }

    public function returnJsonResponse($success, $message, $data = [])
    {
        header('Content-Type: application/json');
        $response = [
            'success' => $success,
            'message' => $message
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        echo json_encode($response);
        exit;
    }
}



if (isset($_GET['action']) && basename($_SERVER['SCRIPT_NAME']) === 'userController.php') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $action = $_GET['action'];
    $controller = new UserController();

    switch ($action) {
        case 'createAccount':
            $controller->createUserAccountController();
            break;
        case 'verifyCode':
            $controller->verifyCodeController();
            break;
        case 'resendCode':
            $controller->resendCodeController();
            break;
        default:
            $controller->returnJsonResponse(false, 'Ação inválida!');
            break;
    }
}
