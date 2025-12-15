<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<h3 class="mb-3">Mis Cursos - FIIS (Sistemas)</h3>
<?php if (empty($cursos)): ?>
  <div class="alert alert-info">No tiene cursos asignados en Ingeniería de Sistemas.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Curso</th>
          <th>Carrera</th>
          <th>Créditos</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cursos as $c): ?>
          <tr>
            <td><?= esc($c['nombre']) ?></td>
            <td><?= esc($c['carrera_nombre']) ?></td>
            <td><?= esc($c['creditos']) ?></td>
            <td>
              <a class="btn btn-sm btn-outline-primary" href="<?= base_url('docentes/facultad/fiis/sistemas/estudiantes/'.$c['id']) ?>"><i class="fas fa-users me-1"></i> Estudiantes</a>
              <a class="btn btn-sm btn-outline-success" href="<?= base_url('docentes/facultad/fiis/sistemas/materiales/'.$c['id']) ?>"><i class="fas fa-file-upload me-1"></i> Materiales</a>
              <a class="btn btn-sm btn-outline-warning" href="<?= base_url('docentes/facultad/fiis/sistemas/calificaciones/'.$c['id']) ?>"><i class="fas fa-clipboard-check me-1"></i> Calificaciones</a>
              <a class="btn btn-sm btn-outline-dark" href="<?= base_url('docentes/facultad/fiis/sistemas/asistencia/'.$c['id']) ?>"><i class="fas fa-user-check me-1"></i> Asistencia</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
<?= $this->endSection() ?>
