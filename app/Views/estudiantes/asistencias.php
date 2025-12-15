<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<h3 class="mb-3">Asistencias - <?= esc($curso['nombre']) ?></h3>

<div class="card">
    <div class="card-body">
        <?php if (empty($asistencias)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                No hay registros de asistencia aún.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Observación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($asistencias as $a): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($a['fecha'])) ?></td>
                                <td>
                                    <?php
                                    $badgeClass = 'secondary';
                                    if ($a['estado'] === 'Asistió') $badgeClass = 'success';
                                    elseif ($a['estado'] === 'Tardanza') $badgeClass = 'warning';
                                    elseif ($a['estado'] === 'Falta') $badgeClass = 'danger';
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?>">
                                        <?= esc($a['estado']) ?>
                                    </span>
                                </td>
                                <td><?= esc($a['observacion'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Resumen de asistencias -->
            <?php
            $total = count($asistencias);
            $asistio = count(array_filter($asistencias, fn($a) => $a['estado'] === 'Asistió'));
            $tardanza = count(array_filter($asistencias, fn($a) => $a['estado'] === 'Tardanza'));
            $faltas = count(array_filter($asistencias, fn($a) => $a['estado'] === 'Falta'));
            $porcentaje = $total > 0 ? round(($asistio / $total) * 100, 1) : 0;
            ?>
            <div class="mt-3 p-3 bg-light rounded">
                <h6 class="mb-2">Resumen:</h6>
                <div class="row">
                    <div class="col-md-3">
                        <strong>Total clases:</strong> <?= $total ?>
                    </div>
                    <div class="col-md-3">
                        <strong class="text-success">Asistió:</strong> <?= $asistio ?>
                    </div>
                    <div class="col-md-3">
                        <strong class="text-warning">Tardanzas:</strong> <?= $tardanza ?>
                    </div>
                    <div class="col-md-3">
                        <strong class="text-danger">Faltas:</strong> <?= $faltas ?>
                    </div>
                </div>
                <div class="mt-2">
                    <strong>Porcentaje de asistencia:</strong> 
                    <span class="<?= $porcentaje >= 70 ? 'text-success' : 'text-danger' ?>">
                        <?= $porcentaje ?>%
                    </span>
                </div>
            </div>
        <?php endif; ?>
        
        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
        </a>
    </div>
</div>
<?= $this->endSection() ?>
