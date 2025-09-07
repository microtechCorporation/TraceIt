
document.getElementById('verificationForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('app/controllers/userController.php?action=verifyCode', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            const messageDiv = document.getElementById('message');
            messageDiv.style.color = data.success ? 'green' : 'red';
            messageDiv.textContent = data.message;

            if (data.success) {
                setTimeout(() => {
                 window.location.href = '/dashboard';
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
});

function resendCode() {
    const email = '<?php echo $email; ?>';
    const formData = new FormData();
    formData.append('email', email);

    fetch('app/controllers/userController.php?action=resendCode', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            const messageDiv = document.getElementById('message');
            messageDiv.style.color = data.success ? 'green' : 'red';
            messageDiv.textContent = data.message;
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    }