<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastre-se - Nossa Plataforma</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/signup.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/js/signup.js"></script>
</head>
<body>
  <div class="signup-container">
    <div class="signup-header">
     <img src="assets/img/logo_trace.png" alt="TraceMz" style="height: 50px;">
    </div>

    <div class="signup-body">
      <div class="d-grid gap-2">
        <a href="#" class="btn btn-social">
          <i class="bi bi-google text-danger me-2"></i> Continuar com Google
        </a>
      </div>

      <div class="divider">ou</div>

      <!-- Formul de registro -->
      <form id="siginForm" method="POST">
     
        <div class="mb-3">
          <label for="registerEmail" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" id="registerEmail" required>
        </div>

        <div class="mb-3">
          <label for="registerPassword" class="form-label">Senha</label>
          <div class="password-input-group">
            <input type="password" name="password" class="form-control" id="registerPassword" required>

          </div>
        </div>

        <button type="submit" class="btn btn-register w-100 py-2 mb-3">
          Entrar
        </button>
      </form>

      <div class="text-center small">
        Nao possue uma conta ? <a href="signup" class="login-link">registe agora</a>
      </div>
    </div>
  </div>
</body>

</html>