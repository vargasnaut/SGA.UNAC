<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>

<div class="container py-4">

    <div class="card shadow-lg border-0 p-4">

        <div class="mb-4 border-bottom pb-2">
            <h3 class="text-primary mb-1">
                <i class="fas fa-tasks me-2"></i> Actualización del Estado del Trámite
            </h3>
            <p class="text-muted">
                Desde este panel puedes revisar la información principal del trámite y actualizar su estado de forma segura.
            </p>
        </div>

        <!-- Mensajes de error -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('administrativos/tramites/actualizar/' . $tramite['id']) ?>" method="POST">

            <!-- Información del trámite -->
            <div class="card bg-light border-0 shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <strong><i class="fas fa-info-circle me-2"></i>Información del Trámite</strong>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label text-muted"><strong>Estudiante</strong></label>
                        <input type="text" class="form-control" 
                            value="<?= $tramite['est_nombres'] . ' ' . $tramite['est_apellidos'] ?>" 
                            disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted"><strong>Tipo de Trámite</strong></label>
                        <input type="text" class="form-control" 
                            value="<?= $tramite['tipo'] ?>" 
                            disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted"><strong>Estado Actual</strong></label>
                        <input type="text" class="form-control" 
                            value="<?= ucfirst($tramite['estado']) ?>" 
                            disabled>
                    </div>

                </div>
            </div>

            <!-- Selector de estado -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <strong><i class="fas fa-edit me-2"></i>Actualizar Estado</strong>
                </div>

                <div class="card-body">

                    <p class="text-muted mb-3">
                        Selecciona el nuevo estado que tendrá el trámite. Esta acción notificará automáticamente al estudiante.
                    </p>

                    <div class="mb-3">
                        <label for="estado" class="form-label"><strong>Nuevo Estado</strong></label>
                        <select name="estado" id="estado" class="form-select" required>

                            <option value="">-- Seleccionar Estado --</option>

                            <option value="pendiente"
                                <?= $tramite['estado'] == 'pendiente' ? 'selected' : '' ?>>
                                Pendiente
                            </option>

                            <option value="en proceso"
                                <?= $tramite['estado'] == 'en proceso' ? 'selected' : '' ?>>
                                En Proceso
                            </option>

                            <option value="aprobado"
                                <?= $tramite['estado'] == 'aprobado' ? 'selected' : '' ?>>
                                Aprobado
                            </option>

                            <option value="rechazado"
                                <?= $tramite['estado'] == 'rechazado' ? 'selected' : '' ?>>
                                Rechazado
                            </option>

                        </select>
                    </div>

                </div>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="<?= base_url('administrativos/tramites') ?>" 
                    class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Cancelar
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Guardar Cambios
                </button>
            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>
