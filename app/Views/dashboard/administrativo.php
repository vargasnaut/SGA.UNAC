
<?= $this->extend('layout/main') ?>

<?= $this->section('contenido') ?>
    <div class="container-fluid py-4">
        <h2 class="mb-4">
            <i class="fas fa-user-tie me-2 text-primary"></i>Panel del Personal Administrativo
        </h2>

        <div class="row g-4">
            <!-- Solicitudes de Matrícula -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                                <i class="fas fa-clipboard-check fa-2x text-danger"></i>
                            </div>
                        </div>
                        <h5 class="card-title">Solicitudes de Matrícula</h5>
                        <p class="card-text text-muted">Revisa y aprueba solicitudes de matrícula de estudiantes.</p>
                        <a href="<?= base_url('administrativos/matriculas/solicitudes') ?>" class="btn btn-danger w-100">
                            <i class="fas fa-arrow-right me-1"></i>Gestionar Solicitudes
                        </a>
                    </div>
                </div>
            </div>

            <!-- Gestión de Trámites -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                        <h5 class="card-title">Gestión de Trámites</h5>
                        <p class="card-text text-muted">Revisa y aprueba solicitudes de trámites estudiantiles.</p>
                        <a href="<?= base_url('administrativos/tramites') ?>" class="btn btn-primary w-100">
                            <i class="fas fa-arrow-right me-1"></i>Ver Trámites
                        </a>
                    </div>
                </div>
            </div>

            <!-- Notificaciones -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="fas fa-bell fa-2x text-success"></i>
                            </div>
                        </div>
                        <h5 class="card-title">Notificaciones</h5>
                        <p class="card-text text-muted">Envía y gestiona notificaciones masivas a usuarios.</p>
                        <a href="<?= base_url('administrativos/notificaciones') ?>" class="btn btn-success w-100">
                            <i class="fas fa-arrow-right me-1"></i>Ver Notificaciones
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mi Perfil -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="fas fa-user fa-2x text-info"></i>
                            </div>
                        </div>
                        <h5 class="card-title">Mi Perfil</h5>
                        <p class="card-text text-muted">Actualiza tu información personal y de contacto.</p>
                        <a href="<?= base_url('administrativos/perfil') ?>" class="btn btn-info w-100">
                            <i class="fas fa-arrow-right me-1"></i>Ver Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Bienvenido al Panel Administrativo
                        </h5>
                        <p class="card-text">
                            Desde este panel puedes gestionar las solicitudes de matrícula, aprobar trámites estudiantiles, 
                            enviar notificaciones masivas y mantener actualizado tu perfil. 
                            Selecciona una de las opciones anteriores para comenzar.
                        </p>
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-lightbulb me-2"></i>
                            <strong>Consejo:</strong> Revisa regularmente las solicitudes pendientes para agilizar los procesos académicos.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>
<?= $this->endSection() ?>
