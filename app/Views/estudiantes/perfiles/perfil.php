<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="fas fa-user-circle me-2"></i>Mi Perfil</h2>
            <p class="text-muted">Información personal y académica</p>
        </div>
    </div>

    <div class="row">
        <!-- Tarjeta de Información Personal -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="avatar-circle mx-auto">
                            <i class="fas fa-user fa-4x text-muted"></i>
                        </div>
                    </div>
                    <h4 class="mb-1"><?= esc($estudiante['nombres'] ?? 'N/A') ?> <?= esc($estudiante['apellidos'] ?? '') ?></h4>
                    <p class="text-muted mb-2">
                        <i class="fas fa-id-card me-1"></i>
                        <?= esc($estudiante['codigo_estudiante'] ?? 'N/A') ?>
                    </p>
                    <span class="badge bg-primary mb-3">Estudiante</span>
                    
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarPerfilModal">
                            <i class="fas fa-edit me-1"></i>Editar Perfil
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#cambiarPasswordModal">
                            <i class="fas fa-key me-1"></i>Cambiar Contraseña
                        </button>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-graduation-cap me-2"></i>Información Académica
                    </h6>
                    <div class="info-item mb-2">
                        <small class="text-muted">Carrera:</small>
                        <p class="mb-0 fw-semibold"><?= esc($estudiante['carrera'] ?? 'N/A') ?></p>
                    </div>
                    <div class="info-item mb-2">
                        <small class="text-muted">Fecha de registro:</small>
                        <p class="mb-0"><?= date('d/m/Y', strtotime($estudiante['fecha_registro'] ?? 'now')) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Detallada -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Datos Personales
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Nombres completos</label>
                            <p class="fw-semibold"><?= esc($estudiante['nombres'] ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Apellidos</label>
                            <p class="fw-semibold"><?= esc($estudiante['apellidos'] ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">DNI</label>
                            <p class="fw-semibold"><?= esc($estudiante['dni'] ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Código de estudiante</label>
                            <p class="fw-semibold"><?= esc($estudiante['codigo_estudiante'] ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Teléfono</label>
                            <p class="fw-semibold">
                                <i class="fas fa-phone me-1 text-muted"></i>
                                <?= esc($estudiante['telefono'] ?? 'No registrado') ?>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Email</label>
                            <p class="fw-semibold">
                                <i class="fas fa-envelope me-1 text-muted"></i>
                                <?= esc(session('email') ?? 'No disponible') ?>
                            </p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted small">Dirección</label>
                            <p class="fw-semibold">
                                <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                                <?= esc($estudiante['direccion'] ?? 'No registrada') ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

           
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Perfil -->
<div class="modal fade" id="editarPerfilModal" tabindex="-1" aria-labelledby="editarPerfilModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarPerfilModalLabel">
                    <i class="fas fa-edit me-2"></i>Editar Perfil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('estudiantes/perfil/actualizar') ?>" method="post">
                <div class="modal-body">
                    <!-- Nombres -->
                    <div class="mb-3">
                        <label for="nombres" class="form-label">Nombres <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombres" name="nombres" value="<?= esc($estudiante['nombres'] ?? '') ?>" required>
                    </div>

                    <!-- Apellidos -->
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= esc($estudiante['apellidos'] ?? '') ?>" required>
                    </div>

                    <!-- DNI -->
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="dni" name="dni" value="<?= esc($estudiante['dni'] ?? '') ?>" required>
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?= esc($estudiante['telefono'] ?? '') ?>">
                    </div>

                    <!-- Dirección -->
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="2"><?= esc($estudiante['direccion'] ?? '') ?></textarea>
                    </div>

                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>Los campos con <span class="text-danger">*</span> son obligatorios.</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Cambiar Contraseña -->
<div class="modal fade" id="cambiarPasswordModal" tabindex="-1" aria-labelledby="cambiarPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cambiarPasswordModalLabel">
                    <i class="fas fa-key me-2"></i>Cambiar Contraseña
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('estudiantes/perfil/cambiar-password') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="password_actual" class="form-label">Contraseña actual</label>
                        <input type="password" class="form-control" id="password_actual" name="password_actual" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_nueva" class="form-label">Nueva contraseña</label>
                        <input type="password" class="form-control" id="password_nueva" name="password_nueva" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmar" class="form-label">Confirmar nueva contraseña</label>
                        <input type="password" class="form-control" id="password_confirmar" name="password_confirmar" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Cambiar contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.info-item {
    padding-bottom: 10px;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
</style>

<?= $this->endSection() ?>
