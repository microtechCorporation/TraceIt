<?php
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

        // Coletar e sanitizar dados
        $name = filter_var(trim($_POST['name'] ?? ''), FILTER_SANITIZE_STRING);
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $email = strtolower($email);
        $password = $_POST['password'] ?? '';
        $passconfirm = $_POST['passconfirm'] ?? '';
        $checkbox = isset($_POST['checkbox']) ? true : false;

        // Validar campos vazios
        if (empty($name) || empty($email) || empty($password) || empty($passconfirm)) {
            $this->returnJsonResponse(false, 'Todos os campos são obrigatórios.');
            return;
        }

   
        if (!$checkbox) {
            $this->returnJsonResponse(false, 'Você deve aceitar os termos e condições.');
            return;
        }

        // Validar formato do email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->returnJsonResponse(false, 'Formato de email inválido.');
            return;
        }

        // Validar senha e confirmação
        if ($password !== $passconfirm) {
            $this->returnJsonResponse(false, 'As senhas não coincidem.');
            return;
        }

        // Validar tamanho da senha
        if (strlen($password) < 8) {
            $this->returnJsonResponse(false, 'A senha deve ter no mínimo 8 caracteres.');
            return;
        }

        // Verificar se email existe
        $emailExists = $this->userModel->emailExistsModel($email);

        if ($emailExists) {
            $this->returnJsonResponse(false, 'Email já cadastrado.');
            return;
        }

        // Criar conta e obter token de verificaacao
        $verificationToken = $this->userModel->createUserAccountModel($name, $email, $password);

        if ($verificationToken) {
            // Enviar email de verificao
            $emailSent = $this->sendVerificationEmail($email, $name, $verificationToken);

            if ($emailSent) {
                $this->returnJsonResponse(true, 'Conta criada com sucesso! Verifique seu email para ativar sua conta.');
            } else {
                $this->returnJsonResponse(false, 'Conta criada, mas falha ao enviar email de verificação. Entre em contato com o suporte.');
            }
        } else {
            $this->returnJsonResponse(false, 'Ocorreu um erro ao criar a conta.');
        }
    }

    private function sendVerificationEmail($email, $name, $token)
    {
        try {
            require_once __DIR__ . '/../../vendor/autoload.php';

            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            $activationLink = $this->generateActivationLink($token);

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
            $mail->Subject = 'Confirme seu email - ' . $_SERVER['HTTP_HOST'];
            $mail->Body = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <title>Confirmação de Email</title>
            </head>
            <body style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
                    <h2 style='color: #333; text-align: center;'>Olá {$name}!</h2>
                    
                    <p>Obrigado por se cadastrar em nossa plataforma. Para ativar sua conta, clique no botão abaixo:</p>
                    
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='{$activationLink}' 
                           style='background-color:  #dc3545;color: white; padding: 15px 30px; 
                                  text-decoration: none; border-radius: 5px; font-size: 16px; 
                                  display: inline-block;'>
                            ✅ Confirmar Email
                        </a>
                    </div>
                    
                    <p>Se o botão não funcionar, copie e cole este link no seu navegador:</p>
                    <p style='background-color: #f8f9fa; padding: 10px; border-radius: 5px; 
                              word-break: break-all; font-size: 14px;'>
                        {$activationLink}
                    </p>
                    
                    <div style='margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;'>
                        <p style='color: #dc3545; font-size: 15px;'>
                            <strong>Importante:</strong> Este link expira em 24 horas.<br>
                            Se você não se cadastrou, ignore este email.
                        </p>
                    </div>
                </div>
            </body>
            </html>
        ";

            $mail->AltBody = "Olá {$name}!\n\nPara confirmar seu email, acesse: {$activationLink}\n\nEste link expira em 24 horas.";

            return $mail->send();
        } catch (Exception $e) {
            error_log("Erro ao enviar email para {$email}: " . $e->getMessage());
            return false;
        }
    }
    private function generateActivationLink($token)
    {
        $host = $_SERVER['HTTP_HOST'];
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $port = $_SERVER['SERVER_PORT'];

        $isLocalhost = ($host === 'localhost' ||
            $host === '127.0.0.1' ||
            strpos($host, 'localhost:') !== false);

        if ($isLocalhost) {

            $localIP = gethostbyname(gethostname());

            $portSuffix = ($port != 80 && $port != 443) ? ":{$port}" : "";

            return "{$protocol}://{$localIP}{$portSuffix}/verificar_email.php?token=" . urlencode($token);
        } else {
            $portSuffix = (($protocol === 'http' && $port != 80) || ($protocol === 'https' && $port != 443)) ? ":{$port}" : "";
            return "{$protocol}://{$host}{$portSuffix}/verificar_email.php?token=" . urlencode($token);
        }
    }
    public function returnJsonResponse($success, $message)
    {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);
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
        default:
            $controller->returnJsonResponse(false, 'Ação inválida!');
            break;
    }
}
