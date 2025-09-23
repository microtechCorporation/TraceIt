<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../logs/php_errors.log');

session_start();
require_once __DIR__ . '/../../controllers/userController.php';

// Instanciar o UserController
$userController = new UserController();

// Carregar dados do usuário
$user_id = $_SESSION['user_id'] ?? '72'; // Fallback para ID 72, conforme user_dashboard.php
$user = $userController->loadUserDataController($user_id);

if (!$user) {
    $user = ['id' => $user_id, 'nome' => 'Usuário Desconhecido', 'email' => 'N/A', 'criado_em' => 'N/A', 'email_verificado' => false];
}

// Limpar mensagens de sessão após exibir
if (isset($_SESSION['updateSuccess'])) {
    $updateSuccess = $_SESSION['updateSuccess'];
    unset($_SESSION['updateSuccess']);
} else {
    $updateSuccess = null;
}

if (isset($_SESSION['updateError'])) {
    $updateError = $_SESSION['updateError'];
    unset($_SESSION['updateError']);
} else {
    $updateError = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Perfil do Usuário</title>
    <link href="/assets/vendor_userr/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="/assets/css/user_dshb.css" rel="stylesheet" />
    <link href="/assets/css/form.css" rel="stylesheet" />
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="user_dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15"></div>
                <div class="sidebar-brand-text mx-3">Dashboard Usuário</div>
            </a>
            <hr class="sidebar-divider my-0" />
            <li class="nav-item">
                <a class="nav-link" href="user_dashboard.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="user_profile.php">
                    <i class="fas fa-user"></i>
                    <span>Perfil</span>
                </a>
            </li>
            <hr class="sidebar-divider d-none d-md-block" />
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- Conteúdo Principal -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($user['email']); ?></span>
                                <img class="img-profile rounded-circle" src="/assets/img_user/undraw_profile.svg" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="user_profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Terminar Sessão
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- Conteúdo -->
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Perfil do Usuário</h1>
                    <div class="card shadow-lg border-0 rounded-3 mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="m-0 font-weight-bold">Informações do Usuário</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Nome:</strong> <?php echo htmlspecialchars($user['nome']); ?></li>
                                <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
                                <li class="list-group-item"><strong>Data de Registro:</strong> <?php echo date('d/m/Y', strtotime($user['criado_em'])); ?></li>
                                <li class="list-group-item"><strong>Email Verificado:</strong> 
                                    <?php echo $user['email_verificado'] ? '<span class="badge bg-success text-white">Verificado</span>' : '<span class="badge bg-warning text-dark">Não Verificado</span>'; ?>
                                </li>
                            </ul>
                            <div class="mt-3">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">
                                    <i class="fas fa-edit"></i> Editar Perfil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; MicroTech Corporation 2025</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Scroll to Top -->
    <a class="scroll-to-top rounded-scroll" href="#page-top">
        <i class="bi bi-arrow-up-short"></i>
    </a>
    <!-- Modal de Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Deseja Terminar a Sessão?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="/home.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Edição de Perfil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content form-container">
                <div class="modal-header form-header">
                    <img src="/assets/img/logo_trace.png" alt="TraceMz" style="height: 50px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-body">
                    <h5 class="text-center mb-4" id="editProfileModalLabel">Editar Perfil</h5>
                    <form id="editProfileForm" method="POST" action="/app/controllers/userController.php">
                        <input type="hidden" name="update_profile" value="1">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                        <div class="mb-3">
                            <label for="editNome" class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" id="editNome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="editEmail" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-register w-100 py-2 mb-3">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="/assets/vendor_userr/jquery/jquery.min.js"></script>
    <script src="/assets/vendor_userr/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor_userr/jquery-easing/jquery.easing.min.js"></script>
    <script src="/assets/js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Exibir feedback de atualização de perfil
            <?php if (isset($updateSuccess)): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: '<?php echo $updateSuccess; ?>',
                    timer: 2000,
                    showConfirmButton: false
                });
            <?php elseif (isset($updateError)): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: '<?php echo $updateError; ?>',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>

            // Validação do formulário de edição
            const editProfileForm = document.getElementById('editProfileForm');
            if (editProfileForm) {
                editProfileForm.addEventListener('submit', function (e) {
                    const nome = document.getElementById('editNome').value.trim();
                    const email = document.getElementById('editEmail').value.trim();
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (!nome || !email) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Por favor, preencha todos os campos obrigatórios.',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    if (!emailRegex.test(email)) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Por favor, insira um email válido.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    </script>
</body>
</html>