<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-file-alt me-2 text-primary"></i>Detalle del Trámite
                </h2>
                
            </div>

            <!-- Información del Trámite -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2 text-info"></i>Información del Trámite
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        <!-- ID -->
                        <div class="col-md-6">
                            <p class="mb-2"><strong><i class="fas fa-hashtag me-2 text-muted"></i>ID:</strong></p>
                            <p class="text-muted">#<?= str_pad($tramite['id'], 5, '0', STR_PAD_LEFT) ?></p>
                        </div>

                        <!-- Estudiante -->
                        <div class="col-md-6">
                            <p class="mb-2"><strong><i class="fas fa-user me-2 text-muted"></i>Estudiante:</strong></p>
                            <p class="text-muted">
                                <?= esc($tramite['est_nombres'] . ' ' . $tramite['est_apellidos']) ?>
                            </p>
                        </div>

                        <!-- Tipo de Documento -->
                        <div class="col-md-6">
                            <p class="mb-2"><strong><i class="fas fa-file me-2 text-muted"></i>Tipo de Documento:</strong></p>
                            <p class="text-muted"><?= esc($tramite['tipo_documento']) ?></p>
                        </div>

                        <!-- Motivo -->
                        <div class="col-md-6">
                            <p class="mb-2"><strong><i class="fas fa-comment me-2 text-muted"></i>Motivo:</strong></p>
                            <p class="text-muted"><?= esc($tramite['motivo']) ?></p>
                        </div>

                        <!-- Tipo de Tramite -->
                        <div class="col-md-12">
                            <p class="mb-2"><strong><i class="fas fa-folder me-2 text-muted"></i>Tipo de Trámite:</strong></p>
                            <p class="text-muted"><?= esc($tramite['tipo']) ?></p>
                        </div>

                        <!-- Descripción -->
                        <div class="col-md-12">
                            <p class="mb-2"><strong><i class="fas fa-align-left me-2 text-muted"></i>Descripción:</strong></p>
                            <div class="alert alert-light">
                                <?= nl2br(esc($tramite['descripcion'])) ?>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-12">
                            <p class="mb-2"><strong><i class="fas fa-circle me-2 text-muted"></i>Estado:</strong></p>
                            <span class="badge bg-<?=
                                $tramite['estado'] == 'pendiente'   ? 'warning' :
                                ($tramite['estado'] == 'en proceso' ? 'info' :
                                ($tramite['estado'] == 'aprobado'  ? 'success' :
                                ($tramite['estado'] == 'rechazado' ? 'danger' : 'secondary')))
                            ?> fs-6">
                                <?= ucfirst($tramite['estado']) ?>
                            </span>
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-12">
                            <p class="mb-2"><strong><i class="fas fa-calendar me-2 text-muted"></i>Fecha de Solicitud:</strong></p>
                            <p class="text-muted"><?= date('d/m/Y', strtotime($tramite['fecha_solicitud'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documento Adjuntado -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-file-upload me-2 text-info"></i>Documento Adjuntado
                    </h5>
                </div>

                <div class="card-body">

                    <?php if (!empty($tramite['documento'])): ?>

                        <p><strong>Archivo:</strong> <?= esc($tramite['documento']) ?></p>

                        <?php
                            $extension = strtolower(pathinfo($tramite['documento'], PATHINFO_EXTENSION));
                            $urlDocumento = base_url('uploads/tramites/' . $tramite['documento']);
                        ?>

                        <?php if ($extension === 'pdf'): ?>

                            <iframe src="<?= $urlDocumento ?>" class="w-100" height="500px"></iframe>

                        <?php else: ?>

                            <a href="<?= $urlDocumento ?>" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-download me-1"></i> Ver / Descargar Documento
                            </a>

                        <?php endif; ?>

                    <?php else: ?>

                        <p class="text-muted">No se adjuntó ningún documento.</p>

                    <?php endif; ?>
                </div>
            </div>

            <!-- Botón para ir a cambiar estado -->
            <div class="text-end mt-3">
                <a href="<?= base_url('administrativos/tramites') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver
                </a>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>

