<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="fas fa-bell me-2"></i>Mis Notificaciones</h2>
            <p class="text-muted">Comunicados y mensajes institucionales</p>
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if (empty($notificaciones)): ?>
                        <div class="alert alert-info text-center py-5">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <h5>No tienes notificaciones</h5>
                            <p class="mb-0">Cuando recibas comunicados institucionales, aparecerán aquí.</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($notificaciones as $notif): ?>
                                <div class="list-group-item <?= $notif['leido'] ? '' : 'bg-light border-start border-success border-3' ?>">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <?php if (!$notif['leido']): ?>
                                                    <span class="badge bg-danger me-2">Nuevo</span>
                                                <?php endif; ?>
                                                <h5 class="mb-0">
                                                    <i class="fas fa-bell text-success me-2"></i>
                                                    <?= esc($notif['titulo']) ?>
                                                </h5>
                                            </div>
                                            
                                            <p class="mb-3 text-muted"><?= nl2br(esc($notif['mensaje'])) ?></p>
                                            
                                            <?php if (!empty($notif['archivo'])): ?>
                                                <div class="mb-3">
                                                    <?php 
                                                    $extension = pathinfo($notif['archivo'], PATHINFO_EXTENSION);
                                                    $esPdf = (strtolower($extension) === 'pdf');
                                                    ?>
                                                    <a href="<?= base_url('docentes/notificaciones/archivo/' . $notif['id']) ?>" 
                                                       target="_blank" 
                                                       class="btn btn-outline-success">
                                                        <i class="fas fa-<?= $esPdf ? 'file-pdf' : 'image' ?> me-2"></i>
                                                        Ver archivo adjunto
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="d-flex align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    <?= date('d/m/Y H:i', strtotime($notif['fecha_envio'])) ?>
                                                </small>
                                                <span class="badge bg-info ms-3">
                                                    <i class="fas fa-tag"></i> <?= ucfirst($notif['tipo']) ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <?php if (!$notif['leido']): ?>
                                                <a href="<?= base_url('docentes/notificaciones/marcar-leida/' . $notif['id']) ?>" 
                                                   class="btn btn-success btn-sm"
                                                   title="Marcar como leída">
                                                    <i class="fas fa-check"></i> Marcar leída
                                                </a>
                                            <?php else: ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check"></i> Leída
                                                </span>
                                            <?php endif; ?>
                                        </div>
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

<style>
.list-group-item {
    transition: all 0.3s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa !important;
    transform: translateX(5px);
}

.border-start.border-success {
    border-left-width: 4px !important;
}
</style>

<?= $this->endSection() ?>
