<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>
<div class="container py-4">
  <h3 class="mb-3"><i class="fas fa-user-edit text-warning me-2"></i>Editar Administrativo</h3>
  <form method="post" action="<?= base_url('administradores/administrativos/actualizar/'.$administrativo['id']) ?>">
    <?= csrf_field() ?>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nombres</label>
        <input type="text" name="nombres" class="form-control" required value="<?= esc(old('nombres', $administrativo['nombres'] ?? '')) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Apellidos</label>
        <input type="text" name="apellidos" class="form-control" required value="<?= esc(old('apellidos', $administrativo['apellidos'] ?? '')) ?>">
      </div>
      <div class="col-md-4">
        <label class="form-label">DNI</label>
        <input type="text" name="dni" class="form-control" required maxlength="12" value="<?= esc(old('dni', $administrativo['dni'] ?? '')) ?>">
      </div>
      <div class="col-md-4">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control" value="<?= esc(old('telefono', $administrativo['telefono'] ?? '')) ?>">
      </div>
      <div class="col-md-4">
        <label class="form-label">Área</label>
        <select name="area" class="form-select" required>
          <?php
            $areas = ['Secretaría Académica','Tesorería','Registro','Ventanilla Única','Otro'];
            $areaSel = old('area', $administrativo['area'] ?? 'Otro');
            foreach ($areas as $opt) {
              $sel = ($opt === $areaSel) ? 'selected' : '';
              echo '<option value="'.esc($opt).'" '.$sel.'>'.esc($opt).'</option>';
            }
          ?>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required value="<?= esc(old('email', $usuario['email'] ?? '')) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Usuario</label>
        <input type="text" name="username" class="form-control" required value="<?= esc($administrativo['username'] ?? '') ?>" disabled>
        <small class="text-muted">El usuario no se puede cambiar.</small>
      </div>
      <div class="col-12">
        <button class="btn btn-warning"><i class="fas fa-save me-1"></i>Actualizar</button>
        <a href="<?= base_url('administradores/administrativos') ?>" class="btn btn-secondary">Cancelar</a>
      </div>
    </div>
  </form>
</div>
<?= $this->endSection() ?>