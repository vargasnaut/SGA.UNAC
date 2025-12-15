<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-list me-2"></i>Mis Matrículas</h2>

    <?php if (!empty($matriculas)) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Curso</th>
                        <th>Periodo</th>
                        <th>Fecha Matrícula</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($matriculas as $key => $m) : ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= esc($m['curso']) ?></td>
                            <td><?= esc($m['periodo']) ?></td>
                            <td><?= esc($m['fecha_matricula']) ?></td>
                            <td>
                                <?php if ($m['estado'] === 'matriculado') : ?>
                                    <span class="badge bg-success">Matriculado</span>
                                <?php elseif ($m['estado'] === 'retirado') : ?>
                                    <span class="badge bg-warning">Retirado</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary"><?= esc($m['estado']) ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="alert alert-info">
            📚 No tienes matrículas registradas actualmente.
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
