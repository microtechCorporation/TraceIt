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
      <h1 class="signup-title">Criar Conta</h1>
      <p class="signup-subtitle">Junte-se a nós preenchendo seus dados abaixo</p>
    </div>

    <div class="signup-body">
      <div class="d-grid gap-2">
        <a href="#" class="btn btn-social">
          <i class="bi bi-google text-danger me-2"></i> Continuar com Google
        </a>
        <a href="#" class="btn btn-social">
          <i class="bi bi-facebook text-primary me-2"></i> Continuar com Facebook
        </a>
      </div>

      <div class="divider">ou</div>

      <!-- Formul de registro -->
      <form id="signupForm" method="POST">
        <div class="mb-3">
          <label for="registerName" class="form-label">Nome completo</label>
          <input type="text" name="name" class="form-control" id="registerName" required>
        </div>

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

        <div class="mb-3">
          <label for="registerPassConfirm" class="form-label">Confirmar Senha</label>
          <div class="password-input-group">
            <input type="password" name="passconfirm" class="form-control" id="registerPassConfirm" required>
          </div>
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="checkbox" id="termsCondition" required>
          <label class="form-check-label terms-text" for="termsCondition">
            Aceito os <a href="#" class="text-danger">Termos</a> e <a href="#" class="text-danger">Política de Privacidade</a>
          </label>
        </div>

        <button type="submit" class="btn btn-register w-100 py-2 mb-3">
          Criar conta
        </button>
      </form>

      <div class="text-center small">
        Já tem uma conta? <a href="auth.php" class="login-link">Entrar</a>
      </div>
    </div>
  </div>
</body>

</html>