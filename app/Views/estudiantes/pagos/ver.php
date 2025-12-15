<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>

<h4 class="mb-4">
    Detalle del Pago #<?= esc($pago['id']) ?>
</h4>

<table class="table table-bordered">
    <tr>
        <th>Monto</th>
        <td>S/ <?= number_format($pago['monto'], 2) ?></td>
    </tr>
    <tr>
        <th>Método de Pago</th>
        <td><?= esc($pago['metodo_pago']) ?></td>
    </tr>
    <tr>
        <th>Fecha de Pago</th>
        <td><?= date('d-m-Y', strtotime($pago['fecha_pago'])) ?></td>
    </tr>
    <tr>
        <th>Estado</th>
        <td>
            <span class="badge bg-<?= $pago['estado'] === 'pagado' ? 'success' : 'danger' ?>">
                <?= esc($pago['estado']) ?>
            </span>
        </td>
    </tr>
</table>

<a href="<?= base_url('estudiantes/pagos/' . $pago['tramite_id']) ?>"
   class="btn btn-secondary">
    Volver a Pagos
</a>

<?= $this->endSection() ?>
