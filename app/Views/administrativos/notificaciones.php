<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="fas fa-bell me-2"></i>Gestión de Notificaciones</h2>
            <p class="text-muted">Enviar comunicados a estudiantes y docentes</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Formulario para crear notificación -->
        <div class="col-lg-5 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Nueva Notificación
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('administrativos/notificaciones/crear') ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">
                                <i class="fas fa-heading me-1"></i>Título de la notificación
                            </label>
                            <input type="text" class="form-control" id="titulo" name="titulo" 
                                   placeholder="Ej: Inicio de Matrícula 2025" required>
                        </div>

                        <div class="mb-3">
                            <label for="mensaje" class="form-label">
                                <i class="fas fa-comment-dots me-1"></i>Mensaje
                            </label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="5" 
                                      placeholder="Escribe el contenido del comunicado..." required></textarea>
                            <small class="text-muted">Escribe un mensaje claro y conciso</small>
                        </div>

                        <div class="mb-3">
                            <label for="archivo" class="form-label">
                                <i class="fas fa-paperclip me-1"></i>Archivo adjunto (opcional)
                            </label>
                            <input type="file" class="form-control" id="archivo" name="archivo" 
                                   accept=".jpg,.jpeg,.png,.gif,.pdf">
                            <small class="text-muted">Formatos: JPG, PNG, GIF, PDF (Máx. 5MB)</small>
                        </div>

                        <div class="mb-3">
                            <label for="destinatarios" class="form-label">
                                <i class="fas fa-users me-1"></i>Destinatarios
                            </label>
                            <select class="form-select" id="destinatarios" name="destinatarios" required>
                                <option value="">Seleccionar...</option>
                                <option value="todos">Todos (Estudiantes y Docentes)</option>
                                <option value="estudiantes">Solo Estudiantes</option>
                                <option value="docentes">Solo Docentes</option>
                            </select>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>La notificación se enviará inmediatamente a los usuarios seleccionados.</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>Enviar Notificación
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-chart-bar me-2"></i>Estadísticas
                    </h6>
                    <div class="row text-center">
                        <div class="col-6 mb-2">
                            <div class="p-2 bg-light rounded">
                                <h4 class="mb-0 text-primary"><?= count($notificaciones) ?></h4>
                                <small class="text-muted">Total enviadas</small>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="p-2 bg-light rounded">
                                <h4 class="mb-0 text-success">
                                    <?= count(array_filter($notificaciones, fn($n) => $n['leido'] == 1)) ?>
                                </h4>
                                <small class="text-muted">Leídas</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de notificaciones enviadas -->
        <div class="col-lg-7 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Historial de Notificaciones
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($notificaciones)): ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h5>No hay notificaciones enviadas</h5>
                            <p class="mb-0">Utiliza el formulario para enviar tu primera notificación.</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush" style="max-height: 600px; overflow-y: auto;">
                            <?php foreach ($notificaciones as $notif): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <i class="fas fa-bell text-primary me-2"></i>
                                                <?= esc($notif['titulo']) ?>
                                            </h6>
                                            <p class="mb-2 text-muted"><?= esc($notif['mensaje']) ?></p>
                                            
                                            <?php if (!empty($notif['archivo'])): ?>
                                                <div class="mb-2">
                                                    <?php 
                                                    $extension = pathinfo($notif['archivo'], PATHINFO_EXTENSION);
                                                    $esPdf = (strtolower($extension) === 'pdf');
                                                    ?>
                                                    <a href="<?= base_url('administrativos/notificaciones/archivo/' . $notif['id']) ?>" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-<?= $esPdf ? 'file-pdf' : 'image' ?> me-1"></i>
                                                        Ver archivo adjunto
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                <?= date('d/m/Y H:i', strtotime($notif['fecha_envio'])) ?>
                                            </small>
                                            <span class="ms-3">
                                                <?php if ($notif['leido']): ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check"></i> Leída
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-envelope"></i> No leída
                                                    </span>
                                                <?php endif; ?>
                                            </span>
                                            <span class="badge bg-info ms-1">
                                                <i class="fas fa-tag"></i> <?= ucfirst($notif['tipo']) ?>
                                            </span>
                                        </div>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger ms-2"
                                                onclick="confirmarEliminar(<?= $notif['id'] ?>)"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de eliminar esta notificación? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="btnEliminar" class="btn btn-danger">
                    <i class="fas fa-trash me-1"></i>Eliminar
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarEliminar(id) {
    const modal = new bootstrap.Modal(document.getElementById('eliminarModal'));
    document.getElementById('btnEliminar').href = '<?= base_url('administrativos/notificaciones/eliminar/') ?>' + id;
    modal.show();
}
</script>

<style>
.list-group-item {
    border-left: 3px solid #0d6efd;
    margin-bottom: 0.5rem;
    border-radius: 0.25rem;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>

<?= $this->endSection() ?>
