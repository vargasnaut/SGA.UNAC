<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Gestión de Cursos</h2>
            <p class="text-muted">Cursos asignados y gestión académica</p>
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
        <!-- Resumen -->
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <i class="fas fa-book fa-2x text-primary mb-2"></i>
                                <h4 class="mb-0"><?= count($cursos) ?></h4>
                                <small class="text-muted">Cursos asignados</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <i class="fas fa-users fa-2x text-success mb-2"></i>
                                <h4 class="mb-0">0</h4>
                                <small class="text-muted">Total estudiantes</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <i class="fas fa-clipboard-list fa-2x text-warning mb-2"></i>
                                <h4 class="mb-0">0</h4>
                                <small class="text-muted">Evaluaciones pendientes</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <i class="fas fa-calendar-check fa-2x text-info mb-2"></i>
                                <h4 class="mb-0">0</h4>
                                <small class="text-muted">Clases programadas</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Mis Cursos
                    </h5>
                    <div>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-filter me-1"></i>Filtrar
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($cursos)): ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h5>No tienes cursos asignados</h5>
                            <p class="mb-0">Aún no se te han asignado cursos para este periodo académico.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre del Curso</th>
                                        <th>Sección</th>
                                        <th>Estudiantes</th>
                                        <th>Horario</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cursos as $curso): ?>
                                        <tr>
                                            <td><strong><?= esc($curso['codigo_curso'] ?? '') ?></strong></td>
                                            <td><?= esc($curso['nombre'] ?? '') ?></td>
                                            <td><?= isset($curso['ciclo']) ? ('Ciclo ' . esc($curso['ciclo'])) : '—' ?></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= esc($curso['total_estudiantes'] ?? 0) ?> estudiantes
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    <?= esc($curso['horario'] ?? 'No definido') ?>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Activo</span>
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
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>

<?= $this->endSection() ?>
