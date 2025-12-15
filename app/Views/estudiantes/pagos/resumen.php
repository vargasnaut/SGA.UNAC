<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>

<h3 class="mb-3">Mis Pagos</h3>

<?php if (!empty($tramites)) : ?>
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Trámite</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th class="text-center">Pagos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tramites as $t) : ?>
                <tr>
                    <td><?= esc($t['id']) ?></td>
                    <td><?= esc($t['tipo']) ?></td>
                    <td>
                        <span class="badge bg-<?= $t['estado'] == 'pendiente' ? 'warning' : 'success' ?>">
                            <?= ucfirst($t['estado']) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($t['fecha_solicitud'])) ?></td>
                    <td class="text-center">
                        <a href="<?= base_url('estudiantes/pagos/' . $t['id']) ?>"
                           class="btn btn-sm btn-info">
                           <i class="fas fa-eye"></i> Ver Pagos
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else : ?>
    <p class="text-muted">No tienes trámites registrados.</p>
<?php endif; ?>

<?= $this->endSection() ?>
