<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>

<div class="container-fluid py-4">
    <h2 class="mb-4">
        <i class="fas fa-crown me-2 text-warning"></i>Panel de Administración
    </h2>

    <!-- Estadísticas Generales -->
    <div class="row g-4 mb-4">
        <!-- Total Estudiantes -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Estudiantes</p>
                            <h3 class="mb-0"><?= number_format($total_estudiantes) ?></h3>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="fas fa-user-graduate fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Docentes -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Docentes</p>
                            <h3 class="mb-0"><?= number_format($total_docentes) ?></h3>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Cursos -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Cursos</p>
                            <h3 class="mb-0"><?= number_format($total_cursos) ?></h3>
                        </div>
                        <div class="rounded-circle bg-info bg-opacity-10 p-3">
                            <i class="fas fa-book fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Matrículas Periodo Actual -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Matrículas <?= $periodo_actual ? $periodo_actual['nombre'] : '' ?></p>
                            <h3 class="mb-0"><?= number_format($matriculas_periodo) ?></h3>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="fas fa-clipboard-list fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas Pendientes -->
    <div class="row g-4 mb-4">
        <!-- Solicitudes Pendientes -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-circle me-2"></i>Solicitudes de Matrícula Pendientes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0 text-danger"><?= $solicitudes_pendientes ?></h2>
                            <p class="text-muted mb-0">Solicitudes por revisar</p>
                        </div>
                        <a href="<?= base_url('administradores/matriculas/solicitudes') ?>" class="btn btn-danger">
                            <i class="fas fa-arrow-right me-1"></i>Revisar Ahora
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trámites Pendientes -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>Trámites Pendientes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0 text-warning"><?= $tramites_pendientes ?></h2>
                            <p class="text-muted mb-0">Trámites por procesar</p>
                        </div>
                        <a href="<?= base_url('administrativos/tramites') ?>" class="btn btn-warning">
                            <i class="fas fa-arrow-right me-1"></i>Ver Trámites
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <h4 class="mb-3"><i class="fas fa-tachometer-alt me-2"></i>Accesos Rápidos</h4>
        </div>

        <!-- Gestión de Matrículas -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-4 d-inline-block mb-3">
                        <i class="fas fa-clipboard-check fa-3x text-danger"></i>
                    </div>
                    <h5 class="card-title">Solicitudes de Matrícula</h5>
                    <p class="card-text text-muted">Aprobar o rechazar solicitudes de matrícula de estudiantes</p>
                    <a href="<?= base_url('administradores/matriculas/solicitudes') ?>" class="btn btn-danger w-100">
                        <i class="fas fa-arrow-right me-1"></i>Gestionar
                    </a>
                </div>
            </div>
        </div>

        <!-- Reportes -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-4 d-inline-block mb-3">
                        <i class="fas fa-chart-bar fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Reportes de Matrícula</h5>
                    <p class="card-text text-muted">Estadísticas y reportes por periodo académico</p>
                    <a href="<?= base_url('administradores/reportes/matriculas') ?>" class="btn btn-primary w-100">
                        <i class="fas fa-arrow-right me-1"></i>Ver Reportes
                    </a>
                </div>
            </div>
        </div>

        <!-- Gestión de Usuarios -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-4 d-inline-block mb-3">
                        <i class="fas fa-users fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title">Gestión de Usuarios</h5>
                    <p class="card-text text-muted">Administrar estudiantes, docentes y personal</p>
                    <a href="#" class="btn btn-success w-100" onclick="alert('Módulo en desarrollo')">
                        <i class="fas fa-arrow-right me-1"></i>Gestionar
                    </a>
                </div>
            </div>
        </div>

        <!-- Mi Perfil -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-info bg-opacity-10 p-4 d-inline-block mb-3">
                        <i class="fas fa-user-shield fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title">Mi Perfil</h5>
                    <p class="card-text text-muted">Actualizar información personal y contraseña</p>
                    <a href="<?= base_url('administradores/perfil') ?>" class="btn btn-info w-100">
                        <i class="fas fa-arrow-right me-1"></i>Ver Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimas Solicitudes -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Últimas Solicitudes de Matrícula
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($ultimas_solicitudes)): ?>
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>No hay solicitudes registradas.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Estudiante</th>
                                        <th>Código</th>
                                        <th>Periodo</th>
                                        <th>Monto</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ultimas_solicitudes as $sol): ?>
                                        <tr>
                                            <td><strong>#<?= $sol['id'] ?></strong></td>
                                            <td><?= esc($sol['nombres'] . ' ' . $sol['apellidos']) ?></td>
                                            <td><span class="badge bg-secondary"><?= esc($sol['codigo_estudiante']) ?></span></td>
                                            <td><?= esc($sol['periodo_nombre']) ?></td>
                                            <td><strong class="text-success">S/ <?= number_format($sol['monto'], 2) ?></strong></td>
                                            <td><small><?= date('d/m/Y', strtotime($sol['fecha_solicitud'])) ?></small></td>
                                            <td>
                                                <?php
                                                $badgeClass = ['pendiente' => 'warning', 'aprobado' => 'success', 'rechazado' => 'danger'][$sol['estado']] ?? 'secondary';
                                                ?>
                                                <span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($sol['estado']) ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>

<?= $this->endSection() ?>
