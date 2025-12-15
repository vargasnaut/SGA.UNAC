<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<h3 class="mb-3">Asistencia - <?= esc($curso['nombre']) ?></h3>
<?php if (session('success')): ?><div class="alert alert-success"><?= session('success') ?></div><?php endif; ?>
<?php if (session('error')): ?><div class="alert alert-danger"><?= session('error') ?></div><?php endif; ?>

<form method="post" action="<?= base_url('docente-direct/asistencias/' . $curso['id']) ?>" name="form_asistencia">
    <div class="row g-2 align-items-end mb-3">
        <div class="col-md-3">
            <label class="form-label"><strong>📅 Fecha</strong></label>
            <input type="date" name="fecha_asistencia" value="<?= esc($fecha_seleccionada) ?>" class="form-control">
        </div>
        
        <?php if (!empty($fechas_clases)): ?>
        <div class="col-md-9">
            <label class="form-label"><strong>📚 Próximos días de clase:</strong></label>
            <div class="d-flex flex-wrap gap-2">
                <?php 
                $proximasFechas = array_slice($fechas_clases, 0, 5);
                foreach ($proximasFechas as $fc):
                    $btn_class = ($fc['fecha'] === $fecha_seleccionada) ? 'btn-primary' : 'btn-outline-secondary';
                ?>
                    <button type="button" class="btn btn-sm <?= $btn_class ?>" onclick="document.form_asistencia.fecha_asistencia.value='<?= $fc['fecha'] ?>';">
                        <?= esc($fc['dia_nombre']) ?> - <?= date('d/m', strtotime($fc['fecha'])) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($resumen_general)): ?>
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="row">
                <div class="col-md-2">
                    <div class="text-center">
                        <strong><?= $resumen_general['total'] ?? 0 ?></strong>
                        <small class="d-block text-muted">Total Estudiantes</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="text-center text-success">
                        <strong><?= $resumen_general['asistio'] ?? 0 ?></strong>
                        <small class="d-block">Asistió</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="text-center text-warning">
                        <strong><?= $resumen_general['tardanza'] ?? 0 ?></strong>
                        <small class="d-block">Tardanza</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="text-center text-danger">
                        <strong><?= $resumen_general['falta'] ?? 0 ?></strong>
                        <small class="d-block">Falta</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="text-center text-info">
                        <strong><?= $resumen_general['justificado'] ?? 0 ?></strong>
                        <small class="d-block">Justificado</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="text-center">
                        <strong><?= number_format($resumen_general['porcentaje'] ?? 0, 1) ?>%</strong>
                        <small class="d-block text-muted">Asistencia</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Estudiante</th>
                    <th>Cód. Est.</th>
                    <th style="width: 200px;">Estado</th>
                    <th class="text-center">Asistencia %</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($matriculados)): ?>
                    <tr><td colspan="4" class="text-center text-muted">No hay estudiantes matriculados.</td></tr>
                <?php else: ?>
                    <?php foreach ($matriculados as $m): ?>
                        <tr>
                            <td>
                                <strong><?= esc($m['apellidos'] . ', ' . $m['nombres']) ?></strong>
                            </td>
                            <td>
                                <small class="text-muted"><?= esc($m['codigo_estudiante']) ?></small>
                            </td>
                            <td>
                                <select name="asistencia[<?= $m['id'] ?>]" class="form-select form-select-sm">
                                    <option value="Asistió" <?= ($m['asistencia'] ?? 'Falta') === 'Asistió' ? 'selected' : '' ?>>✓ Asistió</option>
                                    <option value="Tardanza" <?= ($m['asistencia'] ?? 'Falta') === 'Tardanza' ? 'selected' : '' ?>>⏰ Tardanza</option>
                                    <option value="Falta" <?= ($m['asistencia'] ?? 'Falta') === 'Falta' ? 'selected' : '' ?>>✗ Falta</option>
                                    <option value="Justificado" <?= ($m['asistencia'] ?? 'Falta') === 'Justificado' ? 'selected' : '' ?>>📋 Justificado</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <?php if (!empty($m['resumen_asistencia'])): ?>
                                    <span class="badge bg-info"><?= number_format($m['resumen_asistencia']['porcentaje_asistencia'] ?? 0, 1) ?>%</span>
                                    <br>
                                    <small class="text-muted">
                                        (<?= ($m['resumen_asistencia']['asistio'] ?? 0) + ($m['resumen_asistencia']['tardanza'] ?? 0) ?>/<?= $m['resumen_asistencia']['total'] ?? 0 ?>)
                                    </small>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-1"></i> Guardar Asistencia
        </button>
        <a href="<?= base_url('docentes/facultad/fiis/sistemas/cursos') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
</form>

<?= $this->endSection() ?>


