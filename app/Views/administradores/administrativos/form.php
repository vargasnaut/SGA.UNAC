<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>
<div class="container py-4">
  <h3 class="mb-3"><i class="fas fa-user-plus text-success me-2"></i>Nuevo Administrativo</h3>
  <form method="post" action="<?= base_url('administradores/administrativos/guardar') ?>">
    <?= csrf_field() ?>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nombres</label>
        <input type="text" name="nombres" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Apellidos</label>
        <input type="text" name="apellidos" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">DNI</label>
        <input type="text" name="dni" class="form-control" required maxlength="12">
      </div>
      <div class="col-md-4">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">Área</label>
        <input type="text" name="area" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Usuario</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required minlength="6">
      </div>
      <div class="col-12">
        <button class="btn btn-success"><i class="fas fa-save me-1"></i>Guardar</button>
        <a href="<?= base_url('administradores/administrativos') ?>" class="btn btn-secondary">Cancelar</a>
      </div>
    </div>
  </form>
</div>
<?= $this->endSection() ?>