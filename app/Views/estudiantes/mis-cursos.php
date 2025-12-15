<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="fas fa-book-open me-2"></i>Mis Cursos</h2>
            <p class="text-muted">Cursos matriculados y gestión académica</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Cursos Matriculados
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($cursos)): ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h5>No tienes cursos matriculados</h5>
                            <p class="mb-0">Aún no estás matriculado en ningún curso para este periodo académico.</p>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($cursos as $curso): ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card border-primary h-100 shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0">
                                                <i class="fas fa-book me-2"></i>
                                                <?= esc($curso['nombre']) ?>
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted mb-2 small">
                                                <i class="fas fa-user me-1"></i>
                                                <strong>Docente:</strong><br>
                                                <?= esc($curso['docente_nombres'] . ' ' . $curso['docente_apellidos']) ?>
                                            </p>
                                            <p class="text-muted mb-3 small">
                                                <i class="fas fa-code me-1"></i>
                                                <strong>Código:</strong> <?= esc($curso['codigo_curso'] ?? 'N/A') ?>
                                            </p>
                                            <div class="d-grid gap-2">
                                                <a href="<?= base_url('estudiantes/calificaciones/' . $curso['id']) ?>" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Ver calificaciones">
                                                    <i class="fas fa-clipboard-check me-1"></i>Notas
                                                </a>
                                                <a href="<?= base_url('estudiantes/asistencias/' . $curso['id']) ?>" 
                                                   class="btn btn-sm btn-dark" 
                                                   title="Ver asistencias">
                                                    <i class="fas fa-user-check me-1"></i>Asistencia
                                                </a>
                                                <a href="<?= base_url('estudiantes/materiales/' . $curso['id']) ?>" 
                                                   class="btn btn-sm btn-success" 
                                                   title="Ver materiales">
                                                    <i class="fas fa-file-download me-1"></i>Materiales
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-white">
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}
</style>

<?= $this->endSection() ?>
