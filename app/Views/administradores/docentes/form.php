<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>
<div class="container py-4">
  <h3 class="mb-3"><i class="fas fa-plus text-success me-2"></i>Nuevo Docente</h3>
  <form method="post" action="<?= base_url('administradores/docentes/guardar') ?>" class="row g-3">
    <div class="col-md-6"><label class="form-label">Nombres</label><input name="nombres" required class="form-control"></div>
    <div class="col-md-6"><label class="form-label">Apellidos</label><input name="apellidos" required class="form-control"></div>
    <div class="col-md-4"><label class="form-label">DNI</label><input name="dni" required class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Especialidad</label><input name="especialidad" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Teléfono</label><input name="telefono" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Username</label><input name="username" required class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Email</label><input type="email" name="email" required class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Password</label><input type="password" name="password" required class="form-control"></div>
    <div class="col-12"><button class="btn btn-success"><i class="fas fa-save"></i> Guardar</button> <a href="<?= base_url('administradores/docentes') ?>" class="btn btn-secondary">Cancelar</a></div>
  </form>
</div>
<?= $this->endSection() ?>