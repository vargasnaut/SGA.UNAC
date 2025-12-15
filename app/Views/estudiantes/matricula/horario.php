<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<h3 class="mb-3 d-flex align-items-center justify-content-between">
  <span><i class="fas fa-calendar-week me-2"></i>Mi Horario - <?= esc($periodo['nombre']) ?></span>
  <a href="<?= base_url('estudiantes/matricula/cursos') ?>" class="btn btn-outline-secondary btn-sm">
    <i class="fas fa-arrow-left me-1"></i> Volver a cursos
  </a>
</h3>

<div class="alert alert-info">
  <i class="fas fa-info-circle me-2"></i>
  Vista de tus cursos matriculados y sus horarios por día.
</div>

<div class="row">
  <?php 
    $dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    foreach ($dias as $dia): 
      $items = $horario[$dia] ?? [];
  ?>
    <div class="col-md-6 mb-3">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <strong><?= $dia ?></strong>
        </div>
        <div class="card-body p-0">
          <?php if (empty($items)): ?>
            <div class="p-3 text-muted">Sin clases este día.</div>
          <?php else: ?>
            <div class="list-group list-group-flush">
              <?php foreach ($items as $clase): ?>
                <div class="list-group-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="fw-bold">
                        <?= esc($clase['curso'] ?? ($clase['codigo_curso'] ?? 'Curso')) ?>
                        <?php if (!empty($clase['grupo'])): ?>
                          <span class="badge bg-secondary ms-1">Grupo <?= esc($clase['grupo']) ?></span>
                        <?php endif; ?>
                      </div>
                      <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        <?= esc(substr($clase['hora_inicio'] ?? '-',0,5)) ?> - <?= esc(substr($clase['hora_fin'] ?? '-',0,5)) ?>
                        <?php if (!empty($clase['aula_id'])): ?>
                          · <i class="fas fa-door-open me-1"></i> Aula <?= esc($clase['aula_id']) ?>
                        <?php endif; ?>
                      </small>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?= $this->endSection() ?>
