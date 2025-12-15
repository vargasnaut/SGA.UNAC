<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Ruta principal - redirige al login
$routes->get('/', 'Auth::index');


# LOGIN
$routes->get('/auth', 'Auth::index');            // Vista de login
$routes->post('auth/login', 'Auth::login');     // Procesa el login
$routes->get('auth/logout', 'Auth::logout');    // Cierra sesión
$routes->get('auth/register', 'Auth::register'); // (opcional)

# PANEL DE USUARIO
$routes->get('dashboard', 'Dashboard::index');
$routes->get('dashboard/docente', 'Dashboard::docente');
$routes->get('dashboard/estudiante', 'Dashboard::estudiante');
$routes->get('dashboard/administrativo', 'Dashboard::administrativo');

# RUTAS ADICIONALES SEGÚN NECESIDADES

// RUTAS PARA ESTUDIANTES
    $routes->get('perfil', 'Estudiantes::perfil');
    $routes->get('estudiantes/perfil', 'Estudiantes::perfil');
    $routes->post('estudiantes/perfil/actualizar', 'Estudiantes::actualizarPerfil');
    $routes->post('estudiantes/perfil/cambiar-password', 'Estudiantes::cambiarPassword');
    $routes->get('cursos', 'Estudiantes::cursos');
    $routes->get('estudiantes/matriculas', 'Estudiantes::matriculas');
    $routes->get('estudiantes/notificaciones', 'Estudiantes::notificaciones');
    $routes->get('estudiantes/notificaciones/marcar-leida/(:num)', 'Estudiantes::marcarNotificacionLeida/$1');
    $routes->get('estudiantes/notificaciones/archivo/(:num)', 'Estudiantes::verArchivoNotificacion/$1');
    $routes->get('estudiantes/tramites', 'Estudiantes::tramites');


    // PAGOS DEL ESTUDIANTE
    $routes->get('estudiantes/pagos', 'Pagos::indexEstudiante');

    $routes->get('estudiantes/pagos/(:num)', 'Pagos::pagosPorTramite/$1');
    $routes->get('estudiantes/pagos/nuevo/(:num)', 'Pagos::nuevo/$1');
    $routes->post('estudiantes/pagos/guardar', 'Pagos::guardar');
    $routes->get('estudiantes/pagos/ver/(:num)', 'Pagos::ver/$1');
    $routes->get('estudiantes/pagos/comprobante/(:num)', 'Pagos::comprobante/$1');



    // Crear
    $routes->get('estudiantes/tramites/crear', 'Estudiantes::crear');
    $routes->post('estudiantes/tramites/guardar', 'Estudiantes::guardar');

    // Ver
    $routes->get('estudiantes/tramites/ver/(:num)', 'Estudiantes::ver/$1');

    // Editar
    $routes->get('estudiantes/tramites/editar/(:num)', 'Estudiantes::editar/$1');
    $routes->post('estudiantes/tramites/actualizar/(:num)', 'Estudiantes::actualizar/$1');

    // Eliminar
    $routes->get('estudiantes/tramites/eliminar/(:num)', 'Estudiantes::eliminar/$1');
    
    // Marcar notificación como leída
    $routes->get('estudiantes/notificaciones/marcarLeida/(:num)', 'Notificaciones::marcarLeida/$1');

    // Ver pdf del trámite
    $routes->get('estudiantes/tramites/ver-documento/(:num)', 'Estudiantes::verDocumento/$1');

    // Mis cursos
    $routes->get('estudiantes/mis-cursos', 'Estudiantes::cursos');

// Enlaces estudiantiles: calificaciones, asistencias, materiales
$routes->get('estudiantes/calificaciones/(:num)', 'Estudiantes::verCalificaciones/$1');
$routes->get('estudiantes/asistencias/(:num)', 'Estudiantes::verAsistencias/$1');
$routes->get('estudiantes/materiales/(:num)', 'Estudiantes::verMateriales/$1');
$routes->get('estudiantes/materiales/descargar/(:num)', 'Estudiantes::descargarMaterial/$1');

//RUTAS PARA ADMINISTRADORES
// Dashboard
$routes->get('administradores/dashboard', 'Administradores::dashboard');
$routes->get('dashboard/admin', 'Administradores::dashboard');

// Gestión de Docentes (CRUD)
$routes->get('administradores/docentes', 'Administradores::listarDocentes');
$routes->get('administradores/docentes/nuevo', 'Administradores::nuevoDocente');
$routes->post('administradores/docentes/guardar', 'Administradores::guardarDocente');
$routes->get('administradores/docentes/editar/(:num)', 'Administradores::editarDocente/$1');
$routes->post('administradores/docentes/actualizar/(:num)', 'Administradores::actualizarDocente/$1');
$routes->post('administradores/docentes/eliminar/(:num)', 'Administradores::eliminarDocente/$1');

// Gestión de Administrativos (CRUD)
$routes->get('administradores/administrativos', 'Administradores::listarAdministrativos');
$routes->get('administradores/administrativos/nuevo', 'Administradores::nuevoAdministrativo');
$routes->post('administradores/administrativos/guardar', 'Administradores::guardarAdministrativo');
$routes->get('administradores/administrativos/editar/(:num)', 'Administradores::editarAdministrativo/$1');
$routes->post('administradores/administrativos/actualizar/(:num)', 'Administradores::actualizarAdministrativo/$1');
$routes->post('administradores/administrativos/eliminar/(:num)', 'Administradores::eliminarAdministrativo/$1');

// Perfil
$routes->get('administradores/perfil', 'Administradores::perfil');
$routes->post('administradores/perfil/actualizar', 'Administradores::actualizarPerfil');
$routes->post('administradores/perfil/cambiar-password', 'Administradores::cambiarPassword');

// Gestión de Solicitudes de Matrícula
$routes->get('administradores/matriculas/solicitudes', 'Administradores::solicitudesMatricula');
$routes->get('administradores/matriculas/ver/(:num)', 'Administradores::verSolicitud/$1');
$routes->get('administradores/matriculas/comprobante/(:num)', 'Administradores::verComprobante/$1');
$routes->post('administradores/matriculas/aprobar/(:num)', 'Administradores::aprobarSolicitud/$1');
$routes->post('administradores/matriculas/rechazar/(:num)', 'Administradores::rechazarSolicitud/$1');

// Reportes
$routes->get('administradores/reportes/matriculas', 'Administradores::reporteMatriculas');
  

// RUTAS DE ADMISTRATIVO

// Perfil del administrativo
$routes->get('administrativos/perfil', 'Administrativos::perfil');
$routes->post('administrativos/perfil/actualizar', 'Administrativos::actualizarPerfil');
$routes->post('administrativos/perfil/cambiar-password', 'Administrativos::cambiarPassword');

// Notificaciones
$routes->get('administrativos/notificaciones', 'Administrativos::notificaciones');
$routes->post('administrativos/notificaciones/crear', 'Administrativos::crearNotificacion');
$routes->get('administrativos/notificaciones/eliminar/(:num)', 'Administrativos::eliminarNotificacion/$1');
$routes->get('administrativos/notificaciones/archivo/(:num)', 'Administrativos::verArchivo/$1');

// Lista de trámites
$routes->get('administrativos/tramites', 'Administrativos::tramites');
// Ver detalle
$routes->get('administrativos/tramites/ver/(:num)', 'Administrativos::ver/$1');

// Formulario para cambiar estado
$routes->get('/administrativos/tramites/estado/(:num)', 'Administrativos::editarEstado/$1');

// Procesar cambio de estado
$routes->post('/administrativos/tramites/actualizarEstado/(:num)', 'Administrativos::actualizarEstado/$1');

// Procesar actualización de trámite con auto-generación de código y correo
$routes->post('administrativos/tramites/actualizar/(:num)', 'Administrativos::actualizar/$1');

// Ver pdf del trámite 
$routes->get('administrativos/tramites/ver-Pdf/(:num)', 'Administrativos::verPdf/$1');

// ========== RUTAS DE MATRÍCULA - ESTUDIANTES ==========
$routes->get('estudiantes/matricula/solicitar', 'Estudiantes::solicitarMatricula');
$routes->post('estudiantes/matricula/solicitar', 'Estudiantes::solicitarMatricula');
$routes->get('estudiantes/matricula/seleccionar', 'Estudiantes::seleccionarCursosMatricula');
$routes->get('estudiantes/matricula/cursos', 'Estudiantes::cursosDisponibles');
$routes->post('estudiantes/matricula/guardar-cursos', 'Estudiantes::guardarMatricula');
$routes->get('estudiantes/matricula/matricular/(:num)', 'Estudiantes::matricularCurso/$1');
$routes->get('estudiantes/matricula/horario', 'Estudiantes::horario');
$routes->get('estudiantes/matricula/cupos/(:num)', 'Estudiantes::cuposCurso/$1');

// ========== HISTORIAL ACADÉMICO ==========
$routes->get('estudiantes/historial', 'Estudiantes::historialAcademico');

// ========== RUTAS DE MATRÍCULA - ADMINISTRATIVOS ==========
$routes->get('administrativos/matriculas/solicitudes', 'Administrativos::solicitudesMatricula');
$routes->get('administrativos/matriculas/ver/(:num)', 'Administrativos::verSolicitudMatricula/$1');
$routes->get('administrativos/matriculas/comprobante/(:num)', 'Administrativos::verComprobante/$1');
$routes->post('administrativos/matriculas/actualizar/(:num)', 'Administrativos::aprobarRechazarMatricula/$1');

// ========== ESTUDIANTES POR CICLO ==========
$routes->get('administrativos/estudiantes/por-ciclo', 'Administrativos::estudiantesPorCiclo');


// RUTAS DE DOCENTE
$routes->get('docentes/cursos', 'Docentes::cursos');
$routes->get('docentes/perfil', 'Docentes::perfil');
$routes->post('docentes/perfil/actualizar', 'Docentes::actualizarPerfil');
$routes->post('docentes/perfil/cambiar-password', 'Docentes::cambiarPassword');
$routes->get('docentes/notificaciones', 'Docentes::notificaciones');
$routes->get('docentes/notificaciones/marcar-leida/(:num)', 'Docentes::marcarNotificacionLeida/$1');
$routes->get('docentes/notificaciones/archivo/(:num)', 'Docentes::verArchivoNotificacion/$1');

// RUTAS DE FACULTADES - FIIS
$routes->get('docentes/facultad/fiis', 'Docentes::facultadFiis');
// Área personal FIIS y Sistemas
$routes->get('docentes/facultad/fiis/personal', 'Docentes::fiisPersonal');
$routes->get('docentes/facultad/fiis/sistemas/cursos', 'Docentes::fiisSistemasCursos');
$routes->get('docentes/facultad/fiis/sistemas/estudiantes/(:num)', 'Docentes::fiisSistemasEstudiantes/$1');
$routes->match(['get','post'], 'docentes/facultad/fiis/sistemas/materiales/(:num)', 'Docentes::fiisSistemasMateriales/$1');
$routes->match(['get','post'], 'docentes/facultad/fiis/sistemas/calificaciones/(:num)', 'Docentes::fiisSistemasCalificaciones/$1');
$routes->match(['get','post'], 'docentes/facultad/fiis/sistemas/asistencia/(:num)', 'Docentes::fiisSistemasAsistencia/$1');
$routes->get('docentes/materiales/descargar/(:num)', 'Docentes::descargarMaterial/$1');
$routes->get('docentes/materiales/eliminar/(:num)', 'Docentes::eliminarMaterial/$1');

// ========== RUTAS SIMPLIFICADAS PARA GUARDADO DIRECTO ==========
// Estas rutas usan el controlador DocentesSimple que tiene lógica directa sin complejidad
$routes->post('docentes-simple/guardar-material/(:num)', 'DocentesSimple::guardarMaterial/$1');
$routes->post('docentes-simple/guardar-calificaciones/(:num)', 'DocentesSimple::guardarCalificaciones/$1');
$routes->post('docentes-simple/guardar-asistencias/(:num)', 'DocentesSimple::guardarAsistencias/$1');


// ========== RUTAS DIRECTAS (SIN VALIDACIONES) ==========
$routes->post('docente-direct/material/(:num)', 'DocentesDirect::material/$1');
$routes->post('docente-direct/calificaciones/(:num)', 'DocentesDirect::calificaciones/$1');
$routes->post('docente-direct/asistencias/(:num)', 'DocentesDirect::asistencias/$1');

