<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">
                <i class="fas fa-calendar-alt me-2"></i>FIIS - Programación Horaria
            </h2>
            <small class="text-muted">Facultad de Ingeniería Industrial y de Sistemas</small>
        </div>
        <a href="<?= base_url('dashboard/docente') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
        </a>
    </div>

    <!-- Panel de Carreras de FIIS -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-graduation-cap me-2"></i>Carreras de FIIS
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php if (!empty($carreras)): ?>
                    <?php foreach ($carreras as $carrera): ?>
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong><?= esc($carrera['nombre']) ?></strong>
                                <span class="badge bg-primary ms-2"><?= $carrera['duracion'] ?> años</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-muted">No hay carreras registradas para FIIS.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Tabla de Horarios -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-clock me-2"></i>Horarios de Clases
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($horarios)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>Curso</th>
                                <th>Carrera</th>
                                <th>Aula</th>
                                <th>Día</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $diaActual = '';
                            foreach ($horarios as $horario): 
                                $nuevoDia = ($diaActual !== $horario['dia']);
                                $diaActual = $horario['dia'];
                            ?>
                                <?php if ($nuevoDia): ?>
                                    <tr class="table-secondary">
                                        <td colspan="6" class="fw-bold">
                                            <i class="fas fa-calendar-day me-2"></i><?= esc($horario['dia']) ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td><?= esc($horario['curso_nombre']) ?></td>
                                    <td><?= esc($horario['carrera_nombre']) ?></td>
                                    <td>
                                        <span class="badge bg-info">
                                            <i class="fas fa-door-open me-1"></i><?= esc($horario['aula_nombre']) ?>
                                        </span>
                                    </td>
                                    <td><?= esc($horario['dia']) ?></td>
                                    <td>
                                        <span class="badge bg-success">
                                            <?= date('H:i', strtotime($horario['hora_inicio'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">
                                            <?= date('H:i', strtotime($horario['hora_fin'])) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <p class="mb-0">No hay horarios registrados para FIIS en este momento.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Leyenda -->
    <div class="card mt-3">
        <div class="card-body">
            <h6><i class="fas fa-info-circle me-2"></i>Leyenda:</h6>
            <div class="d-flex flex-wrap gap-3">
                <span><span class="badge bg-success">Verde</span> - Hora de Inicio</span>
                <span><span class="badge bg-danger">Rojo</span> - Hora de Fin</span>
                <span><span class="badge bg-info">Azul</span> - Aula</span>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
