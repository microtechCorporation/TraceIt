
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fs-4">Criar conta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0">
        <div class="d-grid gap-2 mb-4">
          <a href="#" class="btn btn-light border py-2">
            <i class="bi bi-google text-danger me-2"></i> Continuar com Google
          </a>
          <a href="#" class="btn btn-light border py-2">
            <i class="bi bi-facebook text-primary me-2"></i> Continuar com Facebook
          </a>
        </div>
        
        <div class="divider mb-4">ou</div>
        
        <!-- formulario de registo -->
        <form>
          <div class="mb-3">
            <label for="nome" class="form-label">Nome completo</label>
            <input type="text" name="name" class="form-control" id="name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
          </div>
          <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" name="password" class="form-control" id="password" required>
          </div>
            <div class="mb-3">
            <label for="senha2" class="form-label">Confirmar Senha</label>
            <input type="password" name="passconfirm" class="form-control" id="passConfirm" required>
          </div>
          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="checkbox" id="termsCondition" required>
            <label class="form-check-label small" for="termos">
              Concordo com os <a href="#" class="text-danger">Termos</a> e <a href="#" class="text-danger">Privacidade</a>
            </label>
          </div>
          <button type="submit" class="btn btn-danger w-100 py-2 mb-3" style="background-color: var(--accent)">
            Cadastrar
          </button>
        </form>
        
        <div class="text-center small">
          Já tem conta? <a href="#" class="text-danger fw-bold" data-bs-toggle="modal" 
          data-bs-target="#loginModal" data-bs-dismiss="modal">Entrar</a>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .divider {
    display: flex;
    align-items: center;
    text-align: center;
    color: #6c757d;
  }
  
  .divider::before,
  .divider::after {
    content: "";
    flex: 1;
    border-bottom: 1px solid #dee2e6;
  }
  
  .divider::before {
    margin-right: 1rem;
  }
  
  .divider::after {
    margin-left: 1rem;
  }
</style>