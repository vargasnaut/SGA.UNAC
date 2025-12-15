<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<h3 class="mb-3">Calificaciones - <?= esc($curso['nombre']) ?></h3>
<?php if (session('success')): ?><div class="alert alert-success"><?= session('success') ?></div><?php endif; ?>
<?php if (session('error')): ?><div class="alert alert-danger"><?= session('error') ?></div><?php endif; ?>

<!-- Mostrar fórmula de calificación -->
<div class="card mb-3">
    <div class="card-header bg-light">
        <h5 class="mb-0">📋 Fórmula de Calificación</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if (!empty($formulas)): ?>
                <?php foreach ($formulas as $idx => $f): ?>
                    <div class="col-md-4">
                        <div class="alert alert-info mb-0">
                            <strong><?= esc($f['nombre_componente']) ?></strong><br>
                            <small><?= floatval($f['porcentaje']) ?>%</small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">No hay fórmula definida</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Estadísticas -->
<?php if (!empty($estadisticas)): ?>
<div class="row mb-3">
    <div class="col-md-2">
        <div class="alert alert-info mb-0 text-center">
            <small>Total</small><br>
            <strong><?= $estadisticas['total'] ?></strong>
        </div>
    </div>
    <div class="col-md-2">
        <div class="alert alert-primary mb-0 text-center">
            <small>Promedio</small><br>
            <strong><?= number_format($estadisticas['promedio'], 2) ?></strong>
        </div>
    </div>
    <div class="col-md-2">
        <div class="alert alert-success mb-0 text-center">
            <small>Aprobados</small><br>
            <strong><?= $estadisticas['aprobados'] ?></strong>
        </div>
    </div>
    <div class="col-md-2">
        <div class="alert alert-danger mb-0 text-center">
            <small>Desaprobados</small><br>
            <strong><?= $estadisticas['desaprobados'] ?></strong>
        </div>
    </div>
    <div class="col-md-2">
        <div class="alert alert-warning mb-0 text-center">
            <small>Máx</small><br>
            <strong><?= number_format($estadisticas['maxima'], 2) ?></strong>
        </div>
    </div>
    <div class="col-md-2">
        <div class="alert alert-secondary mb-0 text-center">
            <small>Mín</small><br>
            <strong><?= number_format($estadisticas['minima'], 2) ?></strong>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Formulario de calificaciones -->
<form method="post" action="<?= base_url('docente-direct/calificaciones/' . $curso['id']) ?>" name="form_calificaciones">
    <input type="hidden" name="guardar_notas" value="1">
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Estudiante</th>
                    <?php if (!empty($formulas)): ?>
                        <?php foreach ($formulas as $f): ?>
                            <th class="text-center"><?= esc($f['nombre_componente']) ?></th>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <th class="text-center">Nota Final</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($matriculados)): ?>
                    <tr><td colspan="<?= (count($formulas) + 2) ?>" class="text-center text-muted">No hay estudiantes matriculados.</td></tr>
                <?php else: ?>
                    <?php foreach ($matriculados as $m): ?>
                        <tr>
                            <!-- Nombre del estudiante -->
                            <td>
                                <strong><?= esc($m['apellidos'] . ', ' . $m['nombres']) ?></strong><br>
                                <small class="text-muted"><?= esc($m['codigo_estudiante']) ?></small>
                            </td>
                            
                            <!-- Componentes -->
                            <?php if (!empty($formulas)): ?>
                                <?php for ($i = 1; $i <= count($formulas); $i++): ?>
                                    <td class="text-center">
                                        <input type="number" step="0.01" min="0" max="20"
                                               name="matriculas[<?= $m['id'] ?>][componente<?= $i ?>]"
                                               value="<?= isset($m['componente' . $i]) && $m['componente' . $i] ? esc($m['componente' . $i]) : '' ?>"
                                               class="form-control form-control-sm text-center"
                                               placeholder="-">
                                    </td>
                                <?php endfor; ?>
                            <?php endif; ?>
                            
                            <!-- Nota Final (solo lectura) -->
                            <td class="text-center bg-light">
                                <strong><?= isset($m['nota_final']) && $m['nota_final'] ? number_format($m['nota_final'], 2) : '-' ?></strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-success" onclick="document.form_calificaciones.guardar_notas.value=1;">
            <i class="fas fa-save me-1"></i> Guardar Calificaciones
        </button>
        <a href="<?= base_url('docentes/facultad/fiis/sistemas/cursos') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
</form>

<?= $this->endSection() ?>

