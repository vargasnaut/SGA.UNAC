<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>

<h4 class="mb-3">
    Pagos del Trámite #<?= esc($tramite['id']) ?>
</h4>

<div class="mb-3">
    <strong>Tipo:</strong> <?= esc($tramite['tipo']) ?><br>
    <strong>Estado del trámite:</strong>
    <span class="badge bg-info"><?= esc($tramite['estado']) ?></span>
</div>

<a href="<?= base_url('estudiantes/pagos/nuevo/' . $tramite['id']) ?>"
   class="btn btn-success mb-3">
    <i class="fas fa-money-bill-wave"></i> Registrar Pago
</a>

<?php if (!empty($pagos)) : ?>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-secondary">
                <tr>
                    <th>#</th>
                    <th>Monto</th>
                    <th>Método</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pagos as $p) : ?>
                    <tr>
                        <td><?= esc($p['id']) ?></td>
                        <td>S/ <?= number_format($p['monto'], 2) ?></td>
                        <td><?= esc($p['metodo_pago']) ?></td>
                        <td><?= date('d-m-Y', strtotime($p['fecha_pago'])) ?></td>
                        <td>
                            <span class="badge bg-<?= $p['estado'] === 'pagado' ? 'success' : 'danger' ?>">
                                <?= esc($p['estado']) ?>
                            </span>
                        </td>

                        <td class="text-center">
                        <a href="<?= base_url('estudiantes/pagos/ver/' . $p['id']) ?>"
                            class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="<?= base_url('estudiantes/pagos/comprobante/' . $p['id']) ?>"
                            class="btn btn-sm btn-success"
                            title="Ver comprobante">
                            <i class="fas fa-file-pdf"></i>
                        </a>

                        </td>

                        

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <strong>Total Pagado:</strong>
        <span class="text-success">S/ <?= number_format($total ?? 0, 2) ?></span>
    </div>
<?php else : ?>
    <div class="alert alert-warning">
        No se han registrado pagos para este trámite.
    </div>
<?php endif; ?>

<a href="<?= base_url('estudiantes/pagos') ?>" class="btn btn-secondary mt-3">
    Volver
</a>

<?= $this->endSection() ?>
