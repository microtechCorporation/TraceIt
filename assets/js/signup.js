document.addEventListener('DOMContentLoaded', function () {
    const signupForm = document.getElementById('signupForm');

    if (signupForm) {
        signupForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Obter o botao de submit
            const submitButton = this.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;

            // Mostrar estado de carregamento
            submitButton.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Processando...
            `;
            submitButton.disabled = true;

            // timeout 20 segundos
            const timeoutDuration = 20000;
            const timeoutController = new AbortController();
            const timeoutId = setTimeout(() => timeoutController.abort(), timeoutDuration);

            const formData = new FormData(this);

            // Enviar via a requesicacao via ajx
            fetch('app/controllers/userController.php?action=createAccount', {
                method: 'POST',
                body: formData,
                signal: timeoutController.signal
            })
                .then(response => {
                    clearTimeout(timeoutId);
                    if (!response.ok) {
                        throw new Error('Erro na resposta do servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: data.message,
                            showConfirmButton: true,
                            timer: 20000
                        }).then(() => {

                            signupForm.reset();
                        });
                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: data.message,
                            showConfirmButton: true
                        });
                    }
                })
                .catch(error => {
                    clearTimeout(timeoutId);
                    console.error('Erro:',error);

                    if (error.name === 'AbortError') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Tempo esgotado!',
                            text: 'A requisição demorou muito para responder. Tente novamente.',
                            showConfirmButton: true
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Ocorreu um erro inesperado. Tente novamente.',
                            showConfirmButton: true
                        });
                    }
                })
                .finally(() => {
                    // Restaurar o botao ao estado original
                    submitButton.innerHTML = originalButtonText;
                    submitButton.disabled = false;
                });
        });
    }
});