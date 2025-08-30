
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<?php
if (isset($_SESSION['success'])) {
    echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: '" . $_SESSION['success'] . "',
                showConfirmButton: true,
                timer: 3000
            });
          </script>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: '" . $_SESSION['error'] . "',
                showConfirmButton: true,
                
            });
          </script>";
    unset($_SESSION['error']);
}
?>
</script>


