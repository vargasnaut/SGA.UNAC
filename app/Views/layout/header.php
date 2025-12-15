<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Panel') ?> | SGA</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/css/estilos.css') ?>">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-2">
  <div class="container-fluid">
    <!-- Logo del sistema -->
    <a class="navbar-brand d-flex align-items-center" href="<?= base_url('dashboard') ?>">
      <i class="fas fa-graduation-cap me-2"></i>
      <span class="fw-semibold">SGA UNAC</span>
    </a>

    <div class="ms-auto d-flex align-items-center gap-3">
      <!-- Frase de bienvenida -->
      <span class="text-light fw-semibold d-none d-md-block">
        <i class="fa-regular fa-hand-wave me-1"></i>
        Bienvenido, <span class="text-warning"><?= esc(session('nombre')) ?></span>
      </span>

      <!-- Notificaciones -->
      <div class="position-relative">
        <button class="btn btn-light btn-sm rounded-circle position-relative" id="notificacionesBtn">
          <i class="fa-regular fa-bell text-primary"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="contadorNotificaciones">3</span>
        </button>
      </div>

      <!-- Perfil de usuario -->
      <div class="dropdown">
        <button class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center" id="perfilDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="width: 38px; height: 38px;">
          <i class="fa-regular fa-user text-primary"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow">
          <li class="dropdown-header text-center">
            <strong><?= esc(session('nombre')) ?></strong><br>
            <small class="text-muted"><?= esc(session('rol')) ?></small>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="<?= base_url('perfil') ?>"><i class="fa-regular fa-id-card me-2"></i>Mi Perfil</a></li>
          <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>"><i class="fa-solid fa-right-from-bracket me-2"></i> Cerrar sesión</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>


    <div class="container-fluid">
        <div class="row">
