<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>

<style>
.bg-orange {
    background-color: #fd7e14 !important;
}
.text-orange {
    color: #fd7e14 !important;
}
.progress-bar.bg-danger {
    background-color: #dc3545 !important;
}
.progress-bar.bg-warning {
    background-color: #ffc107 !important;
}
.progress-bar.bg-success {
    background-color: #198754 !important;
}
</style>

<h3 class="mb-3 d-flex align-items-center justify-content-between">
    <span>Selección de Cursos - <?= esc($periodo['nombre']) ?></span>
    <!-- Botón 'Ver mi horario' eliminado -->
</h3>

<?php if (session('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>
<?php if (session('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
<?php endif; ?>

<!-- Información del Estudiante -->
<div class="alert alert-primary mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h5 class="mb-2">
                <i class="fas fa-user-graduate me-2"></i>
                <?= esc($estudiante['nombres'] . ' ' . $estudiante['apellidos']) ?>
            </h5>
            <p class="mb-0">
                <strong>Ciclo Actual:</strong> <span class="badge bg-primary fs-6">Ciclo <?= $ciclo_actual ?></span>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <strong>Créditos Acumulados:</strong> <?= $creditos_acumulados ?>
            </p>
        </div>
        <div class="col-md-4 text-end">
            <div class="badge bg-info fs-6">
                <i class="fas fa-book-open me-1"></i>
                Solo cursos de Ciclo <?= $ciclo_actual ?>
            </div>
        </div>
    </div>
</div>

<!-- Información de Créditos -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h5 class="card-title text-primary">
                    <i class="fas fa-graduation-cap me-2"></i>Créditos Actuales
                </h5>
                <h2 class="mb-0">
                    <span class="badge bg-primary fs-4"><?= $creditos_actuales ?? 0 ?></span>
                </h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body text-center">
                <h5 class="card-title text-success">
                    <i class="fas fa-check-circle me-2"></i>Créditos Disponibles
                </h5>
                <h2 class="mb-0">
                    <span class="badge bg-success fs-4"><?= $creditos_disponibles ?? 22 ?></span>
                </h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-info">
            <div class="card-body text-center">
                <h5 class="card-title text-info">
                    <i class="fas fa-chart-line me-2"></i>Límite Máximo
                </h5>
                <h2 class="mb-0">
                    <span class="badge bg-info fs-4"><?= $limite_creditos ?? 22 ?></span>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info mb-4">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Información importante:</strong>
    Solo puedes matricularte en cursos de tu ciclo actual (Ciclo <?= $ciclo_actual ?>). Los cursos mostrados son los correspondientes a este ciclo.
    <ul class="mb-0 mt-2">
        <li>Prerrequisitos aprobados con nota ≥ 10.5</li>
        <li>Máximo 22 créditos por ciclo</li>
        <li>Sin conflictos de horario</li>
        <li>Cupos disponibles en el curso</li>
    </ul>
</div>

<?php
// Agrupar cursos por ciclo
$cursosPorCiclo = [];
foreach ($cursos as $curso) {
    $ciclo = $curso['ciclo'] ?? 1;
    if (!isset($cursosPorCiclo[$ciclo])) {
        $cursosPorCiclo[$ciclo] = [];
    }
    $cursosPorCiclo[$ciclo][] = $curso;
}
ksort($cursosPorCiclo);
?>

<?php foreach ($cursosPorCiclo as $ciclo => $cursosCiclo): ?>
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-layer-group me-2"></i>Ciclo <?= $ciclo ?>
            </h5>
        </div>
        <div class="card-body">
            <!-- Filtros locales -->
            <div class="row g-2 mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control form-control-sm filter-search" placeholder="Buscar curso por nombre o código..." data-target="#tabla-ciclo-<?= $ciclo ?>">
                </div>
                <div class="col-md-3">
                    <select class="form-select form-select-sm filter-estado" data-target="#tabla-ciclo-<?= $ciclo ?>">
                        <option value="">Filtrar por estado</option>
                        <option value="matriculado">Matriculado</option>
                        <option value="disponible">Disponible</option>
                        <option value="lleno">Lleno</option>
                        <option value="conflicto">Conflicto</option>
                        <option value="bloqueado">Bloqueado</option>
                    </select>
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-outline-secondary btn-sm btn-refresh-cupos" data-scope="#tabla-ciclo-<?= $ciclo ?>">
                        <i class="fas fa-rotate me-1"></i> Actualizar cupos
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tabla-ciclo-<?= $ciclo ?>">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Curso</th>
                            <th>Créditos</th>
                            <th>Cupos</th>
                            <th>Docente</th>
                            <th>Estado</th>
                            <!-- <th>Acción</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cursosCiclo as $curso): ?>
                            <tr data-curso-id="<?= $curso['id'] ?>" data-estado="<?= $curso['estado'] ?>">
                                <td><code><?= esc($curso['codigo_curso'] ?? '-') ?></code></td>
                                <td>
                                    <strong><?= esc($curso['nombre']) ?></strong>
                                    
                                    <?php if (!empty($curso['horarios'])): ?>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <?php 
                                            $horariosTexto = array_map(function($h) {
                                                return $h['dia_semana'] . ' ' . substr($h['hora_inicio'], 0, 5) . '-' . substr($h['hora_fin'], 0, 5);
                                            }, $curso['horarios']);
                                            echo implode(', ', $horariosTexto);
                                            ?>
                                        </small>
                                        <br>
                                        <small class="text-info">
                                            <i class="fas fa-door-open me-1"></i>
                                            <?php 
                                            $aulas = array_unique(array_column($curso['horarios'], 'aula'));
                                            echo implode(', ', $aulas);
                                            ?>
                                        </small>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($curso['prerrequisitos_pendientes'])): ?>
                                        <br>
                                        <small class="text-danger">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Requiere: 
                                            <?php 
                                            $pendientes = array_map(function($p) {
                                                return $p['codigo'] . ' (' . ($p['aprobado'] > 0 ? 'Nota: ' . $p['aprobado'] : 'No cursado') . ')';
                                            }, $curso['prerrequisitos_pendientes']);
                                            echo implode(', ', $pendientes);
                                            ?>
                                        </small>
                                    <?php endif; ?>
                                    
                                    <?php /* Mensaje de conflicto oculto - se permite matrícula */ ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?= $curso['creditos'] ?></span>
                                </td>
                                <td>
                                    <?php if (isset($curso['cupos_info'])): ?>
                                        <?php 
                                        $cupos = $curso['cupos_info'];
                                        $porcentaje = ($cupos['total_cupos'] > 0) ? 
                                            round(($cupos['matriculados'] / $cupos['total_cupos']) * 100) : 0;
                                        
                                        $colorClase = 'success';
                                        if ($porcentaje >= 90) $colorClase = 'danger';
                                        elseif ($porcentaje >= 70) $colorClase = 'warning';
                                        ?>
                                        
                                        <div class="text-nowrap cupo-wrapper" data-cupo>
                                            <small class="d-block">
                                                <strong class="cupo-restantes text-<?= $colorClase ?>"><?= $cupos['cupos_restantes'] ?></strong> 
                                                / <span class="cupo-total"><?= $cupos['total_cupos'] ?></span>
                                            </small>
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar bg-<?= $colorClase ?> cupo-bar" 
                                                     role="progressbar" 
                                                     style="width: <?= $porcentaje ?>%"
                                                     aria-valuenow="<?= $porcentaje ?>" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <small class="text-muted">-</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small><?= esc($curso['docente_nombres'] ?? 'Sin asignar') ?></small>
                                </td>
                                <td>
                                    <?php if ($curso['estado'] === 'matriculado'): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Matriculado
                                        </span>
                                    <?php elseif ($curso['estado'] === 'lleno'): ?>
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-users me-1"></i>Lleno
                                        </span>
                                    <?php elseif ($curso['estado'] === 'conflicto'): ?>
                                        <span class="badge bg-orange text-white">
                                            <i class="fas fa-clock me-1"></i>Conflicto
                                        </span>
                                    <?php elseif ($curso['estado'] === 'bloqueado'): ?>
                                        <span class="badge bg-danger">
                                            <i class="fas fa-lock me-1"></i>Bloqueado
                                        </span>
                                    <?php elseif ($curso['estado'] === 'disponible'): ?>
                                        <a href="<?= base_url('estudiantes/matricula/matricular/' . $curso['id']) ?>" 
                                           class="btn btn-sm btn-success"
                                           onclick="return confirm('¿Confirma la matrícula en este curso?\n\nCréditos actuales: <?= $creditos_actuales ?? 0 ?>\nNuevos créditos: <?= $curso['creditos'] ?>\nTotal: <?= ($creditos_actuales ?? 0) + $curso['creditos'] ?>/<?= $limite_creditos ?? 22 ?>')">
                                            <i class="fas fa-plus-circle me-1"></i>Matricular
                                        </a>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-lock me-1"></i>No disponible
                                        </span>
                                    <?php endif; ?>
                                    <?php if (isset($curso['motivo']) && $curso['motivo']): ?>
                                        <br><small class="text-muted"><?= esc($curso['motivo']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <!-- <td>
                                    Acción eliminada
                                </td> -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="mt-3">
    <a href="<?= base_url('estudiantes/matricula/solicitar') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Volver
    </a>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Filtro por búsqueda y estado
document.querySelectorAll('.filter-search').forEach(inp => {
    inp.addEventListener('input', function() {
        const tableSel = this.getAttribute('data-target');
        const q = this.value.toLowerCase();
        document.querySelectorAll(tableSel + ' tbody tr').forEach(tr => {
            const text = tr.innerText.toLowerCase();
            tr.style.display = text.includes(q) ? '' : 'none';
        });
    });
});

document.querySelectorAll('.filter-estado').forEach(sel => {
    sel.addEventListener('change', function() {
        const tableSel = this.getAttribute('data-target');
        const v = this.value;
        document.querySelectorAll(tableSel + ' tbody tr').forEach(tr => {
            const estado = tr.getAttribute('data-estado') || '';
            tr.style.display = (!v || estado === v) ? '' : 'none';
        });
    });
});

// Actualización de cupos (manual y automática)
function refreshCuposIn(scope) {
    document.querySelectorAll(scope + ' tbody tr[data-curso-id]').forEach(tr => {
        const cursoId = tr.getAttribute('data-curso-id');
        fetch('<?= base_url('estudiantes/matricula/cupos') ?>/' + cursoId, { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
            .then(r => r.json())
            .then(data => {
                const wrap = tr.querySelector('[data-cupo]');
                if (!wrap || !data || data.error) return;
                const rest = wrap.querySelector('.cupo-restantes');
                const tot = wrap.querySelector('.cupo-total');
                const bar = wrap.querySelector('.cupo-bar');
                if (rest) rest.textContent = data.cupos_restantes;
                if (tot) tot.textContent = data.total_cupos;
                if (bar) {
                    bar.style.width = data.porcentaje + '%';
                    bar.classList.remove('bg-success','bg-warning','bg-danger');
                    bar.classList.add('bg-' + data.color);
                }
            })
            .catch(() => {});
    });
}

document.querySelectorAll('.btn-refresh-cupos').forEach(btn => {
    btn.addEventListener('click', function() {
        const scope = this.getAttribute('data-scope');
        refreshCuposIn(scope);
    });
});

// Auto refresh cada 20s para todas las tablas
setInterval(() => { 
    document.querySelectorAll('table[id^="tabla-ciclo-"]').forEach(tbl => refreshCuposIn('#' + tbl.id));
}, 20000);
</script>
<?= $this->endSection() ?>
