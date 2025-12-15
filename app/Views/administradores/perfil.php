<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-user-circle me-2 text-primary"></i>Mi Perfil
                </h2>
                <a href="<?= base_url('administradores/dashboard') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
                </a>
            </div>

            <!-- Mensajes Flash -->
            <?php if (session()->getFlashdata('msg')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('msg') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Tarjeta de Perfil -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-id-card me-2"></i>Información del Administrador
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('administradores/perfil/actualizar') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="row g-3">
                            <!-- Nombre de Usuario (readonly) -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user me-1"></i>Usuario
                                </label>
                                <input type="text" class="form-control" value="<?= esc(session('nombre')) ?>" readonly>
                            </div>

                            <!-- Email (readonly) -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-envelope me-1"></i>Correo Electrónico
                                </label>
                                <input type="email" class="form-control" value="<?= esc(session('email')) ?>" readonly>
                            </div>

                            <!-- Rol (readonly) -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-shield-alt me-1"></i>Rol
                                </label>
                                <input type="text" class="form-control" value="Administrador" readonly>
                            </div>

                            <!-- Información Adicional (si existe en tabla administrativos) -->
                            <?php if (isset($administrador)): ?>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-signature me-1"></i>Nombres
                                    </label>
                                    <input type="text" name="nombres" class="form-control" 
                                           value="<?= esc($administrador['nombres'] ?? '') ?>" 
                                           placeholder="Ingresa tus nombres">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-signature me-1"></i>Apellidos
                                    </label>
                                    <input type="text" name="apellidos" class="form-control" 
                                           value="<?= esc($administrador['apellidos'] ?? '') ?>" 
                                           placeholder="Ingresa tus apellidos">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-id-card me-1"></i>DNI
                                    </label>
                                    <input type="text" name="dni" class="form-control" 
                                           value="<?= esc($administrador['dni'] ?? '') ?>" 
                                           placeholder="Número de DNI" maxlength="8">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-phone me-1"></i>Teléfono
                                    </label>
                                    <input type="text" name="telefono" class="form-control" 
                                           value="<?= esc($administrador['telefono'] ?? '') ?>" 
                                           placeholder="Número de teléfono">
                                </div>
                            <?php endif; ?>
                        </div>

                        <hr class="my-4">

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="<?= base_url('administradores/dashboard') ?>" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-info-circle me-2 text-info"></i>Información del Sistema
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Último acceso:</strong></p>
                            <p class="text-muted"><?= date('d/m/Y H:i:s') ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Estado:</strong></p>
                            <span class="badge bg-success">Activo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.2s;
}
.hover-card:hover {
    transform: translateY(-5px);
}
</style>

<?= $this->endSection() ?>
