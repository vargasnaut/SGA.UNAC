<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
    <h2>Panel del Administrador</h2>

    <div class="card">
        <h3>Gestión de Usuarios</h3>
        <p>Administra cuentas y permisos del sistema.</p>
        <a href="<?= base_url('usuarios') ?>" class="btn">Gestionar Usuarios</a>
    </div>

    <div class="card">
        <h3>Configuración del Sistema</h3>
        <p>Controla parámetros generales y seguridad.</p>
        <a href="<?= base_url('configuracion') ?>" class="btn">Ir a Configuración</a>
    </div>
<?= $this->endSection() ?>
