<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<h3 class="mb-3">Calificaciones - <?= esc($curso['nombre']) ?></h3>

<div class="card">
    <div class="card-body">
        <?php if (empty($calificacion)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Aún no hay calificaciones registradas para este curso.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Componente 1</th>
                            <th>Componente 2</th>
                            <th>Componente 3</th>
                            <th>Nota Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?= $calificacion['componente1'] ?? '-' ?></td>
                            <td class="text-center"><?= $calificacion['componente2'] ?? '-' ?></td>
                            <td class="text-center"><?= $calificacion['componente3'] ?? '-' ?></td>
                            <td class="text-center">
                                <strong class="<?= ($calificacion['nota_final'] ?? 0) >= 10.5 ? 'text-success' : 'text-danger' ?>">
                                    <?= $calificacion['nota_final'] ?? '-' ?>
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php if (!empty($calificacion['observaciones'])): ?>
                <div class="alert alert-secondary mt-3">
                    <strong>Observaciones:</strong> <?= esc($calificacion['observaciones']) ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
        </a>
    </div>
</div>
<?= $this->endSection() ?>
