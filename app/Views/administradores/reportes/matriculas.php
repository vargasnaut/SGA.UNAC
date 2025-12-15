<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <a href="<?= base_url('dashboard/admin') ?>" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
            </a>
            
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Reportes de Matrícula por Periodo
                    </h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">Estadísticas de solicitudes y matrículas por periodo académico</p>
                    
                    <?php if (empty($periodos)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>No hay periodos académicos registrados.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Periodo</th>
                                        <th>Fechas</th>
                                        <th class="text-center">Total Matrículas</th>
                                        <th class="text-center">Solicitudes Pendientes</th>
                                        <th class="text-center">Solicitudes Aprobadas</th>
                                        <th class="text-center">Solicitudes Rechazadas</th>
                                        <th class="text-center">Tasa de Aprobación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($periodos as $periodo): ?>
                                        <?php 
                                        $stats = $estadisticas[$periodo['id']] ?? [];
                                        $total_solicitudes = ($stats['solicitudes_aprobadas'] ?? 0) + ($stats['solicitudes_rechazadas'] ?? 0);
                                        $tasa_aprobacion = $total_solicitudes > 0 
                                            ? round(($stats['solicitudes_aprobadas'] / $total_solicitudes) * 100, 1) 
                                            : 0;
                                        ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($periodo['nombre']) ?></strong>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y', strtotime($periodo['fecha_inicio'])) ?> - 
                                                    <?= date('d/m/Y', strtotime($periodo['fecha_fin'])) ?>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary fs-6">
                                                    <?= number_format($stats['total_matriculas'] ?? 0) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning fs-6">
                                                    <?= number_format($stats['solicitudes_pendientes'] ?? 0) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success fs-6">
                                                    <?= number_format($stats['solicitudes_aprobadas'] ?? 0) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-danger fs-6">
                                                    <?= number_format($stats['solicitudes_rechazadas'] ?? 0) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($total_solicitudes > 0): ?>
                                                    <div class="progress" style="height: 25px;">
                                                        <div class="progress-bar bg-success" 
                                                             role="progressbar" 
                                                             style="width: <?= $tasa_aprobacion ?>%">
                                                            <?= $tasa_aprobacion ?>%
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Gráfica Resumen -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3"><i class="fas fa-chart-pie me-2"></i>Resumen General</h5>
                            </div>
                            
                            <?php 
                            $total_general_matriculas = array_sum(array_column($estadisticas, 'total_matriculas'));
                            $total_general_pendientes = array_sum(array_column($estadisticas, 'solicitudes_pendientes'));
                            $total_general_aprobadas = array_sum(array_column($estadisticas, 'solicitudes_aprobadas'));
                            $total_general_rechazadas = array_sum(array_column($estadisticas, 'solicitudes_rechazadas'));
                            ?>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h2 class="mb-0"><?= number_format($total_general_matriculas) ?></h2>
                                        <p class="mb-0">Total Matrículas</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h2 class="mb-0"><?= number_format($total_general_pendientes) ?></h2>
                                        <p class="mb-0">Solicitudes Pendientes</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h2 class="mb-0"><?= number_format($total_general_aprobadas) ?></h2>
                                        <p class="mb-0">Solicitudes Aprobadas</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body text-center">
                                        <h2 class="mb-0"><?= number_format($total_general_rechazadas) ?></h2>
                                        <p class="mb-0">Solicitudes Rechazadas</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
