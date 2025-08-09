
    document.getElementById('current-year').textContent = new Date().getFullYear();
    // Abre modal de login
    document.querySelectorAll('[href="#login"]').forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
      });
    });

    // Abre modal de cadastro
    document.querySelectorAll('[href="#cadastro"]').forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        var registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
        registerModal.show();
      });
    });

    // animacoes ao abrir modal
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true
    });
