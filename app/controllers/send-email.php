<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // captura os dados do formulario
    $nome = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subjectForm = $_POST['subject'] ?? '';
    $mensagem = $_POST['message'] ?? '';
    $date = date('d/m/Y H:i:s');

    // corpo do email
    $file  = "Nome: $nome\n";
    $file .= "Email: $email\n";
    $file .= "Assunto: $subjectForm\n";
    $file .= "Mensagem: $mensagem\n";
    $file .= "Data: $date\n";

    // para quem vai o email
    $to = "microtechcorporation@gmail.com";
    $subject = "Contato - Site TraceMz";

    // cabecalho do email
    $headers = "From: $nome <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // envia o email
    if (mail($to, $subject, $file, $headers)) {
        echo "<script>alert('Email enviado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao enviar o email. Tente novamente mais tarde.');</script>";
    }
    echo "<script>window.location.href='../../home.php';</script>";
}
?>
