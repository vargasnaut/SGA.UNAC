<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Bienvenido, <?= esc(session('nombre')) ?> (Docente)</h2>
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
                                                <a href="<?= base_url('docentes/notificaciones/archivo/' . $notif['id']) ?>" 
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
                                            <a href="<?= base_url('docentes/notificaciones/marcar-leida/' . $notif['id']) ?>" 
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
                    <a href="<?= base_url('docentes/notificaciones') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-bell me-1"></i>Ver todos los anuncios
                        <?php if ($notificaciones_no_leidas > 0): ?>
                            <span class="badge bg-danger ms-1"><?= $notificaciones_no_leidas ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Enlaces de Facultades (40%) -->
        <div class="col-lg-5">
            <div class="card" style="height: 600px;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-link me-2"></i>Enlaces
                    </h5>
                </div>
                <div class="card-body" style="overflow-y: auto;">
                    <?php 
                    // Todas las facultades como botones
                    $facultadesEnlaces = [
                        ['id' => 1, 'nombre' => 'FIIS', 'color' => 'primary', 'icono' => 'laptop-code'],
                        ['id' => 4, 'nombre' => 'FIC', 'color' => 'warning', 'icono' => 'building'],
                        ['id' => 3, 'nombre' => 'FIEE', 'color' => 'danger', 'icono' => 'bolt'],
                        ['id' => 5, 'nombre' => 'FIQT', 'color' => 'info', 'icono' => 'flask'],
                        ['id' => 2, 'nombre' => 'FIME', 'color' => 'secondary', 'icono' => 'cog'],
                        ['id' => 6, 'nombre' => 'FIEP', 'color' => 'dark', 'icono' => 'fish'],
                        ['id' => 7, 'nombre' => 'FCS', 'color' => 'success', 'icono' => 'atom'],
                        ['id' => 8, 'nombre' => 'FIARN', 'color' => 'info', 'icono' => 'leaf'],
                        ['id' => 9, 'nombre' => 'FCC', 'color' => 'warning', 'icono' => 'calculator'],
                        ['id' => 10, 'nombre' => 'FCA', 'color' => 'primary', 'icono' => 'briefcase'],
                        ['id' => 11, 'nombre' => 'FCED', 'color' => 'danger', 'icono' => 'chart-line']
                    ];
                    
                    foreach ($facultadesEnlaces as $fac): 
                        $isFIIS = ($fac['id'] == 1);
                    ?>
                        <div class="mb-3">
                            <?php if ($isFIIS): ?>
                                <a href="<?= base_url('docentes/facultad/fiis/personal') ?>" 
                                   class="btn btn-<?= $fac['color'] ?> btn-sm w-100 text-start py-2 shadow-sm btn-enlace">
                                    <i class="fas fa-<?= $fac['icono'] ?> fa-lg me-3"></i>
                                    <strong><?= esc($fac['nombre']) ?></strong>
                                    <i class="fas fa-arrow-right float-end mt-1"></i>
                                </a>
                            <?php else: ?>
                                <button class="btn btn-outline-<?= $fac['color'] ?> btn-sm w-100 text-start py-2 shadow-sm" 
                                        style="cursor: not-allowed; opacity: 0.6;" disabled>
                                    <i class="fas fa-<?= $fac['icono'] ?> fa-lg me-3"></i>
                                    <strong><?= esc($fac['nombre']) ?></strong>
                                    <i class="fas fa-lock float-end mt-1"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Gestión de Cursos y Calendario -->
    <div class="row mt-4">
        <!-- Gestión de Cursos -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Gestión de Cursos
                    </h5>
                    <p class="text-muted">Administra tus clases y registra calificaciones.</p>
                    <a href="<?= base_url('docentes/cursos') ?>" class="btn btn-primary">
                        <i class="fas fa-book me-1"></i>Ver Mis Cursos
                    </a>
                </div>
            </div>
        </div>

        <!-- Calendario de Eventos -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>Próximas Fechas Importantes
                    </h5>
                </div>
                <div class="card-body">
                    <?php
                    $events = [
                        ['date' => '2025-11-30', 'title' => 'Entrega de Notas - Periodo 2025-II', 'color' => 'danger'],
                        ['date' => '2025-12-05', 'title' => 'Reunión de Coordinación Académica', 'color' => 'primary'],
                        ['date' => '2025-12-15', 'title' => 'Fin del Periodo Académico 2025-II', 'color' => 'warning'],
                        ['date' => '2026-01-15', 'title' => 'Inicio Periodo Académico 2026-I', 'color' => 'success'],
                    ];
                    ?>
                    <div class="row">
                        <?php foreach ($events as $ev): ?>
                            <div class="col-md-3 mb-3">
                                <div class="card border-<?= $ev['color'] ?> h-100">
                                    <div class="card-body text-center">
                                        <div class="text-<?= $ev['color'] ?> mb-2">
                                            <h3 class="mb-0"><?= date('d', strtotime($ev['date'])) ?></h3>
                                            <small><?= strtoupper(date('M', strtotime($ev['date']))) ?></small>
                                        </div>
                                        <p class="small mb-0"><?= esc($ev['title']) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-enlace:hover {
            transform: translateX(5px);
            transition: all 0.3s;
        }
        .card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.15) !important;
        }
    </style>
<?= $this->endSection() ?>
