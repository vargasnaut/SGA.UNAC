<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<h3 class="mb-4">Solicitar Habilitación de Matrícula - <?= esc($periodo['nombre']) ?></h3>

<?php if (session('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>
<?php if (session('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-info-circle me-2 text-info"></i>
                    Proceso de Matrícula
                </h5>
                <ol class="mb-4">
                    <li>Subir comprobante de pago de matrícula</li>
                    <li>Esperar aprobación del área administrativa</li>
                    <li>Una vez aprobado, podrá seleccionar sus cursos</li>
                    <li>El sistema validará automáticamente los prerrequisitos</li>
                </ol>
                
                <?php if ($solicitud): ?>
                    <div class="alert alert-<?= $solicitud['estado'] === 'aprobado' ? 'success' : ($solicitud['estado'] === 'rechazado' ? 'danger' : 'warning') ?>">
                        <h6>Estado de Solicitud: 
                            <strong><?= ucfirst($solicitud['estado']) ?></strong>
                        </h6>
                        <p class="mb-1">
                            <i class="fas fa-calendar me-2"></i>
                            Fecha: <?= date('d/m/Y H:i', strtotime($solicitud['fecha_solicitud'])) ?>
                        </p>
                        <p class="mb-1">
                            <i class="fas fa-money-bill-wave me-2"></i>
                            Monto: S/. <?= number_format($solicitud['monto'], 2) ?>
                        </p>
                        <?php if ($solicitud['observaciones']): ?>
                            <p class="mb-0">
                                <i class="fas fa-comment me-2"></i>
                                Observaciones: <?= esc($solicitud['observaciones']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($solicitud['estado'] === 'aprobado'): ?>
                        <a href="<?= base_url('estudiantes/matricula/cursos') ?>" class="btn btn-primary btn-lg">
                            <i class="fas fa-list me-2"></i>Ir a Selección de Cursos
                        </a>
                    <?php elseif ($solicitud['estado'] === 'rechazado'): ?>
                        <p class="text-muted">Su solicitud fue rechazada. Puede enviar una nueva solicitud con un comprobante válido.</p>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-hourglass-half me-2"></i>
                            Su solicitud está en revisión. Le notificaremos cuando sea aprobada.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php if (!$solicitud || $solicitud['estado'] === 'rechazado'): ?>
                    <hr>
                    <h5 class="mb-3">Subir Comprobante de Pago</h5>
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Monto Pagado (S/.)</label>
                            <input type="number" step="0.01" name="monto" class="form-control" required value="350.00">
                            <small class="text-muted">Monto de matrícula: S/. 350.00</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comprobante de Pago (JPG, PNG, PDF)</label>
                            <input type="file" name="comprobante_pago" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-upload me-2"></i>Enviar Solicitud
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="fas fa-calendar-alt me-2"></i>Periodo Académico
                </h6>
                <p class="mb-1"><strong><?= esc($periodo['nombre']) ?></strong></p>
                <p class="mb-0 small text-muted">
                    <?= date('d/m/Y', strtotime($periodo['fecha_inicio'])) ?> - 
                    <?= date('d/m/Y', strtotime($periodo['fecha_fin'])) ?>
                </p>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="fas fa-question-circle me-2"></i>¿Necesita ayuda?
                </h6>
                <p class="small mb-2">Si tiene problemas con su pago o solicitud, contacte al área de Registro:</p>
                <p class="small mb-0">
                    <i class="fas fa-envelope me-1"></i> registro@unac.edu.pe<br>
                    <i class="fas fa-phone me-1"></i> (01) 453-3330
                </p>
            </div>
        </div>
    </div>
</div>

<a href="<?= base_url('dashboard') ?>" class="btn btn-secondary mt-3">
    <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
</a>
<?= $this->endSection() ?>
