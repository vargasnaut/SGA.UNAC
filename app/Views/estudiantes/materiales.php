<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<h3 class="mb-3">Materiales - <?= esc($curso['nombre']) ?></h3>

<div class="card">
    <div class="card-body">
        <?php if (empty($materiales)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                No hay materiales disponibles para este curso.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Descargar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($materiales as $mat): ?>
                            <tr>
                                <td>
                                    <i class="fas fa-file-alt me-2 text-primary"></i>
                                    <?= esc($mat['titulo']) ?>
                                </td>
                                <td><?= esc($mat['descripcion']) ?></td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($mat['fecha_subida'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <a href="<?= base_url('estudiantes/materiales/descargar/' . $mat['id']) ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download me-1"></i>Descargar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
        </a>
    </div>
</div>
<?= $this->endSection() ?>
