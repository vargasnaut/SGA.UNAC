<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Bienvenido, <?= esc(session('nombre')) ?> (Estudiante)</h2>
            <small class="text-muted">Panel de inicio</small>
        </div>
    </div>

    <div class="row">
        <!-- Columna Izquierda: Anuncios Académicos (60%) -->
        <div class="col-lg-7">
            <div class="card" style="height: 600px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-bullhorn me-2"></i>Anuncios Académicos
                    </h5>
                </div>
                <div class="card-body" style="overflow-y: auto; max-height: 480px;">
                    <?php if (empty($notificaciones)): ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p class="mb-0">No hay anuncios en este momento</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($notificaciones as $notif): ?>
                                <div class="list-group-item <?= $notif['leido'] ? '' : 'bg-light border-start border-primary border-3' ?>">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <?php if (!$notif['leido']): ?>
                                                    <span class="badge bg-danger me-2">Nuevo</span>
                                                <?php endif; ?>
                                                <?= esc($notif['titulo']) ?>
                                            </h6>
                                            <p class="mb-2 text-muted"><?= esc($notif['mensaje']) ?></p>
                                            
                                            <?php if (!empty($notif['archivo'])): ?>
                                                <?php 
                                                $extension = pathinfo($notif['archivo'], PATHINFO_EXTENSION);
                                                $esPdf = (strtolower($extension) === 'pdf');
                                                ?>
                                                <a href="<?= base_url('estudiantes/notificaciones/archivo/' . $notif['id']) ?>" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-outline-primary mb-2">
                                                    <i class="fas fa-<?= $esPdf ? 'file-pdf' : 'image' ?> me-1"></i>
                                                    Ver archivo adjunto
                                                </a>
                                            <?php endif; ?>
                                            
                                            <small class="text-muted d-block">
                                                <i class="fas fa-clock me-1"></i>
                                                <?= date('d/m/Y H:i', strtotime($notif['fecha_envio'])) ?>
                                            </small>
                                        </div>
                                        <?php if (!$notif['leido']): ?>
                                            <a href="<?= base_url('estudiantes/notificaciones/marcar-leida/' . $notif['id']) ?>" 
                                               class="btn btn-sm btn-outline-success ms-2"
                                               title="Marcar como leída">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer text-center bg-white">
                    <a href="<?= base_url('estudiantes/notificaciones') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-bell me-1"></i>Ver todos los anuncios
                        <?php if ($notificaciones_no_leidas > 0): ?>
                            <span class="badge bg-danger ms-1"><?= $notificaciones_no_leidas ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Enlaces Estudiantiles (40%) -->
        <div class="col-lg-5">
            <div class="card" style="height: 600px;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-link me-2"></i>Enlaces Estudiantiles
                    </h5>
                </div>
                <div class="card-body" style="overflow-y: auto;">
                    <div class="mb-3">
                        <a href="<?= base_url('estudiantes/mis-cursos') ?>" 
                           class="btn btn-primary btn-sm w-100 text-start py-2 shadow-sm btn-enlace">
                            <i class="fas fa-book-open fa-lg me-3"></i>
                            <strong>Mis Cursos</strong>
                            <span class="badge bg-white text-primary float-end mt-1"><?= count($cursos) ?></span>
                            <i class="fas fa-arrow-right float-end mt-1 me-2"></i>
                        </a>
                    </div>
                    <div class="mb-3">
                        <a href="<?= base_url('estudiantes/historial') ?>" 
                           class="btn btn-info btn-sm w-100 text-start py-2 shadow-sm btn-enlace">
                            <i class="fas fa-history fa-lg me-3"></i>
                            <strong>Historial Académico</strong>
                            <i class="fas fa-arrow-right float-end mt-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.15) !important;
        }
        .btn-enlace {
            transition: all 0.3s ease;
        }
        .btn-enlace:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
        }
    </style>
<?= $this->endSection() ?>
