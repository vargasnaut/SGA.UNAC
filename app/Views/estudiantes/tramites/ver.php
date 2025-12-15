<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>

<style>
    .detalle-label {
        font-weight: 600;
        color: #495057;
    }
    .detalle-box {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px 16px;
        border: 1px solid #e3e6e8;
    }
</style>

<h3 class="mb-4">
    <i class="fas fa-file-alt text-primary"></i> Detalle del Trámite
</h3>

<div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Información General</h5>
    </div>

    <div class="card-body">

        <div class="row g-3">

            <div class="col-md-4">
                <div class="detalle-label">ID del Trámite</div>
                <div class="detalle-box"><?= $tramite['id'] ?></div>
            </div>

            <div class="col-md-4">
                <div class="detalle-label">Tipo de Trámite</div>
                <div class="detalle-box"><?= esc($tramite['tipo']) ?></div>
            </div>

            <div class="col-md-4">
                <div class="detalle-label">Fecha de Solicitud</div>
                <div class="detalle-box">
                    <?= date('d-m-Y', strtotime($tramite['fecha_solicitud'])) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="detalle-label">Estado</div>
                <?php
                    $color = [
                        'pendiente' => 'warning',
                        'en proceso' => 'info',
                        'aprobado' => 'success',
                        'rechazado' => 'danger'
                    ];
                    $badge = $color[$tramite['estado']] ?? 'secondary';
                ?>
                <div class="detalle-box">
                    <span class="badge bg-<?= $badge ?> px-3 py-2">
                        <i class="fas fa-circle"></i> <?= ucfirst($tramite['estado']) ?>
                    </span>
                </div>
            </div>

            <div class="col-md-8">
                <div class="detalle-label">Motivo</div>
                <div class="detalle-box">
                    <?= esc($tramite['motivo'] ?? 'No registrado') ?>
                </div>
            </div>

            <div class="col-12">
                <div class="detalle-label">Descripción</div>
                <div class="detalle-box">
                    <?= nl2br(esc($tramite['descripcion'])) ?>
                </div>
            </div>

        </div>

        <hr class="my-4">

        <h5 class="mb-3"><i class="fas fa-paperclip text-secondary"></i> Documento Adjunto</h5>

        <div class="detalle-box">

            <p>
                <strong>Tipo de Documento:</strong> 
                <?= esc($tramite['tipo_documento'] ?? 'No registrado') ?>
            </p>

            <?php if (!empty($tramite['documento'])): ?>
                <a href="<?= base_url('estudiantes/tramites/ver-documento/' . $tramite['id'])?>" 
                   target="_blank"
                   class="btn btn-outline-primary">
                    <i class="fas fa-file-download"></i> Ver Documento
                </a>
            <?php else: ?>
                <span class="text-muted">No se adjuntó ningún archivo.</span>
            <?php endif; ?>
        </div>

        <a href="<?= base_url('estudiantes/tramites') ?>" class="btn btn-secondary mt-4">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>

    </div>
</div>

<?= $this->endSection() ?>
