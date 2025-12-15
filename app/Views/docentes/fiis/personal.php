<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="mb-0">FIIS - Área Personal</h2>
    <small class="text-muted">Seleccione su Escuela Profesional</small>
  </div>
</div>

<div class="row">
  <div class="col-md-6 mb-4">
    <div class="card border-primary h-100">
      <div class="card-body">
        <h5 class="card-title"><i class="fas fa-code me-2"></i>Escuela Profesional de Ingeniería de Sistemas</h5>
        <p class="text-muted">Gestione cursos, estudiantes, materiales, calificaciones y asistencias.</p>
        <a href="<?= base_url('docentes/facultad/fiis/sistemas/cursos') ?>" class="btn btn-primary">
          <i class="fas fa-arrow-right me-1"></i> Entrar
        </a>
      </div>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title"><i class="fas fa-industry me-2"></i>Escuela Profesional de Ingeniería Industrial</h5>
        <p class="text-muted mb-2">Próximamente.</p>
        <button class="btn btn-outline-secondary" disabled><i class="fas fa-lock me-1"></i> No disponible</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
