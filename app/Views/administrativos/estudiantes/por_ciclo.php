<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="fas fa-users text-primary"></i> Estudiantes por Ciclo</h2>
            <p class="text-muted">Distribución de estudiantes según créditos acumulados</p>
        </div>
    </div>

    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Resumen por Ciclos -->
    <div class="row mb-4">
        <?php 
        $colores = [
            1 => ['bg' => 'primary', 'icon' => 'fa-seedling'],
            2 => ['bg' => 'info', 'icon' => 'fa-leaf'],
            3 => ['bg' => 'success', 'icon' => 'fa-tree'],
            4 => ['bg' => 'warning', 'icon' => 'fa-mountain'],
            5 => ['bg' => 'orange', 'icon' => 'fa-rocket'],
            6 => ['bg' => 'danger', 'icon' => 'fa-crown'],
            7 => ['bg' => 'purple', 'icon' => 'fa-star'],
            8 => ['bg' => 'dark', 'icon' => 'fa-trophy'],
            9 => ['bg' => 'indigo', 'icon' => 'fa-medal'],
            10 => ['bg' => 'success', 'icon' => 'fa-graduation-cap']
        ];
        ?>
        
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="<?= base_url('administrativos/estudiantes/por-ciclo?ciclo=' . $i) ?>" 
                   class="text-decoration-none">
                    <div class="card h-100 hover-card <?= $cicloFiltro == $i ? 'border-primary border-3' : '' ?>">
                        <div class="card-body text-center">
                            <div class="mb-2">
                                <i class="fas <?= $colores[$i]['icon'] ?> fa-2x text-<?= $colores[$i]['bg'] ?>"></i>
                            </div>
                            <h5 class="mb-1">Ciclo <?= $i ?></h5>
                            <h3 class="mb-0 text-<?= $colores[$i]['bg'] ?>">
                                <?= $resumenCiclos[$i] ?? 0 ?>
                            </h3>
                            <small class="text-muted">estudiantes</small>
                        </div>
                    </div>
                </a>
            </div>
        <?php endfor; ?>
    </div>

    <!-- Filtros y Acciones -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-filter"></i> Filtrar por Ciclo
                    </label>
                    <select class="form-select" id="filtroCiclo" onchange="filtrarPorCiclo()">
                        <option value="">Todos los ciclos</option>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>" <?= $cicloFiltro == $i ? 'selected' : '' ?>>
                                Ciclo <?= $i ?> (<?= $resumenCiclos[$i] ?? 0 ?> estudiantes)
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-search"></i> Buscar Estudiante
                    </label>
                    <input type="text" class="form-control" id="buscarEstudiante" 
                           placeholder="Código, nombre o apellido...">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold d-block">&nbsp;</label>
                    <button class="btn btn-outline-secondary" onclick="limpiarFiltros()">
                        <i class="fas fa-times"></i> Limpiar Filtros
                    </button>
                    <button class="btn btn-success" onclick="exportarExcel()">
                        <i class="fas fa-file-excel"></i> Exportar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Estudiantes -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-list"></i> 
                <span id="tituloLista">
                    <?php if ($cicloFiltro): ?>
                        Estudiantes de Ciclo <?= $cicloFiltro ?>
                    <?php else: ?>
                        Todos los Estudiantes
                    <?php endif; ?>
                </span>
                <span class="badge bg-primary ms-2" id="totalMostrados">
                    <?= count($estudiantes) ?> estudiantes
                </span>
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0" id="tablaEstudiantes">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Código</th>
                            <th>Estudiante</th>
                            <th class="text-center">Ciclo Actual</th>
                            <th class="text-center">Créditos</th>
                            <th class="text-center">Cursos Aprobados</th>
                            <th class="text-center">Año Ingreso</th>
                            <th>Email</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($estudiantes)): ?>
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No se encontraron estudiantes</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($estudiantes as $index => $estudiante): ?>
                                <tr data-ciclo="<?= $estudiante['ciclo_actual'] ?>" 
                                    data-codigo="<?= $estudiante['codigo_estudiante'] ?>"
                                    data-nombre="<?= strtolower($estudiante['nombres'] . ' ' . $estudiante['apellidos']) ?>">
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= esc($estudiante['codigo_estudiante']) ?></strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?= esc($estudiante['apellidos']) ?>, <?= esc($estudiante['nombres']) ?></strong>
                                        </div>
                                        <?php if ($estudiante['telefono']): ?>
                                            <small class="text-muted">
                                                <i class="fas fa-phone fa-xs"></i> <?= esc($estudiante['telefono']) ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        $ciclo = $estudiante['ciclo_actual'];
                                        $colorCiclo = $colores[$ciclo]['bg'] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?= $colorCiclo ?> fs-6">
                                            <i class="fas <?= $colores[$ciclo]['icon'] ?? 'fa-circle' ?>"></i>
                                            Ciclo <?= $ciclo ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-success">
                                            <?= number_format($estudiante['creditos_acumulados'], 0) ?>
                                        </strong>
                                        <small class="text-muted d-block">/ 220</small>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-success" 
                                                 style="width: <?= min(($estudiante['creditos_acumulados'] / 220) * 100, 100) ?>%">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">
                                            <?= $estudiante['cursos_completados'] ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">
                                            <?= esc($estudiante['anio_ingreso']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-envelope fa-xs"></i> 
                                            <?= esc($estudiante['email'] ?? 'Sin email') ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($estudiante['usuario_estado'] == 'activo'): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Activo
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle"></i> Inactivo
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info" 
                                                onclick="verDetalle(<?= $estudiante['id'] ?>)"
                                                title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
    cursor: pointer;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.bg-orange {
    background-color: #fd7e14 !important;
}
.text-orange {
    color: #fd7e14 !important;
}
.bg-purple {
    background-color: #6f42c1 !important;
}
.text-purple {
    color: #6f42c1 !important;
}
.bg-indigo {
    background-color: #6610f2 !important;
}
.text-indigo {
    color: #6610f2 !important;
}
</style>

<?= $this->section('scripts') ?>
<script>
// Filtrar por ciclo
function filtrarPorCiclo() {
    const ciclo = document.getElementById('filtroCiclo').value;
    if (ciclo) {
        window.location.href = '<?= base_url('administrativos/estudiantes/por-ciclo') ?>?ciclo=' + ciclo;
    } else {
        window.location.href = '<?= base_url('administrativos/estudiantes/por-ciclo') ?>';
    }
}

// Buscar estudiante en tiempo real
document.getElementById('buscarEstudiante').addEventListener('keyup', function() {
    const texto = this.value.toLowerCase();
    const filas = document.querySelectorAll('#tablaEstudiantes tbody tr[data-codigo]');
    let contador = 0;
    
    filas.forEach(function(fila) {
        const codigo = fila.getAttribute('data-codigo').toLowerCase();
        const nombre = fila.getAttribute('data-nombre');
        
        if (codigo.includes(texto) || nombre.includes(texto)) {
            fila.style.display = '';
            contador++;
        } else {
            fila.style.display = 'none';
        }
    });
    
    document.getElementById('totalMostrados').textContent = contador + ' estudiantes';
});

// Limpiar filtros
function limpiarFiltros() {
    document.getElementById('filtroCiclo').value = '';
    document.getElementById('buscarEstudiante').value = '';
    window.location.href = '<?= base_url('administrativos/estudiantes/por-ciclo') ?>';
}

// Ver detalle del estudiante
function verDetalle(id) {
    // TODO: Implementar modal o redirigir a página de detalle
    alert('Función de ver detalle del estudiante ID: ' + id + '\n(Por implementar)');
}

// Exportar a Excel
function exportarExcel() {
    // Obtener la tabla
    const tabla = document.getElementById('tablaEstudiantes');
    let html = '<table>';
    
    // Recorrer filas
    const filas = tabla.querySelectorAll('tr');
    filas.forEach((fila, i) => {
        if (fila.style.display !== 'none') {
            html += '<tr>';
            const celdas = fila.querySelectorAll('th, td');
            celdas.forEach((celda, j) => {
                // Excluir columna de acciones
                if (j < celdas.length - 1) {
                    const tag = i === 0 ? 'th' : 'td';
                    html += '<' + tag + '>' + celda.textContent.trim() + '</' + tag + '>';
                }
            });
            html += '</tr>';
        }
    });
    html += '</table>';
    
    // Crear blob y descargar
    const blob = new Blob([html], {type: 'application/vnd.ms-excel'});
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'estudiantes_por_ciclo_' + new Date().getTime() + '.xls';
    a.click();
    window.URL.revokeObjectURL(url);
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
