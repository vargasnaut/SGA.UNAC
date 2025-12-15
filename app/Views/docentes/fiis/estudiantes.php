<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<h3 class="mb-3">Estudiantes Matriculados - <?= esc($curso['nombre']) ?></h3>
<?php if (empty($matriculados)): ?>
  <div class="alert alert-info">No hay estudiantes matriculados.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th>Código</th>
          <th>Estudiante</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($matriculados as $m): ?>
          <tr>
            <td><?= esc($m['codigo_estudiante']) ?></td>
            <td><?= esc($m['estudiante_nombres'].' '.$m['estudiante_apellidos']) ?></td>
            <td><span class="badge bg-primary">Matriculado</span></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
<a href="<?= base_url('docentes/facultad/fiis/sistemas/cursos') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Volver</a>
<?= $this->endSection() ?>
