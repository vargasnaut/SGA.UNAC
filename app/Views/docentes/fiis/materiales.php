<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<h3 class="mb-3">Materiales - <?= esc($curso['nombre']) ?></h3>

<?php if (session('success')): ?><div class="alert alert-success"><?= session('success') ?></div><?php endif; ?>
<?php if (session('error')): ?><div class="alert alert-danger"><?= session('error') ?></div><?php endif; ?>

<div class="card mb-4">
  <div class="card-body">
    <form method="post" action="<?= base_url('docente-direct/material/' . $curso['id']) ?>" enctype="multipart/form-data">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Título</label>
          <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="col-md-5">
          <label class="form-label">Descripción</label>
          <input type="text" name="descripcion" class="form-control">
        </div>
        <div class="col-md-3">
          <label class="form-label">Archivo</label>
          <input type="file" name="archivo" class="form-control" required>
        </div>
      </div>
      <div class="mt-3">
        <button type="submit" class="btn btn-success"><i class="fas fa-upload me-1"></i> Subir</button>
        <a href="<?= base_url('docentes/facultad/fiis/sistemas/cursos') ?>" class="btn btn-secondary">Volver</a>
      </div>
    </form>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>Título</th>
        <th>Descripción</th>
        <th>Fecha</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($materiales)): ?>
        <tr><td colspan="4" class="text-center text-muted">No hay materiales aún.</td></tr>
      <?php else: foreach ($materiales as $mat): ?>
        <tr>
          <td><?= esc($mat['titulo']) ?></td>
          <td><?= esc($mat['descripcion']) ?></td>
          <td><?= date('d/m/Y H:i', strtotime($mat['fecha_subida'])) ?></td>
          <td>
            <a href="<?= base_url('docentes/materiales/descargar/'.$mat['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-download"></i></a>
            <a href="<?= base_url('docentes/materiales/eliminar/'.$mat['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar material?')"><i class="fas fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>
<?= $this->endSection() ?>


