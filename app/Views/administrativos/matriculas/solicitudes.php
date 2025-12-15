<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-clipboard-check me-2"></i>Solicitudes de Matrícula
                    </h4>
                </div>
                <div class="card-body">
                    
                    <?php if (session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= session('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Filtros rápidos -->
                    <div class="mb-3">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-secondary active" onclick="filtrarSolicitudes('todas')">
                                <i class="fas fa-list me-1"></i>Todas
                            </button>
                            <button type="button" class="btn btn-outline-warning" onclick="filtrarSolicitudes('pendiente')">
                                <i class="fas fa-clock me-1"></i>Pendientes
                            </button>
                            <button type="button" class="btn btn-outline-success" onclick="filtrarSolicitudes('aprobado')">
                                <i class="fas fa-check me-1"></i>Aprobadas
                            </button>
                            <button type="button" class="btn btn-outline-danger" onclick="filtrarSolicitudes('rechazado')">
                                <i class="fas fa-times me-1"></i>Rechazadas
                            </button>
                        </div>
                    </div>

                    <?php if (empty($solicitudes)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>No hay solicitudes de matrícula registradas.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="tablaSolicitudes">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Estudiante</th>
                                        <th>Código</th>
                                        <th>Periodo</th>
                                        <th>Monto</th>
                                        <th>Fecha Solicitud</th>
                                        <th>Estado</th>
                                        <th>Revisado Por</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($solicitudes as $sol): ?>
                                        <tr data-estado="<?= esc($sol['estado']) ?>">
                                            <td><strong>#<?= esc($sol['id']) ?></strong></td>
                                            <td>
                                                <i class="fas fa-user-graduate me-1 text-primary"></i>
                                                <?= esc($sol['nombres'] . ' ' . $sol['apellidos']) ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary"><?= esc($sol['codigo_estudiante']) ?></span>
                                            </td>
                                            <td>
                                                <strong><?= esc($sol['periodo_nombre']) ?></strong>
                                            </td>
                                            <td>
                                                <span class="text-success fw-bold">S/ <?= number_format($sol['monto'], 2) ?></span>
                                            </td>
                                            <td>
                                                <small>
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    <?= date('d/m/Y H:i', strtotime($sol['fecha_solicitud'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <?php 
                                                $badgeClass = [
                                                    'pendiente' => 'warning',
                                                    'aprobado' => 'success',
                                                    'rechazado' => 'danger'
                                                ][$sol['estado']] ?? 'secondary';
                                                
                                                $iconClass = [
                                                    'pendiente' => 'clock',
                                                    'aprobado' => 'check-circle',
                                                    'rechazado' => 'times-circle'
                                                ][$sol['estado']] ?? 'question-circle';
                                                ?>
                                                <span class="badge bg-<?= $badgeClass ?>">
                                                    <i class="fas fa-<?= $iconClass ?> me-1"></i>
                                                    <?= ucfirst(esc($sol['estado'])) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($sol['revisado_por']): ?>
                                                    <small class="text-muted">
                                                        <?= esc($sol['admin_nombres'] . ' ' . $sol['admin_apellidos']) ?>
                                                        <br>
                                                        <i class="far fa-clock"></i> <?= date('d/m/Y', strtotime($sol['fecha_revision'])) ?>
                                                    </small>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <!-- Ver Detalle -->
                                                    <a href="<?= base_url('administrativos/matriculas/ver/' . $sol['id']) ?>" 
                                                       class="btn btn-info" 
                                                       title="Ver Detalle">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    <!-- Ver Comprobante -->
                                                    <a href="<?= base_url('administrativos/matriculas/comprobante/' . $sol['id']) ?>" 
                                                       class="btn btn-secondary" 
                                                       title="Ver Comprobante"
                                                       target="_blank">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </a>
                                                    
                                                    <?php if ($sol['estado'] === 'pendiente'): ?>
                                                        <!-- Aprobar -->
                                                        <button class="btn btn-success" 
                                                                title="Aprobar"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modalAprobar"
                                                                onclick="setearSolicitud(<?= $sol['id'] ?>, '<?= esc($sol['nombres'] . ' ' . $sol['apellidos']) ?>')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        
                                                        <!-- Rechazar -->
                                                        <button class="btn btn-danger" 
                                                                title="Rechazar"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modalRechazar"
                                                                onclick="setearSolicitud(<?= $sol['id'] ?>, '<?= esc($sol['nombres'] . ' ' . $sol['apellidos']) ?>')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
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

<!-- Modal para Aprobar Solicitud -->
<div class="modal fade" id="modalAprobar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="formAprobar">
                <?= csrf_field() ?>
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>Aprobar Solicitud de Matrícula
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de aprobar la solicitud de matrícula de:</p>
                    <h6 class="text-center mb-3"><strong id="nombreEstudianteAprobar"></strong></h6>
                    
                    <div class="mb-3">
                        <label class="form-label">Observaciones (opcional)</label>
                        <textarea class="form-control" name="observaciones" rows="3" 
                                  placeholder="Ej: Solicitud aprobada, puede proceder a matricularse en sus cursos.">Solicitud aprobada correctamente</textarea>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        El estudiante recibirá una notificación automática y podrá seleccionar sus cursos.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>Aprobar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Rechazar Solicitud -->
<div class="modal fade" id="modalRechazar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="formRechazar">
                <?= csrf_field() ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-times-circle me-2"></i>Rechazar Solicitud de Matrícula
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de rechazar la solicitud de matrícula de:</p>
                    <h6 class="text-center mb-3"><strong id="nombreEstudianteRechazar"></strong></h6>
                    
                    <div class="mb-3">
                        <label class="form-label">Motivo del rechazo <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="observaciones" rows="4" 
                                  placeholder="Ej: El comprobante de pago no es válido, la fecha está vencida..." 
                                  required></textarea>
                        <small class="text-muted">Este mensaje será enviado al estudiante.</small>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        El estudiante deberá presentar una nueva solicitud con los datos correctos.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i>Rechazar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let solicitudActualId = null;
    let estudianteActualNombre = null;

    function setearSolicitud(id, nombre) {
        solicitudActualId = id;
        estudianteActualNombre = nombre;
        document.getElementById('nombreEstudianteAprobar').textContent = nombre;
        document.getElementById('nombreEstudianteRechazar').textContent = nombre;
        document.getElementById('formAprobar').action = '<?= base_url('administrativos/matriculas/actualizar/') ?>' + id;
        const hiddenA = document.createElement('input'); hiddenA.type='hidden'; hiddenA.name='accion'; hiddenA.value='aprobar';
        const formA = document.getElementById('formAprobar');
        // Remove old hidden if exists
        const oldA = formA.querySelector('input[name="accion"]'); if (oldA) oldA.remove();
        formA.appendChild(hiddenA);

        document.getElementById('formRechazar').action = '<?= base_url('administrativos/matriculas/actualizar/') ?>' + id;
        const hiddenR = document.createElement('input'); hiddenR.type='hidden'; hiddenR.name='accion'; hiddenR.value='rechazar';
        const formR = document.getElementById('formRechazar');
        const oldR = formR.querySelector('input[name="accion"]'); if (oldR) oldR.remove();
        formR.appendChild(hiddenR);
    }

    function filtrarSolicitudes(estado) {
        const filas = document.querySelectorAll('#tablaSolicitudes tbody tr');
        const botones = document.querySelectorAll('.btn-group .btn');
        
        // Actualizar botones activos
        botones.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        // Filtrar filas
        filas.forEach(fila => {
            const estadoFila = fila.getAttribute('data-estado');
            if (estado === 'todas' || estadoFila === estado) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    }
</script>

<?= $this->endSection() ?>
