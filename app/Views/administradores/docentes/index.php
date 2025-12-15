<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>
<div class="container-fluid py-4">
  <h3 class="mb-3"><i class="fas fa-chalkboard-teacher text-success me-2"></i>Docentes</h3>
  <form class="row g-2 mb-3" method="get">
    <div class="col-auto">
      <input type="text" name="q" value="<?= esc($busqueda) ?>" class="form-control" placeholder="Buscar nombre, apellido o DNI">
    </div>
    <div class="col-auto">
      <button class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
      <a href="<?= base_url('administradores/docentes/nuevo') ?>" class="btn btn-success ms-2"><i class="fas fa-plus"></i> Nuevo</a>
    </div>
  </form>
  <?php if(session('success')): ?><div class="alert alert-success"><?= session('success') ?></div><?php endif; ?>
  <?php if(session('error')): ?><div class="alert alert-danger"><?= session('error') ?></div><?php endif; ?>
  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>DNI</th>
          <th>Especialidad</th>
          <th>Teléfono</th>
          <th>Cursos Dicta</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($docentes as $d): ?>
        <tr>
          <td><?= $d['id'] ?></td>
          <td><?= esc($d['nombres'].' '.$d['apellidos']) ?></td>
          <td><?= esc($d['dni']) ?></td>
          <td><?= esc($d['especialidad']) ?></td>
          <td><?= esc($d['telefono']) ?></td>
          <td><span class="badge bg-info"><?= (int)$d['total_cursos'] ?></span></td>
          <td>
            <a href="<?= base_url('administradores/docentes/editar/'.$d['id']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
            <form action="<?= base_url('administradores/docentes/eliminar/'.$d['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar docente?')">
              <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if(empty($docentes)): ?>
        <tr><td colspan="7" class="text-center text-muted">Sin resultados</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
  <nav>
    <ul class="pagination">
      <?php for($i=1;$i<=$totalPaginas;$i++): ?>
        <li class="page-item <?= $i==$pagina?'active':'' ?>">
          <a class="page-link" href="?page=<?= $i ?>&q=<?= urlencode($busqueda) ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
</div>
<?= $this->endSection() ?>