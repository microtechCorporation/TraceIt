<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title">Acesse sua conta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <!-- formulario de login-->

        <form>
          <div class="mb-3">
            <label for="loginEmail" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="loginEmail" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" class="form-control" id="password" required>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="chekbox" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Lembrar-me</label>
            </div>
            <a href="#recuperar-senha" class="text-danger small">Esqueceu a senha?</a>
          </div>
          <button type="submit" class="btn btn-danger w-100 btn-lg">Entrar</button>

        </form>
        <div class="text-center mt-3">
          <p>Não tem uma conta? <a href="#" class="text-danger fw-bold" data-bs-toggle="modal"
              data-bs-target="#registerModal" data-bs-dismiss="modal">Cadastre-se</a></p>
        </div>
      </div>
    </div>
  </div>
</div>