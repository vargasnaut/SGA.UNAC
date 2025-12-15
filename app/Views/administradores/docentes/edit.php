<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>
<div class="container py-4">
  <h3 class="mb-3"><i class="fas fa-edit text-warning me-2"></i>Editar Docente</h3>
  <form method="post" action="<?= base_url('administradores/docentes/actualizar/'.$docente['id']) ?>" class="row g-3">
    <div class="col-md-6"><label class="form-label">Nombres</label><input name="nombres" value="<?= esc($docente['nombres']) ?>" required class="form-control"></div>
    <div class="col-md-6"><label class="form-label">Apellidos</label><input name="apellidos" value="<?= esc($docente['apellidos']) ?>" required class="form-control"></div>
    <div class="col-md-4"><label class="form-label">DNI</label><input name="dni" value="<?= esc($docente['dni']) ?>" required class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Especialidad</label><input name="especialidad" value="<?= esc($docente['especialidad']) ?>" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Teléfono</label><input name="telefono" value="<?= esc($docente['telefono']) ?>" class="form-control"></div>
    <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" value="<?= esc($usuario['email']) ?>" required class="form-control"></div>
    <div class="col-md-6"><label class="form-label">Password (opcional)</label><input type="password" name="password" class="form-control" placeholder="(sin cambiar)"></div>
    <div class="col-12"><button class="btn btn-warning"><i class="fas fa-save"></i> Actualizar</button> <a href="<?= base_url('administradores/docentes') ?>" class="btn btn-secondary">Volver</a></div>
  </form>
</div>
<?= $this->endSection() ?>