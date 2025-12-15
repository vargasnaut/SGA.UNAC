<?php

namespace App\Controllers;

use App\Models\TramiteModel;
use App\Models\AdministrativoModel;
use App\Models\NotificacionModel;
use App\Models\EstudianteModel;
use App\Models\DocenteModel;
use App\Models\UsuarioModel;
use App\Models\SolicitudMatriculaModel;
use App\Models\PeriodoAcademicoModel;

class Administrativos extends BaseController
{
    protected $tramiteModel;
    protected $adminModel;
    protected $notificacionModel;
    protected $estudianteModel;
    protected $docenteModel;
    protected $usuarioModel;
    protected $solicitudMatriculaModel;
    protected $periodoModel;

    public function __construct()
    {
        $this->tramiteModel      = new TramiteModel();
        $this->adminModel        = new AdministrativoModel();
        $this->notificacionModel = new NotificacionModel();
        $this->estudianteModel = new EstudianteModel();
        $this->docenteModel = new DocenteModel();
        $this->usuarioModel = new UsuarioModel();
        $this->solicitudMatriculaModel = new SolicitudMatriculaModel();
        $this->periodoModel = new PeriodoAcademicoModel();
    }


    public function perfil()
    {
        $usuarioId = session('id_usuario');

        $administrativo = $this->adminModel->getByUsuarioId($usuarioId);

        return view('administrativos/perfil', [
            'administrativo' => $administrativo
        ]);
    }

    // -------------------------
    // LISTA DE TRÁMITES
    // -------------------------
    public function tramites()
    {
        $data['tramites'] = $this->tramiteModel->obtenerTramitesConEstudiante();

        return view('administrativos/tramites/lista', $data);
    }



    // -------------------------
    // DETALLE DEL TRÁMITE
    // -------------------------
    
    // Ejemplo para ver()
    public function ver($id)
    {
        $tramite = $this->tramiteModel->obtenerTramiteConEstudiantePorId($id);

        if (!$tramite) {
            return redirect()->back()->with('error','Trámite no encontrado.');
        }

        return view('administrativos/tramites/ver', ['tramite' => $tramite]);
    }

    // Ejemplo para editarEstado()
        public function editarEstado($id)
        {
            $tramite = $this->tramiteModel->obtenerTramiteConEstudiantePorId($id);

            if (!$tramite) {
                return redirect()->back()->with('error', 'Trámite no válido.');
            }

            return view('administrativos/tramites/estado', ['tramite' => $tramite]);
        }




    // ACTUALIZAR ESTADO DEL TRÁMITE

        public function actualizarEstado($id)
    {
        $tramite = $this->tramiteModel->find($id);

        if (!$tramite) {
            return redirect()->to('/administrativos/tramites')->with('error', 'Trámite no encontrado.');
        }

        $nuevoEstado = $this->request->getPost('estado');

        // ---------------------------------------------------
        // 1️⃣ OBTENER EL ADMINISTRATIVO QUE ESTÁ LOGUEADO
        // ---------------------------------------------------
        $usuarioLogeado = session()->get('id_usuario'); // ID del usuario

        // Buscar al administrativo por usuario_id
        $admin = $this->adminModel
            ->where('usuario_id', $usuarioLogeado)
            ->first();

        $administrativoId = $admin ? $admin['id'] : null;

        // ---------------------------------------------------
        // 2️⃣ ACTUALIZAR TRÁMITE (estado + administrativo_id)
        // ---------------------------------------------------
                
        $this->tramiteModel->update($id, [
            'estado'            => $nuevoEstado,
            'administrativo_id' => $administrativoId
        ]);

        // ---------------------------------------------------
        // 3️⃣ ENVIAR NOTIFICACIÓN AL ESTUDIANTE
        // ---------------------------------------------------
        $estudiante = $this->estudianteModel->find($tramite['estudiante_id']);
        $usuarioDestino = $estudiante['usuario_id'];

        $this->notificacionModel->insert([
            'usuario_id' => $usuarioDestino,
            'titulo'     => 'Actualización de Trámite',
            'mensaje'    => 'Tu trámite "' . $tramite['tipo'] . '" ha sido actualizado a: ' . $nuevoEstado,
            'tipo'       => 'tramite',
            'fecha_envio'=> date('Y-m-d H:i:s'),
            'leido'      => 0
        ]);

        return redirect()->to('/administrativos/tramites')->with('success', 'Estado actualizado correctamente.');
    }

    // -------------------------
    // ACTUALIZAR TRÁMITE (NUEVO MÉTODO SIMPLIFICADO)
    // -------------------------
    public function actualizar($id)
    {
        $tramite = $this->tramiteModel->find($id);

        if (!$tramite) {
            return redirect()->to('/administrativos/tramites')->with('error', 'Trámite no encontrado.');
        }

        $nuevoEstado = $this->request->getPost('estado');
        $observaciones = $this->request->getPost('observaciones');

        // Obtener administrativo logueado
        $usuarioLogeado = session()->get('id_usuario');
        $admin = $this->adminModel->where('usuario_id', $usuarioLogeado)->first();
        $administrativoId = $admin ? $admin['id'] : null;

        // Actualizar estado del trámite
        $this->tramiteModel->update($id, [
            'estado'            => $nuevoEstado,
            'administrativo_id' => $administrativoId
        ]);

        // Si es APROBADO, generar código y correo institucional automáticamente
        if ($nuevoEstado === 'aprobado') {
            $estudiante = $this->estudianteModel->find($tramite['estudiante_id']);
            
            if ($estudiante) {
                $datosActualizar = [];

                // Generar código institucional si no existe
                if (empty($estudiante['codigo_estudiante']) || $estudiante['codigo_estudiante'] === 'PENDIENTE') {
                    $anio = date('Y');
                    $ultimoCodigo = $this->estudianteModel
                        ->select('codigo_estudiante')
                        ->where('codigo_estudiante LIKE', $anio . '%')
                        ->orderBy('codigo_estudiante', 'DESC')
                        ->first();
                    
                    if ($ultimoCodigo) {
                        $numero = intval(substr($ultimoCodigo['codigo_estudiante'], 4)) + 1;
                    } else {
                        $numero = 1001;
                    }
                    
                    $datosActualizar['codigo_estudiante'] = $anio . str_pad($numero, 4, '0', STR_PAD_LEFT);
                }

                // Generar correo institucional si no existe
                $usuario = $this->usuarioModel->find($estudiante['usuario_id']);
                if ($usuario && (empty($usuario['email']) || strpos($usuario['email'], '@unac.edu.pe') === false)) {
                    $nombres = strtolower($estudiante['nombres']);
                    $apellidos = strtolower($estudiante['apellidos']);
                    $inicial = substr($nombres, 0, 1);
                    $primerApellido = explode(' ', $apellidos)[0];
                    
                    $correoBase = $inicial . $primerApellido;
                    $correoBase = $this->limpiarTexto($correoBase);
                    
                    // Verificar si el correo ya existe
                    $contador = 1;
                    $correoFinal = $correoBase . '@unac.edu.pe';
                    
                    while ($this->usuarioModel->where('email', $correoFinal)->first()) {
                        $correoFinal = $correoBase . $contador . '@unac.edu.pe';
                        $contador++;
                    }
                    
                    $this->usuarioModel->update($usuario['id'], ['email' => $correoFinal]);
                }

                // Actualizar estudiante si hay datos
                if (!empty($datosActualizar)) {
                    $this->estudianteModel->update($estudiante['id'], $datosActualizar);
                }
            }
        }

        // Enviar notificación al estudiante
        $estudiante = $this->estudianteModel->find($tramite['estudiante_id']);
        $usuarioDestino = $estudiante['usuario_id'];

        $mensajeNotif = 'Tu trámite "' . $tramite['tipo'] . '" ha sido ' . $nuevoEstado . '.';
        if (!empty($observaciones)) {
            $mensajeNotif .= "\n\nObservaciones: " . $observaciones;
        }
        if ($nuevoEstado === 'aprobado' && isset($datosActualizar['codigo_estudiante'])) {
            $mensajeNotif .= "\n\n✅ Tu código institucional es: " . $datosActualizar['codigo_estudiante'];
        }

        $this->notificacionModel->insert([
            'usuario_id'  => $usuarioDestino,
            'titulo'      => 'Actualización de Trámite',
            'mensaje'     => $mensajeNotif,
            'tipo'        => 'tramite',
            'fecha_envio' => date('Y-m-d H:i:s'),
            'leido'       => 0
        ]);

        return redirect()->to('/administrativos/tramites')->with('success', 'Trámite actualizado correctamente.');
    }

    // Función auxiliar para limpiar texto (sin acentos ni caracteres especiales)
    private function limpiarTexto($texto)
    {
        $texto = strtolower($texto);
        $texto = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ', ' '],
            ['a', 'e', 'i', 'o', 'u', 'n', ''],
            $texto
        );
        return preg_replace('/[^a-z0-9]/', '', $texto);
    }


    // Ver PDF del Trámite del Administrativo
    public function verPdf($id)
    {
        $tramite = $this->tramiteModel->find($id);

        if (!$tramite) {
            return redirect()->back()->with('error', 'Trámite no encontrado.');
        }

        // Validar que exista el documento
        $ruta = WRITEPATH . '../public/uploads/tramites/' . $tramite['documento'];

        if (!file_exists($ruta)) {
            return redirect()->back()->with('error', 'El archivo no existe.');
        }

        // Forzar visualización del PDF o imagen
        return $this->response
                    ->setHeader('Content-Type', 'application/pdf')
                    ->setHeader('Content-Disposition', 'inline; filename="' . $tramite['documento'] . '"')
                    ->setBody(file_get_contents($ruta));
    }

    // -------------------------
    // NOTIFICACIONES
    // -------------------------
    public function notificaciones()
    {
        $data['notificaciones'] = $this->notificacionModel->orderBy('fecha_envio', 'DESC')->findAll();
        return view('administrativos/notificaciones', $data);
    }

    // Crear notificación masiva
    public function crearNotificacion()
    {
        $titulo = $this->request->getPost('titulo');
        $mensaje = $this->request->getPost('mensaje');
        $destinatarios = $this->request->getPost('destinatarios'); // 'todos', 'estudiantes', 'docentes'

        if (!$titulo || !$mensaje || !$destinatarios) {
            return redirect()->back()->with('error', 'Todos los campos son obligatorios.');
        }

        // Manejo del archivo adjunto (imagen o PDF)
        $nombreArchivo = null;
        $archivo = $this->request->getFile('archivo');
        
        if ($archivo && $archivo->isValid() && !$archivo->hasMoved()) {
            // Validar tipo de archivo
            $tipoPermitido = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'application/pdf'];
            if (!in_array($archivo->getMimeType(), $tipoPermitido)) {
                return redirect()->back()->with('error', 'Solo se permiten imágenes (JPG, PNG, GIF) o archivos PDF.');
            }

            // Validar tamaño (máximo 5MB)
            if ($archivo->getSize() > 5242880) {
                return redirect()->back()->with('error', 'El archivo no debe superar los 5MB.');
            }

            // Generar nombre único y mover archivo
            $nombreArchivo = $archivo->getRandomName();
            $archivo->move(WRITEPATH . '../public/uploads/notificaciones', $nombreArchivo);
        }

        // Obtener los usuarios destinatarios según la selección
        $usuariosDestino = [];

        if ($destinatarios === 'todos' || $destinatarios === 'estudiantes') {
            $estudiantes = $this->estudianteModel->findAll();
            foreach ($estudiantes as $estudiante) {
                if ($estudiante['usuario_id']) {
                    $usuariosDestino[] = $estudiante['usuario_id'];
                }
            }
        }

        if ($destinatarios === 'todos' || $destinatarios === 'docentes') {
            $docentes = $this->docenteModel->findAll();
            foreach ($docentes as $docente) {
                if ($docente['usuario_id']) {
                    $usuariosDestino[] = $docente['usuario_id'];
                }
            }
        }

        // Insertar notificación para cada destinatario
        $contador = 0;
        foreach (array_unique($usuariosDestino) as $usuarioId) {
            $this->notificacionModel->insert([
                'usuario_id' => $usuarioId,
                'titulo' => $titulo,
                'mensaje' => $mensaje,
                'tipo' => 'general',
                'fecha_envio' => date('Y-m-d H:i:s'),
                'leido' => 0,
                'archivo' => $nombreArchivo
            ]);
            $contador++;
        }

        return redirect()->to('/administrativos/notificaciones')
            ->with('success', "Notificación enviada a {$contador} usuarios correctamente.");
    }

    // Eliminar notificación
    public function eliminarNotificacion($id)
    {
        // Obtener notificación para eliminar archivo si existe
        $notificacion = $this->notificacionModel->find($id);
        if ($notificacion && $notificacion['archivo']) {
            $rutaArchivo = WRITEPATH . '../public/uploads/notificaciones/' . $notificacion['archivo'];
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }
        }
        
        $this->notificacionModel->delete($id);
        return redirect()->back()->with('success', 'Notificación eliminada correctamente.');
    }

    // Ver archivo adjunto de notificación
    public function verArchivo($id)
    {
        $notificacion = $this->notificacionModel->find($id);

        if (!$notificacion || !$notificacion['archivo']) {
            return redirect()->back()->with('error', 'Archivo no encontrado.');
        }

        $ruta = WRITEPATH . '../public/uploads/notificaciones/' . $notificacion['archivo'];

        if (!file_exists($ruta)) {
            return redirect()->back()->with('error', 'El archivo no existe.');
        }

        // Detectar tipo de contenido
        $extension = pathinfo($notificacion['archivo'], PATHINFO_EXTENSION);
        $contentType = ($extension === 'pdf') ? 'application/pdf' : mime_content_type($ruta);

        return $this->response
                    ->setHeader('Content-Type', $contentType)
                    ->setHeader('Content-Disposition', 'inline; filename="' . $notificacion['archivo'] . '"')
                    ->setBody(file_get_contents($ruta));
    }

    // Actualizar perfil
    public function actualizarPerfil()
    {
        $usuarioId = session('id_usuario');
        $administrativo = $this->adminModel->getByUsuarioId($usuarioId);

        $datos = $this->request->getPost();

        $this->adminModel->update($administrativo['id'], [
            'telefono' => $datos['telefono'],
            'direccion' => $datos['direccion']
        ]);

        return redirect()->to(base_url('administrativos/perfil'))->with('success', 'Perfil actualizado correctamente');
    }

    // Cambiar contraseña
    public function cambiarPassword()
    {
        $usuarioId = session('id_usuario');

        $passwordActual = $this->request->getPost('password_actual');
        $passwordNueva = $this->request->getPost('password_nueva');
        $passwordConfirmar = $this->request->getPost('password_confirmar');

        if ($passwordNueva !== $passwordConfirmar) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden');
        }

        $usuario = $this->usuarioModel->find($usuarioId);
        if (!password_verify($passwordActual, $usuario['password'])) {
            return redirect()->back()->with('error', 'La contraseña actual es incorrecta');
        }

        $this->usuarioModel->update($usuarioId, [
            'password' => password_hash($passwordNueva, PASSWORD_DEFAULT)
        ]);

        return redirect()->to(base_url('administrativos/perfil'))->with('success', 'Contraseña actualizada correctamente');
    }

    // =========================================
    // GESTIÓN DE SOLICITUDES DE MATRÍCULA
    // =========================================
    
    /**
     * Ver estudiantes distribuidos por ciclo
     */
    public function estudiantesPorCiclo()
    {
        // Filtros opcionales
        $cicloFiltro = $this->request->getGet('ciclo');
        $carreraFiltro = $this->request->getGet('carrera');
        
        // Obtener todos los estudiantes con su progreso académico
        $db = \Config\Database::connect();
        
        // Paso 1: Calcular créditos por estudiante en una subconsulta
        $query = "
            SELECT 
                e.id,
                e.codigo_estudiante,
                e.nombres,
                e.apellidos,
                e.telefono,
                e.fecha_registro,
                u.email,
                u.estado as usuario_estado,
                LEFT(e.codigo_estudiante, 4) as anio_ingreso,
                COUNT(m.id) as cursos_completados,
                COUNT(m.id) as total_cursos_aprobados,
                IFNULL(SUM(c.creditos), 0) as creditos_acumulados,
                CASE 
                    WHEN IFNULL(SUM(c.creditos), 0) >= 192 THEN 10
                    WHEN IFNULL(SUM(c.creditos), 0) >= 160 THEN 9
                    WHEN IFNULL(SUM(c.creditos), 0) >= 128 THEN 8
                    WHEN IFNULL(SUM(c.creditos), 0) >= 96 THEN 7
                    WHEN IFNULL(SUM(c.creditos), 0) >= 64 THEN 6
                    WHEN IFNULL(SUM(c.creditos), 0) >= 48 THEN 5
                    WHEN IFNULL(SUM(c.creditos), 0) >= 32 THEN 4
                    WHEN IFNULL(SUM(c.creditos), 0) >= 16 THEN 3
                    WHEN IFNULL(SUM(c.creditos), 0) > 0 THEN 2
                    ELSE 1
                END as ciclo_actual
            FROM estudiantes e
            LEFT JOIN usuarios u ON u.id = e.usuario_id
            LEFT JOIN matriculas m ON m.estudiante_id = e.id AND m.estado = 'finalizado'
            LEFT JOIN cursos c ON c.id = m.curso_id
            WHERE 1=1";

        // Aplicar filtros
        if ($carreraFiltro) {
            $query .= " AND e.carrera_id = " . intval($carreraFiltro);
        }

        $query .= "
            GROUP BY e.id, e.codigo_estudiante, e.nombres, e.apellidos, e.telefono, e.fecha_registro, u.email, u.estado
        ";
        
        // Aplicar filtro si existe
        if ($cicloFiltro) {
            $query .= " HAVING ciclo_actual = " . intval($cicloFiltro);
        }
        
        $query .= " ORDER BY ciclo_actual ASC, e.codigo_estudiante ASC";
        
        $estudiantes = $db->query($query)->getResultArray();
        
        // Calcular estadísticas por ciclo usando la misma lógica
        $sqlEstadisticas = "
            SELECT 
                CASE 
                    WHEN IFNULL(SUM(c.creditos), 0) >= 192 THEN 10
                    WHEN IFNULL(SUM(c.creditos), 0) >= 160 THEN 9
                    WHEN IFNULL(SUM(c.creditos), 0) >= 128 THEN 8
                    WHEN IFNULL(SUM(c.creditos), 0) >= 96 THEN 7
                    WHEN IFNULL(SUM(c.creditos), 0) >= 64 THEN 6
                    WHEN IFNULL(SUM(c.creditos), 0) >= 48 THEN 5
                    WHEN IFNULL(SUM(c.creditos), 0) >= 32 THEN 4
                    WHEN IFNULL(SUM(c.creditos), 0) >= 16 THEN 3
                    WHEN IFNULL(SUM(c.creditos), 0) > 0 THEN 2
                    ELSE 1
                END as ciclo
            FROM estudiantes e
            LEFT JOIN matriculas m ON m.estudiante_id = e.id AND m.estado = 'finalizado'
            LEFT JOIN cursos c ON c.id = m.curso_id
            WHERE 1=1
        ";
        if ($carreraFiltro) { $sqlEstadisticas .= " AND e.carrera_id = " . intval($carreraFiltro); }
        $sqlEstadisticas .= " GROUP BY e.id";
        $estadisticas = $db->query($sqlEstadisticas)->getResultArray();
        
        // Agrupar estadísticas por ciclo
        $resumenCiclos = [];
        for ($i = 1; $i <= 10; $i++) {
            $resumenCiclos[$i] = 0;
        }
        
        foreach ($estadisticas as $est) {
            $ciclo = $est['ciclo'];
            $resumenCiclos[$ciclo]++;
        }
        
        return view('administrativos/estudiantes/por_ciclo', [
            'estudiantes' => $estudiantes,
            'resumenCiclos' => $resumenCiclos,
            'cicloFiltro' => $cicloFiltro
        ]);
    }
    
    /**
     * Lista de solicitudes de matrícula pendientes y todas las demás
     */
    public function solicitudesMatricula()
    {
        // Obtener todas las solicitudes con información del estudiante y periodo
        $solicitudes = $this->solicitudMatriculaModel
            ->select('solicitudes_matricula.*, 
                      estudiantes.nombres, 
                      estudiantes.apellidos, 
                      estudiantes.codigo_estudiante,
                      periodos_academicos.nombre as periodo_nombre,
                      administrativos.nombres as admin_nombres,
                      administrativos.apellidos as admin_apellidos')
            ->join('estudiantes', 'estudiantes.id = solicitudes_matricula.estudiante_id')
            ->join('periodos_academicos', 'periodos_academicos.id = solicitudes_matricula.periodo_id')
            ->join('administrativos', 'administrativos.id = solicitudes_matricula.revisado_por', 'left')
            ->orderBy('solicitudes_matricula.fecha_solicitud', 'DESC')
            ->findAll();

        return view('administrativos/matriculas/solicitudes', [
            'solicitudes' => $solicitudes
        ]);
    }

    /**
     * Ver detalle de una solicitud específica con el comprobante
     */
    // Alias para ruta: verSolicitudMatricula
    public function verSolicitudMatricula($id)
    {
        $solicitud = $this->solicitudMatriculaModel
            ->select('solicitudes_matricula.*, 
                      estudiantes.nombres, 
                      estudiantes.apellidos, 
                      estudiantes.codigo_estudiante,
                      estudiantes.dni,
                      estudiantes.telefono,
                      periodos_academicos.nombre as periodo_nombre,
                      periodos_academicos.fecha_inicio,
                      periodos_academicos.fecha_fin')
            ->join('estudiantes', 'estudiantes.id = solicitudes_matricula.estudiante_id')
            ->join('periodos_academicos', 'periodos_academicos.id = solicitudes_matricula.periodo_id')
            ->where('solicitudes_matricula.id', $id)
            ->first();

        if (!$solicitud) {
            return redirect()->back()->with('error', 'Solicitud no encontrada.');
        }

        return view('administrativos/matriculas/ver', [
            'solicitud' => $solicitud
        ]);
    }

    /**
     * Ver comprobante de pago en el navegador
     */
    public function verComprobante($id)
    {
        $solicitud = $this->solicitudMatriculaModel->find($id);

        if (!$solicitud || !$solicitud['comprobante_pago']) {
            return redirect()->back()->with('error', 'Comprobante no encontrado.');
        }

        $ruta = WRITEPATH . '../public/uploads/comprobantes/' . $solicitud['comprobante_pago'];

        if (!file_exists($ruta)) {
            return redirect()->back()->with('error', 'El archivo no existe.');
        }

        // Detectar tipo de contenido
        $extension = pathinfo($solicitud['comprobante_pago'], PATHINFO_EXTENSION);
        $contentType = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']) 
            ? 'image/' . ($extension === 'jpg' ? 'jpeg' : $extension)
            : 'application/pdf';

        return $this->response
            ->setHeader('Content-Type', $contentType)
            ->setHeader('Content-Disposition', 'inline; filename="' . $solicitud['comprobante_pago'] . '"')
            ->setBody(file_get_contents($ruta));
    }

    /**
     * Aprobar solicitud de matrícula
     */
    // Alias consolidado: aprobarRechazarMatricula segun estado enviado
    public function aprobarRechazarMatricula($id)
    {
        $solicitud = $this->solicitudMatriculaModel->find($id);

        if (!$solicitud) {
            return redirect()->back()->with('error', 'Solicitud no encontrada.');
        }

        if ($solicitud['estado'] !== 'pendiente') {
            return redirect()->back()->with('error', 'Esta solicitud ya fue procesada.');
        }
        $accion = $this->request->getPost('accion') ?? 'aprobar';
        $observaciones = $this->request->getPost('observaciones');

        // Obtener administrativo logueado
        $usuarioLogeado = session()->get('id_usuario');
        $admin = $this->adminModel->where('usuario_id', $usuarioLogeado)->first();
        if (!$admin) { return redirect()->back()->with('error', 'No se encontró el administrativo.'); }

        if ($accion === 'rechazar') {
            if (!$observaciones) {
                return redirect()->back()->with('error', 'Debes especificar el motivo del rechazo.');
            }
            $this->solicitudMatriculaModel->update($id, [
                'estado' => 'rechazado',
                'revisado_por' => $admin['id'],
                'fecha_revision' => date('Y-m-d H:i:s'),
                'observaciones' => $observaciones
            ]);
            $estudiante = $this->estudianteModel->find($solicitud['estudiante_id']);
            if ($estudiante) {
                $this->notificacionModel->insert([
                    'usuario_id' => $estudiante['usuario_id'],
                    'titulo' => '❌ Solicitud de Matrícula Rechazada',
                    'mensaje' => 'Tu solicitud de matrícula ha sido RECHAZADA. Motivo: ' . $observaciones,
                    'tipo' => 'matricula',
                    'fecha_envio' => date('Y-m-d H:i:s'),
                    'leido' => 0
                ]);
            }
            return redirect()->to(base_url('administrativos/matriculas/solicitudes'))->with('success', 'Solicitud rechazada.');
        }

        // Aprobar por defecto
        $this->solicitudMatriculaModel->update($id, [
            'estado' => 'aprobado',
            'revisado_por' => $admin['id'],
            'fecha_revision' => date('Y-m-d H:i:s'),
            'observaciones' => $observaciones ?? 'Solicitud aprobada correctamente'
        ]);
        $estudiante = $this->estudianteModel->find($solicitud['estudiante_id']);
        if ($estudiante) {
            $this->notificacionModel->insert([
                'usuario_id' => $estudiante['usuario_id'],
                'titulo' => '✅ Solicitud de Matrícula Aprobada',
                'mensaje' => 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.',
                'tipo' => 'matricula',
                'fecha_envio' => date('Y-m-d H:i:s'),
                'leido' => 0
            ]);
        }
        return redirect()->to(base_url('administrativos/matriculas/solicitudes'))->with('success', 'Solicitud aprobada.');
    }

}
