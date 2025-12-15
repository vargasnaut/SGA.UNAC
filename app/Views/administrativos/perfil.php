<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="fas fa-user-circle me-2"></i>Mi Perfil</h2>
            <p class="text-muted">Información personal y laboral</p>
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
                    <h4 class="mb-1"><?= esc($administrativo['nombres'] ?? 'N/A') ?> <?= esc($administrativo['apellidos'] ?? '') ?></h4>
                    <p class="text-muted mb-2">
                        <i class="fas fa-id-card me-1"></i>
                        <?= esc($administrativo['codigo_administrativo'] ?? 'N/A') ?>
                    </p>
                    <span class="badge bg-warning text-dark mb-3">Administrativo</span>
                    
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
                        <i class="fas fa-briefcase me-2"></i>Información Laboral
                    </h6>
                    <div class="info-item mb-2">
                        <small class="text-muted">Área:</small>
                        <p class="mb-0 fw-semibold"><?= esc($administrativo['area'] ?? 'N/A') ?></p>
                    </div>
                    <div class="info-item mb-2">
                        <small class="text-muted">Cargo:</small>
                        <p class="mb-0 fw-semibold"><?= esc($administrativo['cargo'] ?? 'N/A') ?></p>
                    </div>
                    <div class="info-item mb-2">
                        <small class="text-muted">Fecha de registro:</small>
                        <p class="mb-0"><?= date('d/m/Y', strtotime($administrativo['fecha_registro'] ?? 'now')) ?></p>
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
                            <p class="fw-semibold"><?= esc($administrativo['nombres'] ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Apellidos</label>
                            <p class="fw-semibold"><?= esc($administrativo['apellidos'] ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">DNI</label>
                            <p class="fw-semibold"><?= esc($administrativo['dni'] ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Código</label>
                            <p class="fw-semibold"><?= esc($administrativo['codigo_administrativo'] ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Área</label>
                            <p class="fw-semibold">
                                <i class="fas fa-building me-1 text-muted"></i>
                                <?= esc($administrativo['area'] ?? 'No registrada') ?>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Cargo</label>
                            <p class="fw-semibold">
                                <i class="fas fa-user-tie me-1 text-muted"></i>
                                <?= esc($administrativo['cargo'] ?? 'No registrado') ?>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Teléfono</label>
                            <p class="fw-semibold">
                                <i class="fas fa-phone me-1 text-muted"></i>
                                <?= esc($administrativo['telefono'] ?? 'No registrado') ?>
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
                                <?= esc($administrativo['direccion'] ?? 'No registrada') ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="row mt-3">
                <div class="col-md-4 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-file-alt fa-2x mb-2"></i>
                            <h4 class="mb-0"><?= $total_tramites ?? 0 ?></h4>
                            <small>Trámites procesados</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-tasks fa-2x mb-2"></i>
                            <h4 class="mb-0"><?= $tareas_pendientes ?? 0 ?></h4>
                            <small>Tareas pendientes</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-bell fa-2x mb-2"></i>
                            <h4 class="mb-0"><?= $total_notificaciones ?? 0 ?></h4>
                            <small>Notificaciones</small>
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
            <form action="<?= base_url('administrativos/perfil/actualizar') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?= esc($administrativo['telefono'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="3"><?= esc($administrativo['direccion'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="area" class="form-label">Área</label>
                        <input type="text" class="form-control" id="area" name="area" value="<?= esc($administrativo['area'] ?? '') ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" class="form-control" id="cargo" name="cargo" value="<?= esc($administrativo['cargo'] ?? '') ?>" readonly>
                    </div>
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>Para cambiar otros datos (nombres, DNI, código, área o cargo) contacta con la oficina de recursos humanos.</small>
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
            <form action="<?= base_url('administrativos/perfil/cambiar-password') ?>" method="post">
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
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
