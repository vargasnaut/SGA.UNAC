<?php

namespace App\Controllers;

use App\Models\EstudianteModel;
use App\Models\CursoModel;
use App\Models\MatriculaModel;
use App\Models\NotificacionModel;
use App\Models\TramiteModel;
use App\Models\MaterialModel;
use App\Models\AsistenciaModel;
use App\Models\CalificacionModel;
use App\Models\SolicitudMatriculaModel;
use App\Models\PrerrequisitoModel;
use App\Models\PeriodoAcademicoModel;
use App\Models\ProgramacionHorariaModel;
use App\Models\PagoModel;
use App\Models\ConceptoPagoModel;

class Estudiantes extends BaseController
{
    protected $estudianteModel;
    protected $cursoModel;
    protected $matriculaModel;
    protected $notificacionModel;
    protected $tramiteModel;
    protected $materialModel;
    protected $asistenciaModel;
    protected $calificacionModel;
    protected $solicitudMatriculaModel;
    protected $prerrequisitoModel;
    protected $periodoAcademicoModel;
    protected $programacionHorariaModel;
    protected $pagoModel;
    protected $conceptoPagoModel;

    public function __construct()
    {
        $this->estudianteModel = new EstudianteModel();
        $this->cursoModel = new CursoModel();
        $this->matriculaModel = new MatriculaModel();
        $this->notificacionModel = new NotificacionModel();
        $this->tramiteModel = new TramiteModel();
        $this->materialModel = new MaterialModel();
        $this->asistenciaModel = new AsistenciaModel();
        $this->calificacionModel = new CalificacionModel();
        $this->solicitudMatriculaModel = new SolicitudMatriculaModel();
        $this->prerrequisitoModel = new PrerrequisitoModel();
        $this->periodoAcademicoModel = new PeriodoAcademicoModel();
        $this->programacionHorariaModel = new ProgramacionHorariaModel();
        $this->pagoModel = new PagoModel();
        $this->conceptoPagoModel = new ConceptoPagoModel();
    }

    // DASHBOARD PRINCIPAL
    public function index()
    {
        $usuarioId = session('id_usuario');

        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

        return view('dashboard/estudiante', [
            'estudiante' => $estudiante
        ]);
    }

    //Perfil del Estudiante
    public function perfil()
    {
        $usuarioId = session('id_usuario');

        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

        return view('estudiantes/perfiles/perfil', [
            'estudiante' => $estudiante
        ]);
    }


    public function actualizarPerfil()
    {
        $usuarioId = session('id_usuario');

        // Obtener datos del estudiante
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }

        // Validar campos enviados
        $nombres    = $this->request->getPost('nombres');
        $apellidos  = $this->request->getPost('apellidos');
        $dni        = $this->request->getPost('dni');
        $direccion  = $this->request->getPost('direccion');
        $telefono   = $this->request->getPost('telefono');

        if (!$nombres || !$apellidos || !$dni) {
            return redirect()->back()->with('error', 'Los campos obligatorios no pueden estar vacíos.');
        }

        // Actualizar estudiante
        $this->estudianteModel->update($estudiante['id'], [
            'nombres'    => $nombres,
            'apellidos'  => $apellidos,
            'dni'        => $dni,
            'direccion'  => $direccion,
            'telefono'   => $telefono
        ]);

        return redirect()->to('/estudiantes/perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    public function cambiarPassword()
    {
        $session = session();
        $usuarioId = $session->get('id_usuario');

        $passwordActual   = $this->request->getPost('password_actual');
        $passwordNueva    = $this->request->getPost('password_nueva');
        $passwordConfirmar = $this->request->getPost('password_confirmar');

        // Validar que las contraseñas nuevas coincidan
        if ($passwordNueva !== $passwordConfirmar) {
            return redirect()->back()->with('error', 'La nueva contraseña y su confirmación no coinciden.');
        }

        $usuarioModel = new \App\Models\UsuarioModel();
        $usuario = $usuarioModel->find($usuarioId);

        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }

        // Verificar contraseña actual (en tu caso, parece que no usas hash)
        if ($passwordActual !== $usuario['password']) {
            return redirect()->back()->with('error', 'La contraseña actual es incorrecta.');
        }

        // Actualizar contraseña
        $usuarioModel->update($usuarioId, [
            'password' => $passwordNueva // Si usas password_hash, aquí debes hashearla
        ]);

        return redirect()->back()->with('success', 'Contraseña actualizada correctamente.');
    }

    public function cursos()
    {
        $usuarioId = session('id_usuario');

        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);
        
        if (!$estudiante) {
            return redirect()->to('dashboard')->with('error', 'Estudiante no encontrado.');
        }

        $cursos = $this->matriculaModel
            ->select('c.id, c.nombre, c.codigo_curso, d.nombres as docente_nombres, d.apellidos as docente_apellidos')
            ->join('cursos c', 'c.id = matriculas.curso_id')
            ->join('docentes d', 'd.id = c.docente_id')
            ->where('matriculas.estudiante_id', $estudiante['id'])
            ->findAll();

        return view('estudiantes/mis-cursos', [
            'cursos' => $cursos
        ]);
    }

    public function matriculas()
    {
        $usuarioId = session('id_usuario');

        $matriculas = $this->matriculaModel->getMatriculasPorEstudiante($usuarioId);

        return view('estudiantes/matriculas/index', [
            'matriculas' => $matriculas
        ]);
    }

    public function notificaciones()
    {
        $usuarioId = session('id_usuario');

        $notificaciones = $this->notificacionModel
            ->where('usuario_id', $usuarioId)
            ->orderBy('fecha_envio', 'DESC')
            ->findAll();

        return view('estudiantes/notificaciones/index', [
            'notificaciones' => $notificaciones
        ]);
    }

        public function tramites()
    {
        $usuarioId = session('id_usuario');
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }

        $tramites = $this->tramiteModel
            ->where('estudiante_id', $estudiante['id'])
            ->orderBy('fecha_solicitud', 'DESC')
            ->findAll();

        return view('estudiantes/tramites/index', [
            'estudiante' => $estudiante,
            'tramites' => $tramites
        ]);
    }


            # ACCIIONES PARA TRÁMITES DEL ESTUDIANTE
            public function crear()
            {
                $usuarioId = session('id_usuario');
                $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

                if (!$estudiante) {
                    return redirect()->back()->with('error', 'Estudiante no encontrado.');
                }

                return view('estudiantes/tramites/crear', [
                    'estudiante' => $estudiante
                ]);
            }




            public function guardar()
            {
                $usuarioId = session('id_usuario');
                $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

                if (!$estudiante) {
                    return redirect()->back()->with('error', 'Estudiante no encontrado.');
                }

                // Validación básica
                $rules = [
                    'tipo' => 'required',
                    'motivo' => 'required|min_length[3]',
                    'descripcion' => 'required|min_length[10]',
                    'documento' => [
                        'rules' => 'permit_empty|max_size[documento,4096]|ext_in[documento,pdf,jpg,jpeg,png,docx]',
                        'errors' => [
                            'max_size' => 'El archivo no puede superar los 4 MB.',
                            'ext_in' => 'Formato no permitido.'
                        ]
                    ]
                ];

                if (!$this->validate($rules)) {
                    return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
                }

                // Subida del archivo (si existe)
                $archivo = $this->request->getFile('documento');
                $nombreArchivo = null;
                if ($archivo && $archivo->isValid()) {
                    $nombreArchivo = $archivo->getRandomName();
                    $archivo->move(FCPATH . 'uploads/tramites/', $nombreArchivo);
                }

                // Guardar cada campo por separado (NO concatenar motivo dentro de descripcion)
                $this->tramiteModel->insert([
                    'estudiante_id'    => $estudiante['id'],
                    'tipo'             => $this->request->getPost('tipo'),
                    'motivo'           => $this->request->getPost('motivo'),
                    'descripcion'      => $this->request->getPost('descripcion'),
                    'tipo_documento'   => $this->request->getPost('tipo_documento'),
                    'documento'        => $nombreArchivo,
                    'estado'           => 'pendiente',
                    'fecha_solicitud'  => date('Y-m-d')
                ]);

                return redirect()->to('/estudiantes/tramites')
                    ->with('success', 'Tu trámite fue registrado correctamente.');
            }

   
            public function ver($id)
            {
                $usuarioId = session('id_usuario');
                $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

                if (!$estudiante) {
                    return redirect()->back()->with('error', 'Estudiante no encontrado.');
                }

                $tramite = $this->tramiteModel->find($id);

                if (!$tramite || $tramite['estudiante_id'] != $estudiante['id']) {
                    return redirect()->to('/estudiantes/tramites')->with('error', 'Trámite no válido.');
                }

                return view('estudiantes/tramites/ver', compact('tramite'));
            }


            public function editar($id)
            {
                $usuarioId = session('id_usuario');
                $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

                if (!$estudiante) {
                    return redirect()->back()->with('error', 'Estudiante no encontrado.');
                }

                $tramite = $this->tramiteModel->find($id);

                if (!$tramite || $tramite['estudiante_id'] != $estudiante['id']) {
                    return redirect()->to('/estudiantes/tramites')->with('error', 'Trámite no válido.');
                }

                return view('estudiantes/tramites/editar', compact('tramite'));
            }

            public function actualizar($id)
                {
                    $usuarioId = session('id_usuario');
                    $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

                    if (!$estudiante) {
                        return redirect()->back()->with('error', 'Estudiante no encontrado.');
                    }

                    $tramite = $this->tramiteModel->find($id);
                    if (!$tramite || $tramite['estudiante_id'] != $estudiante['id']) {
                        return redirect()->to('/estudiantes/tramites')->with('error', 'No autorizado.');
                    }

                    // Validación similar a guardar
                    $rules = [
                        'tipo' => 'required',
                        'motivo' => 'required|min_length[3]',
                        'descripcion' => 'required|min_length[10]',
                        'documento' => [
                            'rules' => 'permit_empty|max_size[documento,4096]|ext_in[documento,pdf,jpg,jpeg,png,docx]',
                            'errors' => [
                                'max_size' => 'El archivo no puede superar los 4 MB.',
                                'ext_in' => 'Formato no permitido.'
                            ]
                        ]
                    ];

                    if (!$this->validate($rules)) {
                        return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
                    }

                    // Subida del archivo si se reemplaza
                    $archivo = $this->request->getFile('documento');
                    $nombreArchivo = $tramite['documento'];
                    if ($archivo && $archivo->isValid()) {
                        $nombreArchivo = $archivo->getRandomName();
                        $archivo->move(FCPATH . 'uploads/tramites/', $nombreArchivo);
                    }

                    // Actualizar sin concatenar
                    $this->tramiteModel->update($id, [
                        'tipo'           => $this->request->getPost('tipo'),
                        'motivo'         => $this->request->getPost('motivo'),
                        'descripcion'    => $this->request->getPost('descripcion'),
                        'tipo_documento' => $this->request->getPost('tipo_documento'),
                        'documento'      => $nombreArchivo
                    ]);

                    return redirect()->to('/estudiantes/tramites')->with('success', 'Trámite actualizado correctamente.');
                }



            


            public function eliminar($id)
            {
                $usuarioId = session('id_usuario');
                $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

                if (!$estudiante) {
                    return redirect()->back()->with('error', 'Estudiante no encontrado.');
                }

                $tramite = $this->tramiteModel->find($id);

                if (!$tramite || $tramite['estudiante_id'] != $estudiante['id']) {
                    return redirect()->to('/estudiantes/tramites')->with('error', 'Trámite no válido.');
                }

                $this->tramiteModel->delete($id);

                return redirect()->to('/estudiantes/tramites')->with('success', 'Trámite eliminado correctamente.');
            }


            // Ver Docuemento(pdf,jpg,png,etc) del Trámite del Estudiante
            public function verDocumento($id)
                {
                    $tramite = $this->tramiteModel->find($id);

                    if (!$tramite || empty($tramite['documento'])) {
                        return 'Documento no encontrado';
                    }

                    $ruta = FCPATH . 'uploads/tramites/' . $tramite['documento'];

                    if (!file_exists($ruta)) {
                        return 'El archivo no existe en el servidor.';
                    }

                    $extension = strtolower(pathinfo($ruta, PATHINFO_EXTENSION));

                    // Definir el tipo correcto segun el archivo
                    $mimeTypes = [
                        'pdf'  => 'application/pdf',
                        'jpg'  => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'png'  => 'image/png',
                        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'doc'  => 'application/msword',
                        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'xls'  => 'application/vnd.ms-excel'
                    ];

                    $mime = $mimeTypes[$extension] ?? 'application/octet-stream';

                    return $this->response
                                ->setHeader('Content-Type', $mime)
                                ->setHeader('Content-Disposition', 'inline; filename="' . $tramite['documento'] . '"')
                                ->setBody(file_get_contents($ruta));
                }



    // Marcar notificación como leída
    public function marcarNotificacionLeida($id)
    {
        $usuarioId = session('id_usuario');
        $notificacion = $this->notificacionModel->find($id);

        // Verificar que la notificación pertenece al usuario
        if ($notificacion && $notificacion['usuario_id'] == $usuarioId) {
            $this->notificacionModel->update($id, ['leido' => 1]);
        }

        return redirect()->back();
    }

    // Ver archivo adjunto de notificación
    public function verArchivoNotificacion($id)
    {
        $usuarioId = session('id_usuario');
        $notificacion = $this->notificacionModel->find($id);

        // Verificar que la notificación pertenece al usuario
        if (!$notificacion || $notificacion['usuario_id'] != $usuarioId || !$notificacion['archivo']) {
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

    // Ver calificaciones por curso
    public function verCalificaciones($cursoId)
    {
        $usuarioId = session('id_usuario');
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);
        
        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }
        
        // Verificar que el estudiante está matriculado en el curso
        $matricula = $this->matriculaModel
            ->where('estudiante_id', $estudiante['id'])
            ->where('curso_id', $cursoId)
            ->first();
        
        if (!$matricula) {
            return redirect()->back()->with('error', 'No está matriculado en este curso.');
        }
        
        $curso = $this->cursoModel->find($cursoId);
        $calificacion = $this->calificacionModel->where('matricula_id', $matricula['id'])->first();
        
        return view('estudiantes/calificaciones', [
            'curso' => $curso,
            'matricula' => $matricula,
            'calificacion' => $calificacion
        ]);
    }

    // Ver asistencias por curso
    public function verAsistencias($cursoId)
    {
        $usuarioId = session('id_usuario');
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);
        
        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }
        
        // Verificar que el estudiante está matriculado en el curso
        $matricula = $this->matriculaModel
            ->where('estudiante_id', $estudiante['id'])
            ->where('curso_id', $cursoId)
            ->first();
        
        if (!$matricula) {
            return redirect()->back()->with('error', 'No está matriculado en este curso.');
        }
        
        $curso = $this->cursoModel->find($cursoId);
        $asistencias = $this->asistenciaModel
            ->where('matricula_id', $matricula['id'])
            ->orderBy('fecha', 'DESC')
            ->findAll();
        
        return view('estudiantes/asistencias', [
            'curso' => $curso,
            'asistencias' => $asistencias
        ]);
    }

    // Ver materiales por curso
    public function verMateriales($cursoId)
    {
        $usuarioId = session('id_usuario');
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);
        
        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }
        
        // Verificar que el estudiante está matriculado en el curso
        $matricula = $this->matriculaModel
            ->where('estudiante_id', $estudiante['id'])
            ->where('curso_id', $cursoId)
            ->first();
        
        if (!$matricula) {
            return redirect()->back()->with('error', 'No está matriculado en este curso.');
        }
        
        $curso = $this->cursoModel->find($cursoId);
        $materiales = $this->materialModel->getMaterialesPorCurso($cursoId);
        
        return view('estudiantes/materiales', [
            'curso' => $curso,
            'materiales' => $materiales
        ]);
    }

    // Descargar material
    public function descargarMaterial($id)
    {
        $usuarioId = session('id_usuario');
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);
        
        if (!$estudiante) {
            return redirect()->back()->with('error', 'No autorizado.');
        }
        
        $material = $this->materialModel->find($id);
        if (!$material) {
            return redirect()->back()->with('error', 'Material no encontrado');
        }
        
        // Verificar que el estudiante está matriculado en el curso del material
        $matricula = $this->matriculaModel
            ->where('estudiante_id', $estudiante['id'])
            ->where('curso_id', $material['curso_id'])
            ->first();
        
        if (!$matricula) {
            return redirect()->back()->with('error', 'No tiene acceso a este material.');
        }
        
        $path = FCPATH . 'uploads/materiales/' . $material['archivo'];
        if (!is_file($path)) {
            return redirect()->back()->with('error', 'Archivo no disponible');
        }
        return $this->response->download($path, null);
    }

    /*-------------------------------------------------------------------
    ------------------------- PROCESO DE MATRÍCULA ----------------------
    --------------------------------------------------------------------*/
    

    // Solicitar habilitación de matrícula (subir comprobante)
public function solicitarMatricula()
{
    $usuarioId = session('id_usuario');
    $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

    if (!$estudiante) {
        return redirect()->back()->with('error', 'No se encontró al estudiante asociado.');
    }

    // Obtener periodo próximo o actual
    $periodo = $this->periodoAcademicoModel->getPeriodoProximo() ??
               $this->periodoAcademicoModel->getPeriodoActual();

    if (!$periodo) {
        return redirect()->back()->with('error', 'No hay periodo académico disponible.');
    }

    // Verificar solicitud previa
    $solicitudExistente = $this->solicitudMatriculaModel
                              ->getSolicitudPorEstudiante($estudiante['id'], $periodo['id']);

    if ($this->request->is('post')) {

        // Evitar duplicación
        if ($solicitudExistente && in_array($solicitudExistente['estado'], ['pendiente', 'aprobado'])) {
            return redirect()->back()
                ->with('error', 'Ya enviaste una solicitud para este periodo.');
        }

        // Validación del archivo
        $validation = $this->validate([
            'comprobante_pago' => [
                'uploaded[comprobante_pago]',
                'mime_in[comprobante_pago,image/jpeg,image/png,application/pdf]',
                'max_size[comprobante_pago,4096]' // 4 MB
            ],
            'monto' => 'required|decimal'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('error', 'Error en los datos enviados.');
        }

        $file = $this->request->getFile('comprobante_pago');
        $newName = $file->getRandomName();

        // Carpeta segura
        $uploadDir = WRITEPATH . 'uploads/comprobantes/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $file->move($uploadDir, $newName);

        // Guardar solicitud
        $this->solicitudMatriculaModel->insert([
            'estudiante_id'     => $estudiante['id'],
            'periodo_id'        => $periodo['id'],
            'comprobante_pago'  => $newName,
            'monto'             => floatval($this->request->getPost('monto')),
            'estado'            => 'pendiente',
            'fecha_solicitud'   => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('estudiantes/matricula/solicitar'))
            ->with('success', 'Solicitud enviada correctamente. Espere la verificación.');
    }

    return view('estudiantes/matricula/solicitar', [
        'estudiante' => $estudiante,
        'periodo'    => $periodo,
        'solicitud'  => $solicitudExistente
    ]);
}

    // Alias de selección de cursos usando cursosDisponibles()
    public function seleccionarCursosMatricula()
    {
        return $this->cursosDisponibles();
    }

    // Guardar matrícula múltiple (selección de varios cursos de una vez)
    public function guardarMatricula()
    {
        $usuarioId = session('id_usuario');
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);
        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }

        $periodo = $this->periodoAcademicoModel->getPeriodoProximo() ?? $this->periodoAcademicoModel->getPeriodoActual();
        if (!$periodo) {
            return redirect()->back()->with('error', 'No hay periodo académico disponible.');
        }

        // Verificar autorización
        $solicitud = $this->solicitudMatriculaModel->getSolicitudPorEstudiante($estudiante['id'], $periodo['id']);
        if (!$solicitud || $solicitud['estado'] !== 'aprobado') {
            return redirect()->to(base_url('estudiantes/matricula/solicitar'))->with('error', 'Debe tener solicitud aprobada.');
        }

        $cursosSeleccionados = (array) $this->request->getPost('cursos');
        if (empty($cursosSeleccionados)) {
            return redirect()->back()->with('error', 'Seleccione al menos un curso.');
        }

        $exitos = 0; $fallos = [];
        foreach ($cursosSeleccionados as $cursoId) {
            // Reutilizar validaciones de matricularCurso, de forma resumida
            $validacion = $this->prerrequisitoModel->validarPrerrequisitos($estudiante['id'], $cursoId);
            if (!$validacion['valido']) { $fallos[] = "Prerrequisitos no cumplidos (curso $cursoId)"; continue; }

            // Evitar matrícula duplicada en mismo periodo
            $yaMatriculado = $this->matriculaModel
                ->where('estudiante_id', $estudiante['id'])
                ->where('curso_id', $cursoId)
                ->where('periodo_id', $periodo['id'])
                ->first();
            if ($yaMatriculado) { $fallos[] = "Ya matriculado (curso $cursoId)"; continue; }

            $cupos = $this->programacionHorariaModel->verificarCuposDisponibles($cursoId, $periodo['id']);
            // No bloquear por falta de cupos/programación

            // Verificar conflicto de horarios (no bloquea la matrícula en lote)
            $conf = $this->programacionHorariaModel->verificarConflictoHorario($estudiante['id'], $cursoId, $periodo['id']);
            if ($conf['conflicto']) { /* se permite matricular igualmente */ }

            $lim = $this->programacionHorariaModel->verificarLimiteCreditos($estudiante['id'], $cursoId, $periodo['id'], 22);
            if (!$lim['permitido']) { $fallos[] = $lim['mensaje']; continue; }

            $this->matriculaModel->insert([
                'estudiante_id' => $estudiante['id'],
                'curso_id' => $cursoId,
                'periodo_id' => $periodo['id'],
                'estado' => 'matriculado'
            ]);
            $this->programacionHorariaModel->incrementarMatriculados($cursoId, $periodo['id']);
            $exitos++;
        }

        if ($exitos > 0) {
            $msg = "Se registraron $exitos matrículas.";
            if (!empty($fallos)) { $msg .= ' Algunas no se pudieron registrar: ' . implode('; ', $fallos); }
            return redirect()->to(base_url('estudiantes/matricula/seleccionar'))->with('success', $msg);
        }
        return redirect()->back()->with('error', 'No se pudo registrar ninguna matrícula: ' . implode('; ', $fallos));
    }
    
    // Ver cursos disponibles para matricularse (validando prerrequisitos)
    public function cursosDisponibles()
    {
        $usuarioId = session('id_usuario');
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);
        
        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }
        
        // Verificar si tiene solicitud aprobada
        $periodo = $this->periodoAcademicoModel->getPeriodoProximo() ?? $this->periodoAcademicoModel->getPeriodoActual();
        if (!$periodo) {
            return redirect()->back()->with('error', 'No hay periodo académico disponible.');
        }
        
        $solicitud = $this->solicitudMatriculaModel->getSolicitudPorEstudiante($estudiante['id'], $periodo['id']);
        
        if (!$solicitud || $solicitud['estado'] !== 'aprobado') {
            return redirect()->to(base_url('estudiantes/matricula/solicitar'))->with('error', 'Debe tener solicitud aprobada para matricularse.');
        }
        
        // Calcular ciclo actual del estudiante según créditos acumulados
        $db = \Config\Database::connect();
        $creditosData = $db->table('matriculas m')
            ->select('IFNULL(SUM(c.creditos), 0) as creditos_acumulados')
            ->join('cursos c', 'c.id = m.curso_id')
            ->where('m.estudiante_id', $estudiante['id'])
            ->where('m.estado', 'finalizado')
            ->get()
            ->getRowArray();
        
        $creditosAcumulados = $creditosData['creditos_acumulados'] ?? 0;
        
        // Determinar ciclo actual según créditos
        if ($creditosAcumulados >= 192) {
            $cicloActual = 10;
        } elseif ($creditosAcumulados >= 160) {
            $cicloActual = 9;
        } elseif ($creditosAcumulados >= 128) {
            $cicloActual = 8;
        } elseif ($creditosAcumulados >= 96) {
            $cicloActual = 7;
        } elseif ($creditosAcumulados >= 64) {
            $cicloActual = 6;
        } elseif ($creditosAcumulados >= 48) {
            $cicloActual = 5;
        } elseif ($creditosAcumulados >= 32) {
            $cicloActual = 4;
        } elseif ($creditosAcumulados >= 16) {
            $cicloActual = 3;
        } elseif ($creditosAcumulados > 0) {
            $cicloActual = 2;
        } else {
            $cicloActual = 1;
        }
        
        // Obtener solo cursos del ciclo actual del estudiante con información de horarios
        $cursos = $db->table('cursos')
            ->select('cursos.*')
            ->where('cursos.carrera_id', $estudiante['carrera_id'])
            ->where('cursos.ciclo', $cicloActual)
            ->orderBy('cursos.codigo_curso', 'ASC')
            ->get()
            ->getResultArray();
        
        // Validar prerrequisitos y estado de matrícula
        $cursosDisponibles = [];
        $totalCreditosActuales = 0;
        
        foreach ($cursos as $curso) {
            // Obtener información de programación horaria con docente
            $horarios = $db->table('programacion_horaria ph')
                ->select('ph.*, CONCAT(d.nombres, " ", d.apellidos) as docente_nombre')
                ->join('docentes d', 'd.id = ph.docente_id', 'left')
                ->where('ph.curso_id', $curso['id'])
                ->where('ph.periodo_id', $periodo['id'])
                ->where('ph.activo', 1)
                ->get()
                ->getResultArray();
            
            $curso['horarios'] = $horarios;
            $curso['docente_nombres'] = !empty($horarios) ? $horarios[0]['docente_nombre'] : 'Sin asignar';
            
            // Verificar si ya está matriculado
            $yaMatriculado = $this->matriculaModel
                ->where('estudiante_id', $estudiante['id'])
                ->where('curso_id', $curso['id'])
                ->where('periodo_id', $periodo['id'])
                ->first();
            
            if ($yaMatriculado) {
                $curso['estado'] = 'matriculado';
                $curso['puede_matricular'] = false;
                $totalCreditosActuales += $curso['creditos'];
            } else {
                // Validar prerrequisitos
                $validacion = $this->prerrequisitoModel->validarPrerrequisitos($estudiante['id'], $curso['id']);
                $curso['puede_matricular'] = $validacion['valido'];
                $curso['prerrequisitos_pendientes'] = $validacion['pendientes'];
                
                // Verificar cupos disponibles
                $infoCupos = $this->programacionHorariaModel->verificarCuposDisponibles($curso['id'], $periodo['id']);
                $curso['cupos_info'] = $infoCupos;
                $curso['tiene_cupos'] = $infoCupos['disponible'];
                
                // Verificar conflicto de horarios
                $infoHorario = $this->programacionHorariaModel->verificarConflictoHorario($estudiante['id'], $curso['id'], $periodo['id']);
                $curso['conflicto_horario'] = $infoHorario['conflicto'];
                $curso['detalles_conflicto'] = $infoHorario['detalles'];
                
                // Determinar estado final
                if (!$validacion['valido']) {
                    $curso['estado'] = 'bloqueado';
                    $curso['motivo'] = 'Falta aprobar prerrequisitos';
                } elseif (!$infoCupos['disponible']) {
                    // Permitir matrícula aunque no haya cupos/programación
                    $curso['estado'] = 'disponible';
                    $curso['motivo'] = 'Sin cupos/programación (permitido)';
                    $curso['puede_matricular'] = true;
                } elseif ($infoHorario['conflicto']) {
                    // Permitir matrícula aun con conflicto de horarios (se muestra aviso)
                    $curso['estado'] = 'disponible';
                    $curso['motivo'] = 'Conflicto de horarios (permitido)';
                    $curso['puede_matricular'] = true;
                } else {
                    $curso['estado'] = 'disponible';
                    $curso['motivo'] = 'Disponible para matrícula';
                }
            }
            
            $cursosDisponibles[] = $curso;
        }
        
        // Calcular créditos disponibles
        $limiteCreditos = 22;
        $creditosDisponibles = $limiteCreditos - $totalCreditosActuales;
        
        return view('estudiantes/matricula/cursos_disponibles', [
            'estudiante' => $estudiante,
            'periodo' => $periodo,
            'cursos' => $cursosDisponibles,
            'creditos_actuales' => $totalCreditosActuales,
            'creditos_disponibles' => $creditosDisponibles,
            'limite_creditos' => $limiteCreditos,
            'ciclo_actual' => $cicloActual,
            'creditos_acumulados' => $creditosAcumulados
        ]);
    }
    
    // Matricularse en un curso con validaciones completas
    public function matricularCurso($cursoId)
    {
        $usuarioId = session('id_usuario');
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);
        
        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }
        
        $periodo = $this->periodoAcademicoModel->getPeriodoProximo() ?? $this->periodoAcademicoModel->getPeriodoActual();
        if (!$periodo) {
            return redirect()->back()->with('error', 'No hay periodo académico disponible.');
        }
        
        // 1. Verificar solicitud aprobada
        $solicitud = $this->solicitudMatriculaModel->getSolicitudPorEstudiante($estudiante['id'], $periodo['id']);
        if (!$solicitud || $solicitud['estado'] !== 'aprobado') {
            return redirect()->back()->with('error', 'No tiene autorización para matricularse. Debe subir su comprobante de pago y esperar aprobación.');
        }
        
        // 2. Validar prerrequisitos
        $validacion = $this->prerrequisitoModel->validarPrerrequisitos($estudiante['id'], $cursoId);
        if (!$validacion['valido']) {
            $pendientes = implode(', ', array_column($validacion['pendientes'], 'nombre'));
            return redirect()->back()->with('error', 'No cumple prerrequisitos: ' . $pendientes . '. Debe aprobar estos cursos primero (nota >= 10.5).');
        }
        
        // 3. Verificar si ya está matriculado (evitar duplicado)
        $yaMatriculado = $this->matriculaModel
            ->where('estudiante_id', $estudiante['id'])
            ->where('curso_id', $cursoId)
            ->where('periodo_id', $periodo['id'])
            ->first();
        if ($yaMatriculado) {
            return redirect()->back()->with('error', 'Ya está matriculado en este curso para este periodo.');
        }
        
        // 4. Verificar cupos disponibles (no bloquea; si no hay cupos, se permite)
        $verificacionCupos = $this->programacionHorariaModel->verificarCuposDisponibles($cursoId, $periodo['id']);
        if (!$verificacionCupos['disponible']) {
            // Continuar igualmente, solo se anexará al mensaje
            $verificacionCupos = array_merge(['cupos_restantes' => 0], $verificacionCupos);
        }
        
        // 5. Verificar conflicto de horarios (no bloquea, solo advierte)
        $verificacionHorario = $this->programacionHorariaModel->verificarConflictoHorario($estudiante['id'], $cursoId, $periodo['id']);
        $conflictoAviso = '';
        if ($verificacionHorario['conflicto']) {
            $conflictoAviso = " (con conflicto de horarios)";
        }
        
        // 6. Verificar límite de créditos (máximo 22 por ciclo)
        $verificacionCreditos = $this->programacionHorariaModel->verificarLimiteCreditos($estudiante['id'], $cursoId, $periodo['id'], 22);
        if (!$verificacionCreditos['permitido']) {
            return redirect()->back()->with('error', $verificacionCreditos['mensaje']);
        }
        
        // 7. Matricular (todas las validaciones pasadas)
        $this->matriculaModel->insert([
            'estudiante_id' => $estudiante['id'],
            'curso_id' => $cursoId,
            'periodo_id' => $periodo['id'],
            'estado' => 'matriculado'
        ]);
        
        // 8. Incrementar contador de matriculados
        $this->programacionHorariaModel->incrementarMatriculados($cursoId, $periodo['id']);
        
        // 9. Obtener nombre del curso para mensaje de éxito
        $curso = $this->cursoModel->find($cursoId);
        $nombreCurso = $curso['nombre'] ?? 'el curso';
        
        return redirect()->to(base_url('estudiantes/matricula/cursos'))->with('success', "✅ Matrícula exitosa en {$nombreCurso}{$conflictoAviso}. Créditos: {$verificacionCreditos['total']}/{$verificacionCreditos['limite']}. Cupos restantes: {$verificacionCupos['cupos_restantes']}.");
    }

    // Ver horario semanal del estudiante (vista)
    public function horario()
    {
        $usuarioId = session('id_usuario');
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }

        $periodo = $this->periodoAcademicoModel->getPeriodoProximo() ?? $this->periodoAcademicoModel->getPeriodoActual();
        if (!$periodo) {
            return redirect()->back()->with('error', 'No hay periodo académico disponible.');
        }

        // Construir horario a partir de matrículas y programación horaria
        $db = \Config\Database::connect();
        $items = $db->table('matriculas m')
            ->select('ph.dia_semana, ph.hora_inicio, ph.hora_fin, ph.aula, c.nombre as curso, c.codigo_curso')
            ->join('programacion_horaria ph', 'ph.curso_id = m.curso_id AND ph.periodo_id = m.periodo_id', 'left')
            ->join('cursos c', 'c.id = m.curso_id', 'left')
            ->where('m.estudiante_id', $estudiante['id'])
            ->where('m.periodo_id', $periodo['id'])
            ->orderBy('ph.dia_semana', 'ASC')
            ->orderBy('ph.hora_inicio', 'ASC')
            ->get()
            ->getResultArray();

        // Agrupar por día de la semana
        $horario = [
            'Lunes' => [], 'Martes' => [], 'Miércoles' => [], 'Jueves' => [], 'Viernes' => [], 'Sábado' => []
        ];
        foreach ($items as $it) {
            $dia = $it['dia_semana'] ?? '';
            if (!isset($horario[$dia])) { $horario[$dia] = []; }
            $horario[$dia][] = $it;
        }

        return view('estudiantes/matricula/horario', [
            'estudiante' => $estudiante,
            'periodo' => $periodo,
            'horario' => $horario,
        ]);
    }

    // Endpoint JSON: obtener cupos actuales de un curso en el periodo (para auto-refresh)
    public function cuposCurso($cursoId)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Solicitud inválida']);
        }

        $usuarioId = session('id_usuario');
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);
        if (!$estudiante) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Estudiante no encontrado']);
        }

        $periodo = $this->periodoAcademicoModel->getPeriodoProximo() ?? $this->periodoAcademicoModel->getPeriodoActual();
        if (!$periodo) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Periodo no disponible']);
        }

        $db = \Config\Database::connect();
        $row = $db->table('programacion_horaria')
            ->select('SUM(cupos) as total_cupos, SUM(matriculados) as matriculados')
            ->where('curso_id', $cursoId)
            ->where('periodo_id', $periodo['id'])
            ->get()
            ->getRowArray();

        $total = (int)($row['total_cupos'] ?? 0);
        $mat = (int)($row['matriculados'] ?? 0);
        $rest = max($total - $mat, 0);
        $porc = $total > 0 ? round(($mat / $total) * 100) : 0;

        $color = 'success';
        if ($porc >= 90) $color = 'danger';
        elseif ($porc >= 70) $color = 'warning';

        return $this->response->setJSON([
            'total_cupos' => $total,
            'matriculados' => $mat,
            'cupos_restantes' => $rest,
            'porcentaje' => $porc,
            'color' => $color,
        ]);
    }

    // Historial académico completo por ciclos
    public function historialAcademico()
    {
        $usuarioId = session('id_usuario');
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }

        $db = \Config\Database::connect();

        // Obtener todos los cursos matriculados con sus calificaciones
        $cursosMatriculados = $db->table('matriculas m')
            ->select('m.*, c.nombre, c.codigo_curso, c.creditos, c.ciclo, cal.nota_final as nota, p.nombre as periodo')
            ->join('cursos c', 'c.id = m.curso_id')
            ->join('periodos_academicos p', 'p.id = m.periodo_id', 'left')
            ->join('calificaciones cal', 'cal.matricula_id = m.id', 'left')
            ->where('m.estudiante_id', $estudiante['id'])
            ->orderBy('c.ciclo', 'ASC')
            ->orderBy('c.codigo_curso', 'ASC')
            ->get()
            ->getResultArray();

        // Organizar por ciclos (del 1 al 10)
        $historial_por_ciclo = [];
        for ($i = 1; $i <= 10; $i++) {
            $historial_por_ciclo[$i] = [
                'cursos' => [],
                'promedio_ciclo' => 0,
                'creditos_ciclo' => 0
            ];
        }

        $totalNotas = 0;
        $contadorNotas = 0;
        $cursosAprobados = 0;
        $cursosDesaprobados = 0;
        $creditosAcumulados = 0;

        foreach ($cursosMatriculados as $curso) {
            $ciclo = $curso['ciclo'] ?? 1;
            
            // Determinar estado del curso
            $estadoCurso = 'pendiente';
            if ($curso['estado'] === 'finalizado') {
                if ($curso['nota'] !== null) {
                    $estadoCurso = $curso['nota'] >= 11 ? 'aprobado' : 'desaprobado';
                    if ($estadoCurso === 'aprobado') {
                        $cursosAprobados++;
                        $creditosAcumulados += $curso['creditos'];
                    } else {
                        $cursosDesaprobados++;
                    }
                    $totalNotas += $curso['nota'];
                    $contadorNotas++;
                }
            } elseif ($curso['estado'] === 'matriculado') {
                $estadoCurso = 'en-curso';
            }

            $curso['estado_curso'] = $estadoCurso;
            
            $historial_por_ciclo[$ciclo]['cursos'][] = $curso;
            $historial_por_ciclo[$ciclo]['creditos_ciclo'] += $curso['creditos'];
        }

        // Calcular promedios por ciclo
        foreach ($historial_por_ciclo as $ciclo => &$data) {
            $notasCiclo = array_filter(array_column($data['cursos'], 'nota'), function($nota) {
                return $nota !== null;
            });
            
            if (!empty($notasCiclo)) {
                $data['promedio_ciclo'] = array_sum($notasCiclo) / count($notasCiclo);
            }
        }

        // Calcular promedio general
        $promedioGeneral = $contadorNotas > 0 ? $totalNotas / $contadorNotas : 0;

        // Estadísticas generales
        $estadisticas = [
            'promedio_general' => $promedioGeneral,
            'cursos_aprobados' => $cursosAprobados,
            'cursos_desaprobados' => $cursosDesaprobados,
            'creditos_acumulados' => $creditosAcumulados
        ];

        // Resumen por ciclo para la tabla
        $resumen_ciclos = [];
        foreach ($historial_por_ciclo as $numCiclo => $data) {
            if (!empty($data['cursos'])) {
                $estado = 'completado';
                foreach ($data['cursos'] as $curso) {
                    if ($curso['estado_curso'] === 'en-curso') {
                        $estado = 'en_curso';
                        break;
                    }
                }
                
                $resumen_ciclos[] = [
                    'ciclo' => $numCiclo,
                    'total_cursos' => count($data['cursos']),
                    'total_creditos' => $data['creditos_ciclo'],
                    'promedio' => $data['promedio_ciclo'],
                    'estado' => $estado
                ];
            }
        }

        return view('estudiantes/historial_academico', [
            'estudiante' => $estudiante,
            'historial_por_ciclo' => $historial_por_ciclo,
            'estadisticas' => $estadisticas,
            'resumen_ciclos' => $resumen_ciclos
        ]);
    }



    /*--------------------------------------------------------
    -----------------------PAGOS Y FACTURACIÓN----------------
    ---------------------------------------------------------*/
    public function pagos()
{
    $usuarioId = session('id_usuario');
    $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

    if (!$estudiante) {
        return redirect()->back()->with('error', 'Estudiante no encontrado.');
    }

    $tramites = $this->tramiteModel
        ->where('estudiante_id', $estudiante['id'])
        ->orderBy('fecha_solicitud', 'DESC')
        ->findAll();

    // Agregar total pagado por trámite
    foreach ($tramites as &$t) {
        $t['total_pagado'] = $this->pagoModel->totalPagadoTramite($t['id']);
    }

    return view('estudiantes/pagos/index', [
        'estudiante' => $estudiante,
        'tramites'   => $tramites
    ]);
}


}
