<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>

<h3 class="mb-3">Gestión de Trámites</h3>

<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Estudiante</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Fecha Solicitud</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($tramites as $t): ?>
        <tr>
            <td><?= $t['id'] ?></td>
            <td><?= $t['est_nombres'].' '.$t['est_apellidos'] ?></td>
            <td><?= $t['tipo'] ?></td>

            <td><?php
                $estado = $t['estado'];
                $badgeClass = match ($estado) {
                    'pendiente'   => 'warning',
                    'en proceso'  => 'info',
                    'aprobado'    => 'success',
                    'rechazado'   => 'danger',
                    default       => 'secondary'
                };?>
            
            <span class="badge bg-<?= $badgeClass ?>">
                <?= ucfirst($estado) ?>
            </span></td>


            <td><?= date('d-m-Y', strtotime($t['fecha_solicitud'])) ?></td>

            <td>
                <a href="<?= base_url('administrativos/tramites/ver/'.$t['id']) ?>" class="btn btn-sm btn-info">
                    Ver
                </a>
                <a href="<?= base_url('administrativos/tramites/estado/'.$t['id']) ?>" class="btn btn-sm btn-warning">
                    Cambiar Estado
                </a>
            </td>
        </tr>
        <?php endforeach; ?>

    </tbody>
</table>

<?= $this->endSection() ?>
