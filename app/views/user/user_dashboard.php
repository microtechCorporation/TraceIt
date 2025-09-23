<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../logs/php_errors.log');

session_start();
require_once __DIR__ . '/../../controllers/userController.php';
require_once __DIR__ . '/../../controllers/deviceController.php';
require_once __DIR__ . '/../../controllers/OcorrenciaController.php';

$userController = new UserController();
$deviceController = new DeviceController();
$ocorrenciaController = new OcorrenciaController();

// Carregar dados do usuário via Controller
$user = $userController->loadUserDataController('72');

// Carregar dispositivos via Controller
$devices = $deviceController->loadUserDevicesController('72');

if (!$devices) {
    $devices = [];
}

// Limpar mensagens de sessão após exibir (evita repetição)
if (isset($_SESSION['registerSuccess'])) {
    $registerSuccess = $_SESSION['registerSuccess'];
    unset($_SESSION['registerSuccess']);
} else {
    $registerSuccess = null;
}

if (isset($_SESSION['registerError'])) {
    $registerError = $_SESSION['registerError'];
    unset($_SESSION['registerError']);
} else {
    $registerError = null;
}

if (isset($_SESSION['ocorrenciaSuccess'])) {
    $ocorrenciaSuccess = $_SESSION['ocorrenciaSuccess'];
    unset($_SESSION['ocorrenciaSuccess']);
} else {
    $ocorrenciaSuccess = null;
}

if (isset($_SESSION['ocorrenciaError'])) {
    $ocorrenciaError = $_SESSION['ocorrenciaError'];
    unset($_SESSION['ocorrenciaError']);
} else {
    $ocorrenciaError = null;
}

if (isset($_SESSION['searchSuccess'])) {
    $searchSuccess = $_SESSION['searchSuccess'];
    unset($_SESSION['searchSuccess']);
} else {
    $searchSuccess = null;
}

if (isset($_SESSION['searchError'])) {
    $searchError = $_SESSION['searchError'];
    unset($_SESSION['searchError']);
} else {
    $searchError = null;
}

if (isset($_SESSION['searchResult'])) {
    $searchResult = $_SESSION['searchResult'];
    unset($_SESSION['searchResult']);
} else {
    $searchResult = null;
}

if (isset($_SESSION['photoSuccess'])) {
    $photoSuccess = $_SESSION['photoSuccess'];
    unset($_SESSION['photoSuccess']);
} else {
    $photoSuccess = null;
}

if (isset($_SESSION['photoError'])) {
    $photoError = $_SESSION['photoError'];
    unset($_SESSION['photoError']);
} else {
    $photoError = null;
}

if (isset($_SESSION['deleteSuccess'])) {
    $deleteSuccess = $_SESSION['deleteSuccess'];
    unset($_SESSION['deleteSuccess']);
} else {
    $deleteSuccess = null;
}

if (isset($_SESSION['deleteError'])) {
    $deleteError = $_SESSION['deleteError'];
    unset($_SESSION['deleteError']);
} else {
    $deleteError = null;
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
  <title>Dashboard</title>
  <link href="/assets/vendor_userr/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
  <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="/assets/css/user_dshb.css" rel="stylesheet" />
  <link href="/assets/css/form.css" rel="stylesheet" />
 
</head>

<body id="page-top">
  <div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="user_dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15"></div>
        <div class="sidebar-brand-text mx-3">Dashboard Usuário</div>
      </a>
      <hr class="sidebar-divider my-0" />
      <hr class="sidebar-divider" />
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="bi bi-pencil-square"></i>
          <span>Registro de Dispositivos</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Registrar Dispositivos</h6>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#registerCelularModal">Celular</a>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#registerLaptopModal">Laptop</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="bi bi-emoji-astonished-fill"></i>
          <span>Reporte de Ocorrência</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Reportar Ocorrência</h6>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#reportFurtoModal">Furto</a>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#reportPerdaModal">Perda</a>
          </div>
        </div>
      </li>
      <hr class="sidebar-divider d-none d-md-block" />
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="POST" action="/app/controllers/deviceController.php">
            <div class="input-group">
              <input type="text" name="imei" class="form-control bg-light border-0 small" placeholder="Consultar IMEI..." aria-label="Search" aria-describedby="basic-addon2" />
              <input type="hidden" name="search_imei" value="1">
              <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search" method="POST" action="/app/controllers/deviceController.php">
                  <div class="input-group">
                    <input type="text" name="imei" class="form-control bg-light border-0 small" placeholder="Consultar IMEI..." aria-label="Search" aria-describedby="basic-addon2" />
                    <input type="hidden" name="search_imei" value="1">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Notificações</h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">Data</div>
                    <span class="font-weight-bold">Notificação</span>
                  </div>
                </a>
              </div>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
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
        <div class="container-fluid">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bem-vindo, <?php echo htmlspecialchars($user['nome']); ?>!</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
              <i class="fas fa-download fa-sm text-white-50"></i> Gerar Relatório
            </a>
          </div>
          <!-- Resultado da Pesquisa -->
          <?php if ($searchResult): ?>
            <div class="card shadow-lg border-0 rounded-3 mb-4">
              <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold">🔍 Resultado da Pesquisa por IMEI</h6>
                <div>
                  <a href="#" class="edit-btn" data-toggle="modal" data-target="#editDeviceModal"
                     data-device-id="<?php echo htmlspecialchars($searchResult['id']); ?>"
                     data-imei="<?php echo htmlspecialchars($searchResult['imei']); ?>"
                     data-marca="<?php echo htmlspecialchars($searchResult['marca']); ?>"
                     data-modelo="<?php echo htmlspecialchars($searchResult['modelo']); ?>"
                     data-cor="<?php echo htmlspecialchars($searchResult['cor'] ?? ''); ?>"
                     data-tipo="<?php echo htmlspecialchars($searchResult['tipo_dispositivo']); ?>">
                    <i class="fas fa-edit"></i> Editar
                  </a>
                  <a href="#" class="delete-btn" data-device-id="<?php echo htmlspecialchars($searchResult['id']); ?>" data-user-id="<?php echo htmlspecialchars($user['id']); ?>" title="Deletar Dispositivo">
                    <i class="fas fa-trash-alt"></i> Excluir
                  </a>
                </div>
              </div>
              <div class="card-body">
                <h5>Detalhes do Dispositivo</h5>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><strong>IMEI:</strong> <?php echo htmlspecialchars($searchResult['imei']); ?></li>
                  <li class="list-group-item"><strong>Tipo:</strong> <?php echo htmlspecialchars(ucfirst($searchResult['tipo_dispositivo'] ?? 'N/A')); ?></li>
                  <li class="list-group-item"><strong>Marca:</strong> <?php echo htmlspecialchars($searchResult['marca']); ?></li>
                  <li class="list-group-item"><strong>Modelo:</strong> <?php echo htmlspecialchars($searchResult['modelo']); ?></li>
                  <li class="list-group-item"><strong>Cor:</strong> <?php echo htmlspecialchars($searchResult['cor'] ?? 'N/A'); ?></li>
                  <li class="list-group-item"><strong>Status:</strong> 
                    <?php
                    switch ($searchResult['status']) {
                      case 'ativo':
                        echo '<span class="badge bg-success text-white">Ativo</span>';
                        break;
                      case 'roubado':
                        echo '<span class="badge bg-danger text-white">Roubado</span>';
                        break;
                      case 'perdido':
                        echo '<span class="badge bg-warning text-dark">Perdido</span>';
                        break;
                      default:
                        echo '<span class="badge bg-secondary text-white">Desconhecido</span>';
                    }
                    ?>
                  </li>
                  <li class="list-group-item"><strong>Data de Registro:</strong> <?php echo date('d/m/Y', strtotime($searchResult['criado_em'])); ?></li>
                  <?php if (!empty($searchResult['fotos'])): ?>
                    <li class="list-group-item"><strong>Foto:</strong> 
                      <a href="#" data-toggle="modal" data-target="#viewImageModal" data-image-src="<?php echo htmlspecialchars($searchResult['fotos']); ?>">
                        <img src="<?php echo htmlspecialchars($searchResult['fotos']); ?>" class="device-img" alt="Foto do dispositivo">
                      </a>
                    </li>
                  <?php endif; ?>
                </ul>
                <?php if (!empty($searchResult['ocorrencias'])): ?>
                  <h5 class="mt-4">Ocorrências Associadas</h5>
                  <div class="table-responsive">
                    <table class="table table-hover align-middle">
                      <thead class="table-primary">
                        <tr>
                          <th>Tipo</th>
                          <th>Data</th>
                          <th>Local</th>
                          <th>Descrição</th>
                          <th>Status</th>
                          <th>Data de Registro</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($searchResult['ocorrencias'] as $ocorrencia): ?>
                          <tr>
                            <td><?php echo htmlspecialchars(ucfirst($ocorrencia['tipo'])); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($ocorrencia['data_ocorrencia'])); ?></td>
                            <td><?php echo htmlspecialchars($ocorrencia['local']); ?></td>
                            <td><?php echo htmlspecialchars($ocorrencia['descricao'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($ocorrencia['status']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($ocorrencia['criado_em'])); ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                <?php else: ?>
                  <div class="alert alert-info text-center mt-4">
                    Nenhuma ocorrência registrada para este dispositivo.
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary-pink text-uppercase mb-1">
                        # Dispositivos Registados
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo count($devices); ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-mobile-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4"></div>
            <div class="col-xl-3 col-md-6 mb-4"></div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Dispositivos em Alerta
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo count(array_filter($devices, fn($device) => in_array($device['status'], ['roubado', 'perdido']))); ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary-lilas">
                    Status dos Dispositivos
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                    Status aqui
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary-lilas">
                    Distribuição de Status
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Ativo
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-danger"></i> Roubado
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-warning"></i> Perdido
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card shadow-lg border-0 rounded-3 mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              <h6 class="m-0 font-weight-bold">📱 Dispositivos Registrados</h6>
            </div>
            <div class="card-body">
              <?php if (!empty($devices)): ?>
                <div class="table-responsive">
                  <table class="table table-hover align-middle">
                    <thead class="table-primary">
                      <tr>
                        <th>Imagem</th>
                        <th>IMEI</th>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Cor</th>
                        <th>Status</th>
                        <th>Data de Registro</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($devices as $device): ?>
                        <tr>
                          <td>
                            <?php if (!empty($device['fotos'])): ?>
                              <a href="#" data-toggle="modal" data-target="#viewImageModal" data-image-src="<?php echo htmlspecialchars($device['fotos']); ?>">
                                <img src="<?php echo htmlspecialchars($device['fotos']); ?>" class="device-img" alt="Foto do dispositivo">
                              </a>
                            <?php else: ?>
                              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#uploadPhotoModal" data-device-id="<?php echo htmlspecialchars($device['id']); ?>">
                                Carregar Imagem
                              </button>
                            <?php endif; ?>
                          </td>
                          <td><code><?php echo htmlspecialchars($device['imei']); ?></code></td>
                          <td><?php echo htmlspecialchars(ucfirst($device['tipo_dispositivo'] ?? 'N/A')); ?></td>
                          <td><?php echo htmlspecialchars($device['marca']); ?></td>
                          <td><?php echo htmlspecialchars($device['modelo']); ?></td>
                          <td><?php echo htmlspecialchars($device['cor'] ?? 'N/A'); ?></td>
                          <td>
                            <?php
                            switch ($device['status']) {
                              case 'ativo':
                                echo '<span class="badge bg-success text-white">Ativo</span>';
                                break;
                              case 'roubado':
                                echo '<span class="badge bg-danger text-white">Roubado</span>';
                                break;
                              case 'perdido':
                                echo '<span class="badge bg-warning text-dark">Perdido</span>';
                                break;
                              default:
                                echo '<span class="badge bg-secondary text-white">Desconhecido</span>';
                            }
                            ?>
                          </td>
                          <td><?php echo date('d/m/Y', strtotime($device['criado_em'])); ?></td>
                          <td>
                            <a href="#" class="edit-btn" data-toggle="modal" data-target="#editDeviceModal"
                               data-device-id="<?php echo htmlspecialchars($device['id']); ?>"
                               data-imei="<?php echo htmlspecialchars($device['imei']); ?>"
                               data-marca="<?php echo htmlspecialchars($device['marca']); ?>"
                               data-modelo="<?php echo htmlspecialchars($device['modelo']); ?>"
                               data-cor="<?php echo htmlspecialchars($device['cor'] ?? ''); ?>"
                               data-tipo="<?php echo htmlspecialchars($device['tipo_dispositivo']); ?>">
                              
                            </a>
                           
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php else: ?>
                <div class="alert alert-info text-center m-0">
                  Nenhum dispositivo encontrado.
                </div>
              <?php endif; ?>
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
  <a class="scroll-to-top rounded-scroll" href="#page-top">
    <i class="bi bi-arrow-up-short"></i>
  </a>
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Deseja Terminar a Sessão?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="../../../home.php">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="registerCelularModal" tabindex="-1" role="dialog" aria-labelledby="registerCelularModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content form-container">
        <div class="modal-header form-header">
          <img src="/assets/img/logo_trace.png" alt="TraceMz" style="height: 50px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body form-body">
          <h5 class="text-center mb-4" id="registerCelularModalLabel">Registrar Celular</h5>
          <form id="registerCelularForm" method="POST" action="/app/controllers/deviceController.php" enctype="multipart/form-data">
            <input type="hidden" name="register_device" value="1">
            <input type="hidden" name="tipo_dispositivo" value="celular">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
            <div class="mb-3">
              <label for="imeiCelular" class="form-label">IMEI</label>
              <input type="text" name="imei" class="form-control" id="imeiCelular" required>
            </div>
            <div class="mb-3">
              <label for="marcaCelular" class="form-label">Marca</label>
              <input type="text" name="marca" class="form-control" id="marcaCelular" required>
            </div>
            <div class="mb-3">
              <label for="modeloCelular" class="form-label">Modelo</label>
              <input type="text" name="modelo" class="form-control" id="modeloCelular" required>
            </div>
            <div class="mb-3">
              <label for="corCelular" class="form-label">Cor (Opcional)</label>
              <input type="text" name="cor" class="form-control" id="corCelular">
            </div>
            <div class="mb-3">
              <label for="fotoCelular" class="form-label ">Foto do Dispositivo (Opcional, máx. 5MB, JPEG/PNG/GIF)</label>
              <input type="file" name="foto" class="form-control btn-primary" id="fotoCelular" accept="image/jpeg,image/png,image/gif">
            </div>
            <button type="submit" class="btn btn-register w-100 py-2 mb-3">Registrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="registerLaptopModal" tabindex="-1" role="dialog" aria-labelledby="registerLaptopModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content form-container">
        <div class="modal-header form-header">
          <img src="/assets/img/logo_trace.png" alt="TraceMz" style="height: 50px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body form-body">
          <h5 class="text-center mb-4" id="registerLaptopModalLabel">Registrar Laptop</h5>
          <form id="registerLaptopForm" method="POST" action="/app/controllers/deviceController.php" enctype="multipart/form-data">
            <input type="hidden" name="register_device" value="1">
            <input type="hidden" name="tipo_dispositivo" value="laptop">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
            <div class="mb-3">
              <label for="imeiLaptop" class="form-label">Número de Série</label>
              <input type="text" name="imei" class="form-control" id="imeiLaptop" required>
            </div>
            <div class="mb-3">
              <label for="marcaLaptop" class="form-label">Marca</label>
              <input type="text" name="marca" class="form-control" id="marcaLaptop" required>
            </div>
            <div class="mb-3">
              <label for="modeloLaptop" class="form-label">Modelo</label>
              <input type="text" name="modelo" class="form-control" id="modeloLaptop" required>
            </div>
            <div class="mb-3">
              <label for="corLaptop" class="form-label">Cor (Opcional)</label>
              <input type="text" name="cor" class="form-control" id="corLaptop">
            </div>
            <div class="mb-3">
              <label for="fotoLaptop" class="form-label">Foto do Dispositivo (Opcional, máx. 5MB, JPEG/PNG/GIF)</label>
              <input type="file" name="foto" class="form-control btn-primary" id="fotoLaptop" accept="image/jpeg,image/png,image/gif">
            </div>
            <button type="submit" class="btn btn-register w-100 py-2 mb-3">Registrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="reportFurtoModal" tabindex="-1" role="dialog" aria-labelledby="reportFurtoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content form-container">
        <div class="modal-header form-header">
          <img src="/assets/img/logo_trace.png" alt="TraceMz" style="height: 50px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body form-body">
          <h5 class="text-center mb-4" id="reportFurtoModalLabel">Reportar Furto</h5>
          <?php if (empty($devices)): ?>
            <div class="alert alert-warning text-center">
              Nenhum dispositivo registrado. Registre um dispositivo antes de reportar uma ocorrência.
            </div>
          <?php else: ?>
            <form id="reportFurtoForm" method="POST" action="/app/controllers/OcorrenciaController.php">
              <input type="hidden" name="registrar_ocorrencia" value="1">
              <input type="hidden" name="tipo" value="furto">
              <div class="mb-3">
                <label for="dispositivoFurto" class="form-label">Dispositivo</label>
                <select name="dispositivo_id" class="form-control" id="dispositivoFurto" required>
                  <option value="">Selecione um dispositivo</option>
                  <?php foreach ($devices as $device): ?>
                    <option value="<?php echo htmlspecialchars($device['id']); ?>">
                      <?php echo htmlspecialchars($device['imei'] . ' - ' . $device['marca'] . ' ' . $device['modelo']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="dataFurto" class="form-label">Data da Ocorrência</label>
                <input type="date" name="data_ocorrencia" class="form-control" id="dataFurto" required max="<?php echo date('Y-m-d'); ?>">
              </div>
              <div class="mb-3">
                <label for="localFurto" class="form-label">Local</label>
                <input type="text" name="local" class="form-control" id="localFurto" required>
              </div>
              <div class="mb-3">
                <label for="descricaoFurto" class="form-label">Descrição (Opcional)</label>
                <textarea name="descricao" class="form-control" id="descricaoFurto" rows="4"></textarea>
              </div>
              <button type="submit" class="btn btn-register w-100 py-2 mb-3">Reportar</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="reportPerdaModal" tabindex="-1" role="dialog" aria-labelledby="reportPerdaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content form-container">
        <div class="modal-header form-header">
          <img src="/assets/img/logo_trace.png" alt="TraceMz" style="height: 50px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body form-body">
          <h5 class="text-center mb-4" id="reportPerdaModalLabel">Reportar Perda</h5>
          <?php if (empty($devices)): ?>
            <div class="alert alert-warning text-center">
              Nenhum dispositivo registrado. Registre um dispositivo antes de reportar uma ocorrência.
            </div>
          <?php else: ?>
            <form id="reportPerdaForm" method="POST" action="/app/controllers/OcorrenciaController.php">
              <input type="hidden" name="registrar_ocorrencia" value="1">
              <input type="hidden" name="tipo" value="perda">
              <div class="mb-3">
                <label for="dispositivoPerda" class="form-label">Dispositivo</label>
                <select name="dispositivo_id" class="form-control" id="dispositivoPerda" required>
                  <option value="">Selecione um dispositivo</option>
                  <?php foreach ($devices as $device): ?>
                    <option value="<?php echo htmlspecialchars($device['id']); ?>">
                      <?php echo htmlspecialchars($device['imei'] . ' - ' . $device['marca'] . ' ' . $device['modelo']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="dataPerda" class="form-label">Data da Ocorrência</label>
                <input type="date" name="data_ocorrencia" class="form-control" id="dataPerda" required max="<?php echo date('Y-m-d'); ?>">
              </div>
              <div class="mb-3">
                <label for="localPerda" class="form-label">Local</label>
                <input type="text" name="local" class="form-control" id="localPerda" required>
              </div>
              <div class="mb-3">
                <label for="descricaoPerda" class="form-label">Descrição (Opcional)</label>
                <textarea name="descricao" class="form-control" id="descricaoPerda" rows="4"></textarea>
              </div>
              <button type="submit" class="btn btn-register w-100 py-2 mb-3">Reportar</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal " id="uploadPhotoModal" tabindex="-1" role="dialog" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content form-container">
        <div class="modal-header form-header">
          <img src="/assets/img/logo_trace.png" alt="TraceMz" style="height: 50px;">
          <button type="button" class="close " data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body form-body">
          <h5 class="text-center mb-4 btn btn-sm btn-primary" id="uploadPhotoModalLabel">Carregar Foto do Dispositivo</h5>
          <form id="uploadPhotoForm" method="POST" action="/app/controllers/deviceController.php" enctype="multipart/form-data">
            <input type="hidden" name="upload_photo" value="1">
            <input type="hidden" name="device_id" id="uploadDeviceId">
            <div class="mb-3">
              <label for="fotoUpload" class="form-label fade btn btn-sm btn-primary">Foto do Dispositivo (máx. 5MB, JPEG/PNG/GIF)</label>
              <input class="btn btn-sm btn-primary" type="file" name="foto" class="form-control" id="fotoUpload" accept="image/jpeg,image/png,image/gif" required>
            </div>
            <button type="submit" class="btn btn-register w-100 py-2 mb-3">Carregar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editDeviceModal" tabindex="-1" role="dialog" aria-labelledby="editDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content form-container">
        <div class="modal-header form-header">
          <img src="/assets/img/logo_trace.png" alt="TraceMz" style="height: 50px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body form-body">
          <h5 class="text-center mb-4" id="editDeviceModalLabel">Editar Dispositivo</h5>
          <form id="editDeviceForm" method="POST" action="/app/controllers/deviceController.php">
            <input type="hidden" name="update_device" value="1">
            <input type="hidden" name="device_id" id="editDeviceId">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
            <div class="mb-3">
              <label for="editImei" class="form-label">IMEI</label>
              <input type="text" name="imei" class="form-control" id="editImei" required>
            </div>
            <div class="mb-3">
              <label for="editMarca" class="form-label">Marca</label>
              <input type="text" name="marca" class="form-control" id="editMarca" required>
            </div>
            <div class="mb-3">
              <label for="editModelo" class="form-label">Modelo</label>
              <input type="text" name="modelo" class="form-control" id="editModelo" required>
            </div>
            <div class="mb-3">
              <label for="editCor" class="form-label">Cor (Opcional)</label>
              <input type="text" name="cor" class="form-control" id="editCor">
            </div>
            <div class="mb-3">
              <label for="editTipo" class="form-label">Tipo de Dispositivo</label>
              <select name="tipo_dispositivo" class="form-control" id="editTipo" required>
                <option value="celular">Celular</option>
                <option value="laptop">Laptop</option>
              </select>
            </div>
            <button type="submit" class="btn btn-register w-100 py-2 mb-3">Atualizar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewImageModal" tabindex="-1" role="dialog" aria-labelledby="viewImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewImageModalLabel">Visualizar Imagem</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img src="" class="modal-img" id="modalImage" alt="Foto do dispositivo">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
  <script src="/assets/vendor_userr/jquery/jquery.min.js"></script>
  <script src="/assets/vendor_userr/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/vendor_userr/jquery-easing/jquery.easing.min.js"></script>
  <script src="/assets/js/sb-admin-2.min.js"></script>
  <script src="/assets/vendor_userr/chart.js/Chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/assets/js/demo/chart-area-demo.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const ctx = document.getElementById('myPieChart').getContext('2d');
      const statusCounts = {
        ativo: <?php echo count(array_filter($devices, fn($device) => $device['status'] === 'ativo')); ?>,
        roubado: <?php echo count(array_filter($devices, fn($device) => $device['status'] === 'roubado')); ?>,
        perdido: <?php echo count(array_filter($devices, fn($device) => $device['status'] === 'perdido')); ?>
      };
      new Chart(ctx, {
        type: 'pie',
        data: {
          datasets: [{
            data: [statusCounts.ativo, statusCounts.roubado, statusCounts.perdido],
            backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
            hoverBackgroundColor: ['#218838', '#c82333', '#e0a800']
          }]
        },
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: 'Distribuição de Status dos Dispositivos'
            }
          }
        }
      });

      // Exibir feedback de registro de dispositivos
      <?php if (isset($registerSuccess)): ?>
        Swal.fire({
          icon: 'success',
          title: 'Sucesso',
          text: '<?php echo $registerSuccess; ?>',
          timer: 2000,
          showConfirmButton: false
        });
      <?php elseif (isset($registerError)): ?>
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: '<?php echo $registerError; ?>',
          confirmButtonText: 'OK'
        });
      <?php endif; ?>

      // Exibir feedback de registro de ocorrências
      <?php if (isset($ocorrenciaSuccess)): ?>
        Swal.fire({
          icon: 'success',
          title: 'Sucesso',
          text: '<?php echo $ocorrenciaSuccess; ?>',
          timer: 2000,
          showConfirmButton: false
        });
      <?php elseif (isset($ocorrenciaError)): ?>
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: '<?php echo $ocorrenciaError; ?>',
          confirmButtonText: 'OK'
        });
      <?php endif; ?>

      // Exibir feedback de pesquisa de IMEI
      <?php if (isset($searchSuccess)): ?>
        Swal.fire({
          icon: 'success',
          title: 'Sucesso',
          text: '<?php echo $searchSuccess; ?>',
          timer: 2000,
          showConfirmButton: false
        });
      <?php elseif (isset($searchError)): ?>
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: '<?php echo $searchError; ?>',
          confirmButtonText: 'OK'
        });
      <?php endif; ?>

      // Exibir feedback de upload de foto
      <?php if (isset($photoSuccess)): ?>
        Swal.fire({
          icon: 'success',
          title: 'Sucesso',
          text: '<?php echo $photoSuccess; ?>',
          timer: 2000,
          showConfirmButton: false
        });
      <?php elseif (isset($photoError)): ?>
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: '<?php echo $photoError; ?>',
          confirmButtonText: 'OK'
        });
      <?php endif; ?>

      // Exibir feedback de deleção de dispositivo
      <?php if (isset($deleteSuccess)): ?>
        Swal.fire({
          icon: 'success',
          title: 'Sucesso',
          text: '<?php echo $deleteSuccess; ?>',
          timer: 2000,
          showConfirmButton: false
        });
      <?php elseif (isset($deleteError)): ?>
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: '<?php echo $deleteError; ?>',
          confirmButtonText: 'OK'
        });
      <?php endif; ?>

      // Manipular clique no botão de edição
      document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
          const deviceId = this.getAttribute('data-device-id');
          const imei = this.getAttribute('data-imei');
          const marca = this.getAttribute('data-marca');
          const modelo = this.getAttribute('data-modelo');
          const cor = this.getAttribute('data-cor');
          const tipo = this.getAttribute('data-tipo');

          document.getElementById('editDeviceId').value = deviceId;
          document.getElementById('editImei').value = imei;
          document.getElementById('editMarca').value = marca;
          document.getElementById('editModelo').value = modelo;
          document.getElementById('editCor').value = cor;
          document.getElementById('editTipo').value = tipo;
        });
      });

      // Manipular clique no botão de deletar
      document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
          e.preventDefault();
          const deviceId = this.getAttribute('data-device-id');
          const userId = this.getAttribute('data-user-id');
          Swal.fire({
            title: 'Tem certeza?',
            text: 'Você deseja deletar este dispositivo? Esta ação não pode ser desfeita.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, deletar',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = '/app/controllers/deviceController.php';
              form.innerHTML = `
                <input type="hidden" name="delete_device" value="1">
                <input type="hidden" name="device_id" value="${deviceId}">
                <input type="hidden" name="user_id" value="${userId}">
              `;
              document.body.appendChild(form);
              form.submit();
            }
          });
        });
      });

      // Validação do formulário de edição
      const editDeviceForm = document.getElementById('editDeviceForm');
      if (editDeviceForm) {
        editDeviceForm.addEventListener('submit', function (e) {
          const imei = document.getElementById('editImei').value.trim();
          const marca = document.getElementById('editMarca').value.trim();
          const modelo = document.getElementById('editModelo').value.trim();
          const tipo = document.getElementById('editTipo').value;

          if (!imei || !marca || !modelo || !tipo) {
            e.preventDefault();
            Swal.fire({
              icon: 'error',
              title: 'Erro',
              text: 'Por favor, preencha todos os campos obrigatórios.',
              confirmButtonText: 'OK'
            });
          }
        });
      }

      // Validação dos formulários de dispositivos
      const deviceForms = [document.getElementById('registerCelularForm'), document.getElementById('registerLaptopForm')];
      deviceForms.forEach(form => {
        if (form) {
          form.addEventListener('submit', function (e) {
            const imei = form.querySelector('[name="imei"]').value.trim();
            const marca = form.querySelector('[name="marca"]').value.trim();
            const modelo = form.querySelector('[name="modelo"]').value.trim();
            const foto = form.querySelector('[name="foto"]').files[0];
            if (!imei || !marca || !modelo) {
              e.preventDefault();
              Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Por favor, preencha todos os campos obrigatórios.',
                confirmButtonText: 'OK'
              });
              return;
            }
            if (foto && foto.size > 5 * 1024 * 1024) {
              e.preventDefault();
              Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'A imagem deve ter no máximo 5MB.',
                confirmButtonText: 'OK'
              });
            }
          });
        }
      });

      // Validação dos formulários de ocorrências
      const ocorrenciaForms = [document.getElementById('reportFurtoForm'), document.getElementById('reportPerdaForm')];
      ocorrenciaForms.forEach(form => {
        if (form) {
          form.addEventListener('submit', function (e) {
            const dispositivo = form.querySelector('[name="dispositivo_id"]').value;
            const data = form.querySelector('[name="data_ocorrencia"]').value;
            const local = form.querySelector('[name="local"]').value.trim();
            if (!dispositivo || !data || !local) {
              e.preventDefault();
              Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Por favor, preencha todos os campos obrigatórios.',
                confirmButtonText: 'OK'
              });
            }
          });
        }
      });

      // Validação do formulário de pesquisa
      const searchForms = document.querySelectorAll('.navbar-search');
      searchForms.forEach(form => {
        form.addEventListener('submit', function (e) {
          const imei = form.querySelector('[name="imei"]').value.trim();
          if (!imei) {
            e.preventDefault();
            Swal.fire({
              icon: 'error',
              title: 'Erro',
              text: 'Por favor, insira um IMEI para pesquisar.',
              confirmButtonText: 'OK'
            });
          }
        });
      });

      // Validação do formulário de upload de foto
      const uploadPhotoForm = document.getElementById('uploadPhotoForm');
      if (uploadPhotoForm) {
        uploadPhotoForm.addEventListener('submit', function (e) {
          const foto = uploadPhotoForm.querySelector('[name="foto"]').files[0];
          if (!foto) {
            e.preventDefault();
            Swal.fire({
              icon: 'error',
              title: 'Erro',
              text: 'Por favor, selecione uma imagem.',
              confirmButtonText: 'OK'
            });
            return;
          }
          if (foto.size > 5 * 1024 * 1024) {
            e.preventDefault();
            Swal.fire({
              icon: 'error',
              title: 'Erro',
              text: 'A imagem deve ter no máximo 5MB.',
              confirmButtonText: 'OK'
            });
          }
        });
      }

      // Passar o device_id para o modal de upload
      $('#uploadPhotoModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const deviceId = button.data('device-id');
        const modal = $(this);
        modal.find('#uploadDeviceId').val(deviceId);
      });

      // Passar a imagem para o modal de visualização
      $('#viewImageModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const imageSrc = button.data('image-src');
        const modal = $(this);
        modal.find('#modalImage').attr('src', imageSrc);
      });
    });
  </script>
</body>
</html>