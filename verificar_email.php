<?php
session_start();

if (!isset($_SESSION['pending_verification_email'])) {
    header('Location: /auth');
    exit;
}

$email = $_SESSION['pending_verification_email'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Email - TraceMz</title>
    <style>
        .verification-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
        }

        .code-input {
            font-size: 24px;
            text-align: center;
            letter-spacing: 10px;
            padding: 10px;
            margin: 20px 0;
            width: 200px;
        }

        .resend-link {
            margin-top: 20px;
            color: #007bff;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="verification-container">
        <h2>Verifique seu Email</h2>
        <p>Enviamos um código de 6 dígitos para: <strong><?php echo htmlspecialchars($email); ?></strong></p>

        <form id="verificationForm">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <input type="text" name="code" class="code-input" maxlength="6" placeholder="000000"
                pattern="[0-9]{6}" required>
            <button type="submit">Verificar</button>
        </form>

        <div class="resend-link" onclick="resendCode()">
            Não recebeu o código? <strong>Reenviar</strong>
        </div>

        <div id="message" style="margin-top: 20px;"></div>
    </div>

</body>

<script src="assets/js/verify_email.js"></script>

</html>