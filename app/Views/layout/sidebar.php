<!-- SIDEBAR -->
<div class="col-md-3 col-lg-2 bg-light border-end p-3 min-vh-100">
    <h6 class="text-uppercase text-muted mb-3">Menú</h6>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="nav-link">
                <i class="fas fa-home me-2"></i>Inicio
            </a>
        </li>

        <?php
        $rol = session('rol_id'); // obtenemos el rol actual del usuario

        switch ($rol) {
            // 🧑‍💼 ADMINISTRADOR
            case 1: ?>
                <li class="nav-item">
                    <a href="<?= base_url('administrativos/estudiantes') ?>" class="nav-link">
                        <i class="fas fa-user-graduate me-2"></i>Estudiantes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('administrativos/docentes') ?>" class="nav-link">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Docentes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('administrativos/administrativos') ?>" class="nav-link">
                        <i class="fas fa-user-tie me-2"></i>Administrativos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('administrativos/cursos') ?>" class="nav-link">
                        <i class="fas fa-book me-2"></i>Cursos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('administrativos/tramites') ?>" class="nav-link">
                        <i class="fas fa-folder-open me-2"></i>Trámites
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('administrativos/notificaciones') ?>" class="nav-link">
                        <i class="fas fa-bell me-2"></i>Notificaciones
                    </a>
                </li>
                <?php break;

            // 🎓 DOCENTE
            case 2: ?>
                <li class="nav-item">
                    <a href="<?= base_url('cursos') ?>" class="nav-link">
                        <i class="fas fa-book-open me-2"></i>Mis Cursos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('calificaciones') ?>" class="nav-link">
                        <i class="fas fa-clipboard-check me-2"></i>Calificaciones
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('notificaciones') ?>" class="nav-link">
                        <i class="fas fa-bell me-2"></i>Notificaciones
                    </a>
                </li>
                <?php break;

            // 👨‍🏫 ESTUDIANTE
            case 3: ?>
                <li class="nav-item">
                    <a href="<?= base_url('estudiantes/matriculas') ?>" class="nav-link">
                        <i class="fas fa-list me-2"></i>Mis Matrículas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('estudiantes/tramites') ?>" class="nav-link">
                        <i class="fas fa-folder-open me-2"></i>Mis Trámites
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('estudiantes/notificaciones') ?>" class="nav-link">
                        <i class="fas fa-bell me-2"></i>Notificaciones
                    </a>
                </li>
                <?php break;


                

            // 🧾 ADMINISTRATIVO
            case 4: ?>
                <li class="nav-item">
                        <a href="<?= base_url('administrativos/tramites') ?>" class="nav-link">
                        <i class="fas fa-tasks me-2"></i>Gestionar Trámites
                    </a>
                </li>
                <li class="nav-item">
                        <a href="<?= base_url('administrativos/notificaciones') ?>" class="nav-link">
                        <i class="fas fa-bell me-2"></i>Notificaciones
                    </a>
                </li>
                <?php break;

            default: ?>
                <li class="nav-item">
                    <span class="text-muted small">Rol no reconocido</span>
                </li>
        <?php } ?>
    </ul>
</div>
