<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>
<div class="container-fluid py-4">
  <h3 class="mb-3"><i class="fas fa-users-cog text-primary me-2"></i>Administrativos</h3>
  <form class="row g-2 mb-3" method="get">
    <div class="col-auto">
      <input type="text" name="q" value="<?= esc($busqueda) ?>" class="form-control" placeholder="Buscar nombre, apellido o DNI">
    </div>
    <div class="col-auto">
      <button class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
      <a href="<?= base_url('administradores/administrativos/nuevo') ?>" class="btn btn-success ms-2"><i class="fas fa-plus"></i> Nuevo</a>
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
          <th>Área</th>
          <th>Teléfono</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($administrativos as $a): ?>
        <tr>
          <td><?= $a['id'] ?></td>
          <td><?= esc($a['nombres'].' '.$a['apellidos']) ?></td>
          <td><?= esc($a['dni']) ?></td>
          <td><?= esc($a['area']) ?></td>
          <td><?= esc($a['telefono']) ?></td>
          <td>
            <a href="<?= base_url('administradores/administrativos/editar/'.$a['id']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
            <form action="<?= base_url('administradores/administrativos/eliminar/'.$a['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar administrativo?')">
              <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if(empty($administrativos)): ?>
        <tr><td colspan="6" class="text-center text-muted">Sin resultados</td></tr>
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