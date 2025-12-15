<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>
<div class="container">
  <h3 class="mb-3"><i class="fas fa-list me-2"></i>Seleccionar Cursos</h3>
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <form action="<?= base_url('estudiantes/matricula/guardar-cursos') ?>" method="post">
    <?= csrf_field() ?>
    <div class="card">
      <div class="card-body">
        <p class="text-muted">Seleccione los cursos disponibles. El sistema valida prerrequisitos, cupos y horarios.</p>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th></th>
                <th>Código</th>
                <th>Curso</th>
                <th>Ciclo</th>
                <th>Créditos</th>
                <th>Docente</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach (($cursos ?? []) as $c): ?>
                <tr>
                  <td>
                    <?php if (($c['estado'] ?? '') === 'disponible'): ?>
                      <input type="checkbox" name="cursos[]" value="<?= esc($c['id']) ?>" />
                    <?php else: ?>
                      <i class="fas fa-ban text-muted" title="No disponible"></i>
                    <?php endif; ?>
                  </td>
                  <td><strong><?= esc($c['codigo_curso'] ?? '') ?></strong></td>
                  <td><?= esc($c['nombre'] ?? '') ?></td>
                  <td><?= esc($c['ciclo'] ?? '') ?></td>
                  <td><?= esc($c['creditos'] ?? '') ?></td>
                  <td><?= esc(($c['docente_nombres'] ?? '') . ' ' . ($c['docente_apellidos'] ?? '')) ?></td>
                  <td>
                    <span class="badge bg-<?= ($c['estado']==='disponible'?'success':(($c['estado']==='matriculado'?'primary':($c['estado']==='lleno'?'danger':($c['estado']==='conflicto'?'warning':'secondary'))))) ?>"><?= esc(ucfirst($c['estado'] ?? 'indef')) ?></span>
                    <?php if (!empty($c['motivo'])): ?>
                      <small class="text-muted d-block"><?= esc($c['motivo']) ?></small>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-check me-1"></i> Matricular cursos seleccionados</button>
      </div>
    </div>
  </form>
</div>
<?= $this->endSection() ?>
