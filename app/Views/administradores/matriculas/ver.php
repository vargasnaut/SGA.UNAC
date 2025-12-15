<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <a href="<?= base_url('administradores/matriculas/solicitudes') ?>" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left me-1"></i>Volver a Solicitudes
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Información del Estudiante -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-graduate me-2"></i>Información del Estudiante
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Código:</th>
                            <td><span class="badge bg-secondary"><?= esc($solicitud['codigo_estudiante']) ?></span></td>
                        </tr>
                        <tr>
                            <th>Nombres:</th>
                            <td><strong><?= esc($solicitud['nombres']) ?></strong></td>
                        </tr>
                        <tr>
                            <th>Apellidos:</th>
                            <td><strong><?= esc($solicitud['apellidos']) ?></strong></td>
                        </tr>
                        <tr>
                            <th>DNI:</th>
                            <td><?= esc($solicitud['dni']) ?></td>
                        </tr>
                        <tr>
                            <th>Teléfono:</th>
                            <td>
                                <i class="fas fa-phone me-1 text-success"></i>
                                <?= esc($solicitud['telefono']) ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Información de la Solicitud -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Información de la Solicitud
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">ID Solicitud:</th>
                            <td><strong>#<?= esc($solicitud['id']) ?></strong></td>
                        </tr>
                        <tr>
                            <th>Periodo Académico:</th>
                            <td>
                                <span class="badge bg-dark"><?= esc($solicitud['periodo_nombre']) ?></span>
                                <br>
                                <small class="text-muted">
                                    <?= date('d/m/Y', strtotime($solicitud['fecha_inicio'])) ?> - 
                                    <?= date('d/m/Y', strtotime($solicitud['fecha_fin'])) ?>
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <th>Monto Pagado:</th>
                            <td>
                                <h4 class="text-success mb-0">S/ <?= number_format($solicitud['monto'], 2) ?></h4>
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha de Solicitud:</th>
                            <td>
                                <i class="far fa-calendar-alt me-1"></i>
                                <?= date('d/m/Y H:i:s', strtotime($solicitud['fecha_solicitud'])) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                <?php 
                                $badgeClass = [
                                    'pendiente' => 'warning',
                                    'aprobado' => 'success',
                                    'rechazado' => 'danger'
                                ][$solicitud['estado']] ?? 'secondary';
                                
                                $iconClass = [
                                    'pendiente' => 'clock',
                                    'aprobado' => 'check-circle',
                                    'rechazado' => 'times-circle'
                                ][$solicitud['estado']] ?? 'question-circle';
                                ?>
                                <h5>
                                    <span class="badge bg-<?= $badgeClass ?>">
                                        <i class="fas fa-<?= $iconClass ?> me-1"></i>
                                        <?= ucfirst(esc($solicitud['estado'])) ?>
                                    </span>
                                </h5>
                            </td>
                        </tr>
                    </table>

                    <?php if ($solicitud['observaciones']): ?>
                        <div class="alert alert-secondary">
                            <strong>Observaciones:</strong>
                            <p class="mb-0"><?= esc($solicitud['observaciones']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Comprobante de Pago -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-file-invoice me-2"></i>Comprobante de Pago
                    </h5>
                </div>
                <div class="card-body text-center">
                    <?php
                    $extension = strtolower(pathinfo($solicitud['comprobante_pago'], PATHINFO_EXTENSION));
                    $esImagen = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']);
                    ?>

                    <?php if ($esImagen): ?>
                        <!-- Mostrar imagen -->
                        <img src="<?= base_url('administradores/matriculas/comprobante/' . $solicitud['id']) ?>" 
                             alt="Comprobante" 
                             class="img-fluid rounded border"
                             style="max-height: 600px;">
                    <?php else: ?>
                        <!-- Mostrar PDF en iframe -->
                        <iframe src="<?= base_url('administradores/matriculas/comprobante/' . $solicitud['id']) ?>" 
                                width="100%" 
                                height="700px" 
                                class="border rounded">
                        </iframe>
                    <?php endif; ?>

                    <div class="mt-3">
                        <a href="<?= base_url('administradores/matriculas/comprobante/' . $solicitud['id']) ?>" 
                           target="_blank" 
                           class="btn btn-secondary">
                            <i class="fas fa-external-link-alt me-1"></i>Abrir en Nueva Ventana
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones -->
    <?php if ($solicitud['estado'] === 'pendiente'): ?>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-tasks me-2"></i>Acciones
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form method="POST" action="<?= base_url('administradores/matriculas/aprobar/' . $solicitud['id']) ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Observaciones al Aprobar (opcional)</label>
                                        <textarea class="form-control" name="observaciones" rows="3">Solicitud aprobada correctamente</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-lg w-100">
                                        <i class="fas fa-check-circle me-2"></i>Aprobar Solicitud
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form method="POST" action="<?= base_url('administradores/matriculas/rechazar/' . $solicitud['id']) ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Motivo del Rechazo <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="observaciones" rows="3" required 
                                                  placeholder="Especifica el motivo del rechazo..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-lg w-100">
                                        <i class="fas fa-times-circle me-2"></i>Rechazar Solicitud
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
