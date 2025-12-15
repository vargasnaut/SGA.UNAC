<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Historial Académico</h2>
            <p class="text-muted"><?= esc($estudiante['nombres'] . ' ' . $estudiante['apellidos']) ?> - Código: <?= esc($estudiante['codigo_estudiante']) ?></p>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                    <h6>Promedio General</h6>
                    <h2 class="mb-0"><?= number_format($estadisticas['promedio_general'], 1) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h6 class="text-success">Cursos Aprobados</h6>
                    <h2 class="mb-0"><?= $estadisticas['cursos_aprobados'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                    <h6 class="text-danger">Cursos Desaprobados</h6>
                    <h2 class="mb-0"><?= $estadisticas['cursos_desaprobados'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-star fa-2x text-info mb-2"></i>
                    <h6 class="text-info">Créditos Acumulados</h6>
                    <h2 class="mb-0"><?= $estadisticas['creditos_acumulados'] ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen por Ciclo -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Resumen por Ciclo</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Ciclo</th>
                                    <th class="text-center">Cursos</th>
                                    <th class="text-center">Créditos</th>
                                    <th class="text-center">Promedio</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resumen_ciclos as $resumen): ?>
                                <tr>
                                    <td><span class="badge bg-secondary">Ciclo <?= $resumen['ciclo'] ?></span></td>
                                    <td class="text-center"><?= $resumen['total_cursos'] ?></td>
                                    <td class="text-center"><?= $resumen['total_creditos'] ?></td>
                                    <td class="text-center">
                                        <?php if ($resumen['promedio']): ?>
                                            <span class="badge <?= $resumen['promedio'] >= 11 ? 'bg-success' : 'bg-danger' ?>">
                                                <?= number_format($resumen['promedio'], 1) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($resumen['estado'] === 'completado'): ?>
                                            <span class="badge bg-success">Completado</span>
                                        <?php elseif ($resumen['estado'] === 'en_curso'): ?>
                                            <span class="badge bg-warning">En Curso</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Pendiente</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial Detallado por Ciclo -->
    <?php foreach ($historial_por_ciclo as $ciclo => $data): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-folder-open me-2"></i>Ciclo <?= $ciclo ?>
                        </h5>
                        <div>
                            <?php if ($data['promedio_ciclo']): ?>
                                <span class="badge bg-light text-dark me-2">
                                    Promedio: <?= number_format($data['promedio_ciclo'], 1) ?>
                                </span>
                            <?php endif; ?>
                            <span class="badge bg-light text-dark">
                                <?= $data['creditos_ciclo'] ?> créditos
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($data['cursos'])): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>No has cursado materias de este ciclo aún.
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($data['cursos'] as $curso): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-start border-4 <?= $curso['estado_curso'] === 'aprobado' ? 'border-success' : ($curso['estado_curso'] === 'desaprobado' ? 'border-danger' : 'border-warning') ?>">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">
                                                    <span class="badge bg-secondary"><?= esc($curso['codigo_curso']) ?></span>
                                                </h6>
                                                <p class="mb-0"><?= esc($curso['nombre']) ?></p>
                                            </div>
                                            <div class="text-end">
                                                <?php if ($curso['nota'] !== null): ?>
                                                    <h3 class="mb-0 <?= $curso['nota'] >= 11 ? 'text-success' : 'text-danger' ?>">
                                                        <?= $curso['nota'] ?>
                                                    </h3>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-book me-1"></i><?= $curso['creditos'] ?> créditos
                                            </small>
                                            <?php if ($curso['estado_curso'] === 'aprobado'): ?>
                                                <span class="badge bg-success">Aprobado</span>
                                            <?php elseif ($curso['estado_curso'] === 'desaprobado'): ?>
                                                <span class="badge bg-danger">Desaprobado</span>
                                            <?php elseif ($curso['estado_curso'] === 'en-curso'): ?>
                                                <span class="badge bg-warning">En Curso</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Pendiente</span>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($curso['periodo']): ?>
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i><?= esc($curso['periodo']) ?>
                                            </small>
                                        </div>
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
    <?php endforeach; ?>

    <?php if (empty($historial_por_ciclo)): ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <h4>Sin Historial Académico</h4>
                <p>Aún no has cursado ninguna materia. Una vez que te matricules y completes cursos, tu historial aparecerá aquí.</p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-12">
            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
            </a>
        </div>
    </div>
</div>

<style>
.card:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
</style>

<?= $this->endSection() ?>
