<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>

<h3 class="mb-3">Mis Trámites</h3>

<!-- Botón para crear nuevo trámite -->
<a href="<?= base_url('/estudiantes/tramites/crear') ?>" class="btn btn-primary mb-3">
    <i class="fas fa-plus me-1"></i> Solicitar Trámite
</a>

<?php if (!empty($tramites)) : ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-info">
                <tr>
                    <th>#</th>
                    <th>Tipo</th>
                    <th>Motivo</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tramites as $t) : ?>
                    <tr>
                        <td><?= esc($t['id']) ?></td>
                        <td><?= esc($t['tipo']) ?></td>
                        <td><?= esc(strlen($t['motivo'] ?? '') > 10 
                                ? substr($t['motivo'], 0, 10) . '...' 
                                : ($t['motivo'] ?? '-')) ?></td>
                        <td><?= esc(strlen($t['descripcion'] ?? '') > 10 
                                ? substr($t['descripcion'], 0, 10) . '...' 
                                : ($t['descripcion'] ?? '-')) ?></td>
                        <td>
                            <?php
                                $color = [
                                    'pendiente' => 'warning',
                                    'en proceso' => 'info',
                                    'aprobado' => 'success',
                                    'rechazado' => 'danger'
                                ];
                                $badge = $color[$t['estado']] ?? 'secondary';
                            ?>
                            <span class="badge bg-<?= $badge ?>"><?= esc(ucfirst($t['estado'])) ?></span>
                        </td>
                        <td><?= $t['fecha_solicitud'] ? date('d-m-Y', strtotime($t['fecha_solicitud'])) : '-' ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('estudiantes/tramites/ver/' . $t['id']) ?>" class="btn btn-info btn-sm me-1"><i class="fas fa-eye"></i></a>
                            <a href="<?= base_url('estudiantes/tramites/editar/' . $t['id']) ?>" class="btn btn-warning btn-sm me-1"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('estudiantes/tramites/eliminar/' . $t['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este trámite?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>

    <p class="text-muted">No has solicitado trámites aún.</p>

<?php endif; ?>

<?= $this->endSection() ?>
