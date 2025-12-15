<?php

namespace App\Controllers;

use App\Models\DocenteModel;
use App\Models\UsuarioModel;
use App\Models\NotificacionModel;
use App\Models\CursoModel;
use App\Models\CarreraModel;
use App\Models\MatriculaModel;
use App\Models\CalificacionModel;
use App\Models\MaterialModel;
use App\Models\AsistenciaModel;
use App\Models\FormulaCalificacionModel;
use App\Models\HorarioCursoModel;
use CodeIgniter\Controller;

class Docentes extends Controller
{
    protected $docenteModel;
    protected $usuarioModel;
    protected $notificacionModel;
    protected $cursoModel;
    protected $carreraModel;
    protected $session;
    protected $matriculaModel;
    protected $calificacionModel;
    protected $materialModel;
    protected $asistenciaModel;
    protected $formulaModel;
    protected $horarioModel;

    public function __construct()
    {
        $this->docenteModel = new DocenteModel();
        $this->usuarioModel = new UsuarioModel();
        $this->notificacionModel = new NotificacionModel();
        $this->cursoModel = new CursoModel();
        $this->carreraModel = new CarreraModel();
        $this->session = session();
        $this->matriculaModel = new MatriculaModel();
        $this->calificacionModel = new CalificacionModel();
        $this->materialModel = new MaterialModel();
        $this->asistenciaModel = new AsistenciaModel();
        $this->formulaModel = new FormulaCalificacionModel();
        $this->horarioModel = new HorarioCursoModel();
    }

    public function perfil()
    {
        $usuarioId = session('id_usuario');

        $docente = $this->docenteModel->getByUsuarioId($usuarioId);

        return view('docentes/perfil', [
            'docente' => $docente   
        ]);
    }

    public function cursos()
    {
        $usuarioId = session('id_usuario');
        $docente = $this->docenteModel->getByUsuarioId($usuarioId);

        // Obtener cursos del docente con información de carrera y facultad
        $cursos = [];
        if ($docente) {
            $cursos = $this->cursoModel
                ->select('cursos.*, carreras.nombre as carrera_nombre, carreras.facultad_id, facultades.nombre as facultad_nombre')
                ->join('carreras', 'carreras.id = cursos.carrera_id')
                ->join('facultades', 'facultades.id = carreras.facultad_id')
                ->where('cursos.docente_id', $docente['id'])
                ->findAll();
        }

        return view('docentes/cursos', [
            'docente' => $docente,
            'cursos' => $cursos
        ]);
    }

    public function actualizarPerfil()
    {
        $usuarioId = session('id_usuario');
        $docente = $this->docenteModel->getByUsuarioId($usuarioId);

        $datos = $this->request->getPost();

        $this->docenteModel->update($docente['id_docente'], [
            'telefono' => $datos['telefono'],
            'direccion' => $datos['direccion'],
            'especialidad' => $datos['especialidad'],
            'grado_academico' => $datos['grado_academico']
        ]);

        return redirect()->to(base_url('docentes/perfil'))->with('success', 'Perfil actualizado correctamente');
    }

    public function cambiarPassword()
    {
        $usuarioId = session('id_usuario');

        $passwordActual = $this->request->getPost('password_actual');
        $passwordNueva = $this->request->getPost('password_nueva');
        $passwordConfirmar = $this->request->getPost('password_confirmar');

        // Validar que las contraseñas coincidan
        if ($passwordNueva !== $passwordConfirmar) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden');
        }

        // Verificar contraseña actual
        $usuario = $this->usuarioModel->find($usuarioId);
        if (!password_verify($passwordActual, $usuario['password'])) {
            return redirect()->back()->with('error', 'La contraseña actual es incorrecta');
        }

        // Actualizar contraseña
        $this->usuarioModel->update($usuarioId, [
            'password' => password_hash($passwordNueva, PASSWORD_DEFAULT)
        ]);

        return redirect()->to(base_url('docentes/perfil'))->with('success', 'Contraseña actualizada correctamente');
    }

    public function notificaciones()
    {
        $usuarioId = session('id_usuario');
        $docente = $this->docenteModel->getByUsuarioId($usuarioId);

        // Obtener todas las notificaciones del docente
        $notificaciones = $this->notificacionModel
            ->where('usuario_id', $usuarioId)
            ->orderBy('fecha_envio', 'DESC')
            ->findAll();

        return view('docentes/notificaciones', [
            'docente' => $docente,
            'notificaciones' => $notificaciones
        ]);
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

    // Listar todos los docentes
    public function index()
    {
        $data = [
            'title' => 'Docentes',
            'docentes' => $this->docenteModel->obtenerDocentesConUsuario()
        ];

        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('dashboard/docente', $data);  // Ajusta según tu vista
        echo view('layout/footer');
    }

    // Mostrar formulario de creación
    public function create()
    {
        $usuarios = $this->usuarioModel->where('rol_id', 2) // Rol docente
                                       ->findAll();

        $data = [
            'title' => 'Nuevo Docente',
            'usuarios' => $usuarios
        ];

        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('docentes/create', $data);
        echo view('layout/footer');
    }

    // Guardar nuevo docente
    public function store()
    {
        $datos = $this->request->getPost();

        $this->docenteModel->save([
            'usuario_id'   => $datos['usuario_id'],
            'nombres'      => $datos['nombres'],
            'apellidos'    => $datos['apellidos'],
            'dni'          => $datos['dni'],
            'especialidad' => $datos['especialidad'],
            'telefono'     => $datos['telefono'],
            'fecha_ingreso'=> $datos['fecha_ingreso']
        ]);

        $this->session->setFlashdata('msg', 'Docente registrado correctamente.');
        return redirect()->to(base_url('docentes'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $docente = $this->docenteModel->find($id);
        $usuarios = $this->usuarioModel->where('rol_id', 2)->findAll();

        $data = [
            'title' => 'Editar Docente',
            'docente' => $docente,
            'usuarios' => $usuarios
        ];

        echo view('layout/header', $data);
        echo view('layout/sidebar');
        echo view('docentes/edit', $data);
        echo view('layout/footer');
    }

    // Actualizar docente
    public function update($id)
    {
        $datos = $this->request->getPost();

        $this->docenteModel->update($id, [
            'usuario_id'   => $datos['usuario_id'],
            'nombres'      => $datos['nombres'],
            'apellidos'    => $datos['apellidos'],
            'dni'          => $datos['dni'],
            'especialidad' => $datos['especialidad'],
            'telefono'     => $datos['telefono'],
            'fecha_ingreso'=> $datos['fecha_ingreso']
        ]);

        $this->session->setFlashdata('msg', 'Docente actualizado correctamente.');
        return redirect()->to(base_url('docentes'));
    }

    // Eliminar docente
    public function delete($id)
    {
        $this->docenteModel->delete($id);
        $this->session->setFlashdata('msg', 'Docente eliminado correctamente.');
        return redirect()->to(base_url('docentes'));
    }

    // Ver horarios de FIIS
    public function facultadFiis()
    {
        $usuarioId = session('id_usuario');
        $docente = $this->docenteModel->getByUsuarioId($usuarioId);

        // Obtener programación horaria de FIIS/Sistemas (facultad_id = 1, carrera_id = 1) usando tabla programacion_horaria
        $db = \Config\Database::connect();
        $horarios = $db->table('programacion_horaria ph')
            ->select('ph.*, cursos.nombre as curso_nombre, cursos.codigo_curso, carreras.nombre as carrera_nombre, CONCAT(d.nombres, " ", d.apellidos) as docente_nombre')
            ->join('cursos', 'cursos.id = ph.curso_id')
            ->join('carreras', 'carreras.id = cursos.carrera_id')
            ->join('docentes d', 'd.id = ph.docente_id', 'left')
            ->where('carreras.facultad_id', 1) // FIIS
            ->where('carreras.id', 1) // Ingeniería de Sistemas
            ->where('ph.activo', 1)
            ->orderBy('ph.dia_semana', 'ASC')
            ->orderBy('ph.hora_inicio', 'ASC')
            ->get()
            ->getResultArray();

        // Carreras de FIIS (para filtros si se amplía luego)
        $carreras = $this->carreraModel->getCarrerasPorFacultad(1);

        return view('docentes/fiis_horarios', [
            'docente' => $docente,
            'horarios' => $horarios,
            'carreras' => $carreras
        ]);
    }

    // Área personal FIIS: selector de escuelas
    public function fiisPersonal()
    {
        $usuarioId = session('id_usuario');
        $docente = $this->docenteModel->getByUsuarioId($usuarioId);
        return view('docentes/fiis/personal', [ 'docente' => $docente ]);
    }

    // Sistemas: listar cursos del docente en FIIS - Ingeniería de Sistemas (carrera_id = 1)
    public function fiisSistemasCursos()
    {
        $usuarioId = session('id_usuario');
        $docente = $this->docenteModel->getByUsuarioId($usuarioId);
        $cursos = [];
        if ($docente) {
            $cursos = $this->cursoModel
                ->select('cursos.*, carreras.nombre as carrera_nombre')
                ->join('carreras', 'carreras.id = cursos.carrera_id')
                ->where('carreras.facultad_id', 1)
                ->where('carreras.id', 1) // Ingeniería de Sistemas
                ->where('cursos.docente_id', $docente['id'])
                ->findAll();
        }
        return view('docentes/fiis/sistemas_cursos', [ 'docente' => $docente, 'cursos' => $cursos ]);
    }

    // Sistemas: estudiantes matriculados por curso
    public function fiisSistemasEstudiantes($cursoId)
    {
        $usuarioId = session('id_usuario');
        $docente = $this->docenteModel->getByUsuarioId($usuarioId);
        // Validar propiedad del curso
        $curso = $this->cursoModel->find($cursoId);
        if (!$curso || $curso['docente_id'] != $docente['id']) {
            return redirect()->to(base_url('docentes/facultad/fiis/sistemas/cursos'))->with('error', 'No autorizado.');
        }
        $matriculados = $this->matriculaModel->getMatriculasPorCurso($cursoId);
        return view('docentes/fiis/estudiantes', [ 'docente' => $docente, 'curso' => $curso, 'matriculados' => $matriculados ]);
    }

    // ========== GESTIÓN DE MATERIALES ==========
    
    /**
     * Listar y subir materiales de un curso
     */
    public function fiisSistemasMateriales($cursoId)
    {
        $usuarioId = session('id_usuario');
        $docente = $this->docenteModel->getByUsuarioId($usuarioId);
        $curso = $this->cursoModel->find($cursoId);
        
        error_log("=== fiisSistemasMateriales START ===");
        error_log("Usuario ID: " . $usuarioId);
        error_log("Docente: " . json_encode($docente));
        error_log("Curso: " . json_encode($curso));
        
        if (!$curso || $curso['docente_id'] != $docente['id']) {
            error_log("ERROR: No autorizado");
            return redirect()->to(base_url('docentes/facultad/fiis/sistemas/cursos'))->with('error', 'No autorizado.');
        }

        // Procesar subida de material
        if ($this->request->getMethod() === 'post') {
            error_log("POST detectado");
            try {
                $titulo = trim($this->request->getPost('titulo'));
                $descripcion = trim($this->request->getPost('descripcion'));
                $file = $this->request->getFile('archivo');
                
                error_log('MATERIAL: Título: ' . $titulo);
                error_log('MATERIAL: Descripción: ' . $descripcion);
                error_log('MATERIAL: File: ' . json_encode($file ? ['name' => $file->getName(), 'valid' => $file->isValid()] : 'null'));
                
                // Validaciones
                if (empty($titulo)) {
                    error_log("ERROR: Título vacío");
                    return redirect()->back()->with('error', 'El título es obligatorio.');
                }
                
                if (!$file || !$file->isValid()) {
                    $error = $file ? $file->getErrorString() : 'Archivo no recibido';
                    error_log('MATERIAL ERROR: ' . $error);
                    return redirect()->back()->with('error', 'Archivo inválido: ' . $error);
                }
                
                // Validar tipo de archivo
                $extension = $file->getExtension();
                $permitidos = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'gif', 'zip', 'rar'];
                
                if (!in_array(strtolower($extension), $permitidos)) {
                    error_log("ERROR: Extensión no permitida: " . $extension);
                    return redirect()->back()->with('error', 'Tipo de archivo no permitido. Extensión: ' . $extension);
                }
                
                // Validar tamaño (máximo 10MB)
                if ($file->getSize() > 10 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'El archivo no debe superar los 10MB.');
                }
                
                $uploadDir = FCPATH . 'uploads/materiales';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                    error_log("Directorio creado: " . $uploadDir);
                }
                
                $newName = $file->getRandomName();
                error_log('MATERIAL: Nuevo nombre: ' . $newName);
                error_log('MATERIAL: Ruta completa: ' . $uploadDir . '/' . $newName);
                
                if ($file->move($uploadDir, $newName)) {
                    error_log('MATERIAL: Archivo movido exitosamente');
                    
                    // Guardar en base de datos
                    $data = [
                        'curso_id' => (int)$cursoId,
                        'docente_id' => (int)$docente['id'],
                        'titulo' => $titulo,
                        'descripcion' => $descripcion,
                        'archivo' => $newName
                    ];
                    
                    error_log('MATERIAL: Datos a insertar: ' . json_encode($data));
                    
                    $db = \Config\Database::connect();
                    $builder = $db->table('materiales');
                    
                    if ($builder->insert($data)) {
                        $insertId = $db->insertID();
                        error_log('MATERIAL: ✓ INSERT exitoso. ID: ' . $insertId);
                        return redirect()->to(current_url())->with('success', 'Material subido correctamente. ID: ' . $insertId);
                    } else {
                        @unlink($uploadDir . '/' . $newName);
                        error_log('MATERIAL ERROR BD: ' . json_encode($db->error()));
                        return redirect()->back()->with('error', 'Error al guardar en base de datos: ' . json_encode($db->error()));
                    }
                } else {
                    error_log('MATERIAL ERROR: No se pudo mover el archivo');
                    return redirect()->back()->with('error', 'Error al mover el archivo.');
                }
            } catch (\Exception $e) {
                error_log('MATERIAL EXCEPTION: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }

        // Listar materiales
        $db = \Config\Database::connect();
        $materiales = $db->table('materiales')
                        ->select('materiales.*, docentes.nombres, docentes.apellidos')
                        ->join('docentes', 'docentes.id = materiales.docente_id', 'left')
                        ->where('materiales.curso_id', $cursoId)
                        ->orderBy('materiales.fecha_subida', 'DESC')
                        ->get()
                        ->getResultArray();
        
        error_log('MATERIAL: Materiales encontrados: ' . count($materiales));
        error_log("=== fiisSistemasMateriales END ===");
        
        return view('docentes/fiis/materiales', [
            'docente' => $docente,
            'curso' => $curso,
            'materiales' => $materiales
        ]);
    }

    /**
     * Descargar material
     */
    public function descargarMaterial($id)
    {
        $material = $this->materialModel->find($id);
        
        if (!$material) {
            return redirect()->back()->with('error', 'Material no encontrado.');
        }
        
        $path = FCPATH . 'uploads/materiales/' . $material['archivo'];
        
        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Archivo no disponible.');
        }
        
        return $this->response->download($path, null)->setFileName($material['titulo'] . '.' . pathinfo($material['archivo'], PATHINFO_EXTENSION));
    }

    /**
     * Eliminar material
     */
    public function eliminarMaterial($id)
    {
        $usuarioId = session('id_usuario');
        $docente = $this->docenteModel->getByUsuarioId($usuarioId);
        $material = $this->materialModel->find($id);
        
        if (!$material) {
            return redirect()->back()->with('error', 'Material no encontrado.');
        }
        
        // Verificar que el material pertenece al docente
        if ($material['docente_id'] != $docente['id']) {
            return redirect()->back()->with('error', 'No autorizado.');
        }
        
        if ($this->materialModel->eliminarMaterial($id)) {
            return redirect()->back()->with('success', 'Material eliminado correctamente.');
        }
        
        return redirect()->back()->with('error', 'Error al eliminar el material.');
    }

    // ========== GESTIÓN DE CALIFICACIONES ==========
    
    /**
     * Gestionar calificaciones de un curso
     */
    public function fiisSistemasCalificaciones($cursoId)
    {
        $usuarioId = session('id_usuario');
        $docente = $this->docenteModel->getByUsuarioId($usuarioId);
        $curso = $this->cursoModel->find($cursoId);
        
        if (!$curso || $curso['docente_id'] != $docente['id']) {
            return redirect()->to(base_url('docentes/facultad/fiis/sistemas/cursos'))->with('error', 'No autorizado.');
        }

        $db = \Config\Database::connect();

        // Obtener o crear fórmula de calificación
        $formulas = $db->table('formulas_calificacion')
                      ->where('curso_id', $cursoId)
                      ->where('activo', 1)
                      ->orderBy('orden', 'ASC')
                      ->get()
                      ->getResultArray();
        
        if (empty($formulas)) {
            // Crear fórmula por defecto
            $formulasDefault = [
                ['curso_id' => $cursoId, 'nombre_componente' => 'Prácticas Calificadas (PC)', 'porcentaje' => 30.00, 'orden' => 1, 'activo' => 1],
                ['curso_id' => $cursoId, 'nombre_componente' => 'Examen Parcial (EP)', 'porcentaje' => 30.00, 'orden' => 2, 'activo' => 1],
                ['curso_id' => $cursoId, 'nombre_componente' => 'Examen Final (EF)', 'porcentaje' => 40.00, 'orden' => 3, 'activo' => 1],
            ];
            $db->table('formulas_calificacion')->insertBatch($formulasDefault);
            $formulas = $db->table('formulas_calificacion')
                          ->where('curso_id', $cursoId)
                          ->where('activo', 1)
                          ->orderBy('orden', 'ASC')
                          ->get()
                          ->getResultArray();
        }

        // Guardar calificaciones
        if ($this->request->getMethod() === 'post' && $this->request->getPost('guardar_notas')) {
            error_log("=== GUARDAR CALIFICACIONES START ===");
            try {
                $matriculas = $this->request->getPost('matriculas');
                error_log("Matriculas POST: " . json_encode($matriculas));
                
                $guardadas = 0;
                
                if (is_array($matriculas)) {
                    foreach ($matriculas as $matriculaId => $datos) {
                        error_log("Procesando matrícula $matriculaId: " . json_encode($datos));
                        
                        $datosCalificacion = ['matricula_id' => (int)$matriculaId];
                        $hayNotas = false;
                        $notaFinal = 0;
                        
                        // Procesar componentes
                        foreach ($formulas as $index => $formula) {
                            $componenteKey = 'componente' . ($index + 1);
                            if (isset($datos[$componenteKey]) && $datos[$componenteKey] !== '') {
                                $nota = floatval($datos[$componenteKey]);
                                $datosCalificacion[$componenteKey] = $nota;
                                $notaFinal += ($nota * floatval($formula['porcentaje'])) / 100;
                                $hayNotas = true;
                                error_log("  $componenteKey = $nota");
                            } else {
                                $datosCalificacion[$componenteKey] = null;
                            }
                        }
                        
                        if ($hayNotas) {
                            $datosCalificacion['nota_final'] = round($notaFinal, 2);
                            $datosCalificacion['fecha_actualizacion'] = date('Y-m-d H:i:s');
                            
                            error_log("Datos a guardar: " . json_encode($datosCalificacion));
                            
                            // Verificar si existe
                            $existe = $db->table('calificaciones')
                                        ->where('matricula_id', $matriculaId)
                                        ->get()
                                        ->getRowArray();
                            
                            if ($existe) {
                                $result = $db->table('calificaciones')
                                  ->where('matricula_id', $matriculaId)
                                  ->update($datosCalificacion);
                                error_log('✓ CALIFICACIÓN ACTUALIZADA (matrícula: ' . $matriculaId . ', resultado: ' . ($result ? 'OK' : 'FAIL') . ')');
                            } else {
                                $result = $db->table('calificaciones')->insert($datosCalificacion);
                                error_log('✓ CALIFICACIÓN INSERTADA (matrícula: ' . $matriculaId . ', resultado: ' . ($result ? 'OK' : 'FAIL') . ')');
                            }
                            $guardadas++;
                        }
                    }
                }
                
                error_log("=== GUARDAR CALIFICACIONES END - Guardadas: $guardadas ===");
                return redirect()->to(current_url())->with('success', "Calificaciones guardadas correctamente: {$guardadas} estudiantes.");
            } catch (\Exception $e) {
                error_log('✗ ERROR al guardar calificaciones: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }

        // Actualizar fórmula
        if ($this->request->getMethod() === 'post' && $this->request->getPost('actualizar_formula')) {
            try {
                $nuevasFormulas = $this->request->getPost('formulas');
                
                // Validar que sumen 100%
                $totalPorcentaje = 0;
                foreach ($nuevasFormulas as $formula) {
                    if (!empty($formula['porcentaje'])) {
                        $totalPorcentaje += floatval($formula['porcentaje']);
                    }
                }
                
                if (abs($totalPorcentaje - 100) > 0.01) {
                    return redirect()->back()->with('error', 'Los porcentajes deben sumar 100%. Total actual: ' . $totalPorcentaje . '%');
                }
                
                // Desactivar fórmulas existentes
                $db->table('formulas_calificacion')
                  ->where('curso_id', $cursoId)
                  ->update(['activo' => 0]);
                
                // Insertar nuevas fórmulas
                $orden = 1;
                foreach ($nuevasFormulas as $formula) {
                    if (!empty($formula['nombre']) && !empty($formula['porcentaje'])) {
                        $db->table('formulas_calificacion')->insert([
                            'curso_id' => $cursoId,
                            'nombre_componente' => $formula['nombre'],
                            'porcentaje' => floatval($formula['porcentaje']),
                            'orden' => $orden++,
                            'activo' => 1
                        ]);
                    }
                }
                
                return redirect()->to(current_url())->with('success', 'Fórmula de calificación actualizada correctamente.');
            } catch (\Exception $e) {
                log_message('error', 'Error al actualizar fórmula: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }

        // Obtener matriculados con sus calificaciones
        $matriculados = $db->table('matriculas m')
                          ->select('m.*, e.codigo_estudiante, e.nombres, e.apellidos, e.id as estudiante_id,
                                   c.id as calificacion_id, c.componente1, c.componente2, c.componente3, 
                                   c.componente4, c.componente5, c.nota_final, c.observaciones')
                          ->join('estudiantes e', 'e.id = m.estudiante_id')
                          ->join('calificaciones c', 'c.matricula_id = m.id', 'left')
                          ->where('m.curso_id', $cursoId)
                          ->orderBy('e.apellidos', 'ASC')
                          ->get()
                          ->getResultArray();
        
        // Calcular estadísticas
        $notasFinales = array_filter(array_column($matriculados, 'nota_final'), function($nota) {
            return $nota !== null && $nota !== '';
        });
        
        $estadisticas = [
            'total' => count($matriculados),
            'promedio' => !empty($notasFinales) ? round(array_sum($notasFinales) / count($notasFinales), 2) : 0,
            'maxima' => !empty($notasFinales) ? max($notasFinales) : 0,
            'minima' => !empty($notasFinales) ? min($notasFinales) : 0,
            'aprobados' => count(array_filter($notasFinales, fn($n) => $n >= 10.5)),
            'desaprobados' => count(array_filter($notasFinales, fn($n) => $n < 10.5))
        ];
        
        return view('docentes/fiis/calificaciones', [
            'docente' => $docente,
            'curso' => $curso,
            'matriculados' => $matriculados,
            'formulas' => $formulas,
            'estadisticas' => $estadisticas
        ]);
    }

    // ========== GESTIÓN DE ASISTENCIAS ==========
    
    /**
     * Registrar y ver asistencias de un curso
     */
    public function fiisSistemasAsistencia($cursoId)
    {
        $usuarioId = session('id_usuario');
        $docente = $this->docenteModel->getByUsuarioId($usuarioId);
        $curso = $this->cursoModel->find($cursoId);
        
        if (!$curso || $curso['docente_id'] != $docente['id']) {
            return redirect()->to(base_url('docentes/facultad/fiis/sistemas/cursos'))->with('error', 'No autorizado.');
        }

        $db = \Config\Database::connect();
        
        // Obtener fecha seleccionada o usar la actual
        $fechaSeleccionada = $this->request->getGetPost('fecha') ?: date('Y-m-d');
        
        // Obtener horarios del curso
        $horarios = $db->table('horarios_curso')
                      ->where('curso_id', $cursoId)
                      ->where('activo', 1)
                      ->orderBy('dia_semana', 'ASC')
                      ->get()
                      ->getResultArray();
        
        // Generar fechas de clases basadas en horarios
        $fechasClases = [];
        $diasSemana = ['', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        
        if (!empty($horarios)) {
            $fechaInicio = date('Y-m-01'); // Inicio del mes
            $fechaFin = date('Y-m-d', strtotime('+4 months')); // 4 meses adelante
            
            foreach ($horarios as $horario) {
                $diaSemana = (int)$horario['dia_semana'];
                $current = strtotime($fechaInicio);
                $end = strtotime($fechaFin);
                
                // Ajustar al primer día correcto
                $currentDayOfWeek = (int)date('N', $current);
                if ($currentDayOfWeek != $diaSemana) {
                    $daysToAdd = ($diaSemana - $currentDayOfWeek + 7) % 7;
                    $current = strtotime("+{$daysToAdd} days", $current);
                }
                
                // Generar fechas
                while ($current <= $end) {
                    $fechasClases[] = [
                        'fecha' => date('Y-m-d', $current),
                        'dia_nombre' => $diasSemana[$diaSemana],
                        'hora_inicio' => $horario['hora_inicio'],
                        'hora_fin' => $horario['hora_fin']
                    ];
                    $current = strtotime('+1 week', $current);
                }
            }
            
            // Ordenar fechas
            usort($fechasClases, function($a, $b) {
                return strcmp($a['fecha'], $b['fecha']);
            });
        }
        
        // Verificar si la fecha seleccionada es día de clase
        $esDiaDeClase = false;
        foreach ($fechasClases as $fc) {
            if ($fc['fecha'] === $fechaSeleccionada) {
                $esDiaDeClase = true;
                break;
            }
        }
        
        // Guardar asistencia
        if ($this->request->getMethod() === 'post' && $this->request->getPost('asistencia')) {
            error_log("=== GUARDAR ASISTENCIA START ===");
            try {
                $asistencias = $this->request->getPost('asistencia');
                error_log("Asistencias POST: " . json_encode($asistencias));
                error_log("Fecha: " . $fechaSeleccionada);
                
                $guardadas = 0;
                
                foreach ($asistencias as $matriculaId => $estado) {
                    $estado = trim((string)$estado);
                    
                    // Validar estado
                    if (!in_array($estado, ['Asistió', 'Tardanza', 'Falta', 'Justificado'])) {
                        $estado = 'Falta';
                    }
                    
                    error_log("Procesando matrícula $matriculaId: estado = $estado");
                    
                    // Verificar si existe
                    $existe = $db->table('asistencias')
                                ->where('matricula_id', $matriculaId)
                                ->where('fecha', $fechaSeleccionada)
                                ->get()
                                ->getRowArray();
                    
                    $datos = [
                        'estado' => $estado,
                        'hora_registro' => date('H:i:s'),
                        'registrado_por' => $usuarioId
                    ];
                    
                    if ($existe) {
                        $result = $db->table('asistencias')
                          ->where('matricula_id', $matriculaId)
                          ->where('fecha', $fechaSeleccionada)
                          ->update($datos);
                        error_log('✓ ASISTENCIA ACTUALIZADA (matrícula: ' . $matriculaId . ', resultado: ' . ($result ? 'OK' : 'FAIL') . ')');
                    } else {
                        $datos['matricula_id'] = $matriculaId;
                        $datos['fecha'] = $fechaSeleccionada;
                        $result = $db->table('asistencias')->insert($datos);
                        error_log('✓ ASISTENCIA INSERTADA (matrícula: ' . $matriculaId . ', resultado: ' . ($result ? 'OK' : 'FAIL') . ')');
                    }
                    $guardadas++;
                }
                
                error_log("=== GUARDAR ASISTENCIA END - Guardadas: $guardadas ===");
                return redirect()->to(current_url() . '?fecha=' . $fechaSeleccionada)
                               ->with('success', "Asistencia guardada correctamente: {$guardadas} estudiantes.");
            } catch (\Exception $e) {
                error_log('✗ ERROR al guardar asistencia: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }

        // Obtener matriculados
        $matriculados = $db->table('matriculas m')
                          ->select('m.*, e.codigo_estudiante, e.nombres, e.apellidos, e.id as estudiante_id')
                          ->join('estudiantes e', 'e.id = m.estudiante_id')
                          ->where('m.curso_id', $cursoId)
                          ->orderBy('e.apellidos', 'ASC')
                          ->get()
                          ->getResultArray();
        
        // Obtener asistencias existentes para la fecha
        $asistenciasExistentes = $db->table('asistencias a')
                                   ->select('a.*, m.id as matricula_id')
                                   ->join('matriculas m', 'm.id = a.matricula_id')
                                   ->where('m.curso_id', $cursoId)
                                   ->where('a.fecha', $fechaSeleccionada)
                                   ->get()
                                   ->getResultArray();
        
        $mapaAsistencias = [];
        foreach ($asistenciasExistentes as $asist) {
            $mapaAsistencias[$asist['matricula_id']] = $asist['estado'];
        }
        
        // Agregar asistencia y resumen a cada matriculado
        foreach ($matriculados as &$matricula) {
            $matricula['asistencia'] = $mapaAsistencias[$matricula['id']] ?? 'Falta';
            
            // Obtener resumen de asistencias del estudiante
            $resumenQuery = $db->query("
                SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN estado = 'Asistió' THEN 1 ELSE 0 END) as asistio,
                    SUM(CASE WHEN estado = 'Tardanza' THEN 1 ELSE 0 END) as tardanza,
                    SUM(CASE WHEN estado = 'Falta' THEN 1 ELSE 0 END) as falta,
                    SUM(CASE WHEN estado = 'Justificado' THEN 1 ELSE 0 END) as justificado
                FROM asistencias
                WHERE matricula_id = ?
            ", [$matricula['id']]);
            
            $resumen = $resumenQuery->getRowArray();
            $total = max(1, (int)$resumen['total']);
            $matricula['resumen_asistencia'] = [
                'total' => (int)$resumen['total'],
                'asistio' => (int)$resumen['asistio'],
                'tardanza' => (int)$resumen['tardanza'],
                'falta' => (int)$resumen['falta'],
                'justificado' => (int)$resumen['justificado'],
                'porcentaje_asistencia' => round((((int)$resumen['asistio'] + (int)$resumen['tardanza']) / $total) * 100, 1)
            ];
        }
        
        // Obtener resumen del curso para la fecha
        $resumenCurso = $db->query("
            SELECT 
                COUNT(CASE WHEN a.estado = 'Asistió' THEN 1 END) as asistio,
                COUNT(CASE WHEN a.estado = 'Tardanza' THEN 1 END) as tardanza,
                COUNT(CASE WHEN a.estado = 'Falta' THEN 1 END) as falta,
                COUNT(CASE WHEN a.estado = 'Justificado' THEN 1 END) as justificado
            FROM asistencias a
            JOIN matriculas m ON m.id = a.matricula_id
            WHERE m.curso_id = ? AND a.fecha = ?
        ", [$cursoId, $fechaSeleccionada])->getRowArray();
        
        $totalMatriculados = count($matriculados);
        $resumenGeneral = [
            'total' => $totalMatriculados,
            'asistio' => (int)$resumenCurso['asistio'],
            'tardanza' => (int)$resumenCurso['tardanza'],
            'falta' => (int)$resumenCurso['falta'],
            'justificado' => (int)$resumenCurso['justificado'],
            'porcentaje' => $totalMatriculados > 0 ? round((((int)$resumenCurso['asistio'] + (int)$resumenCurso['tardanza']) / $totalMatriculados) * 100, 1) : 0,
        ];
        
        // Obtener fechas con asistencia registrada
        $fechasRegistradas = $db->query("
            SELECT DISTINCT a.fecha 
            FROM asistencias a
            JOIN matriculas m ON m.id = a.matricula_id
            WHERE m.curso_id = ?
            ORDER BY a.fecha DESC
        ", [$cursoId])->getResultArray();
        
        $fechasRegistradas = array_column($fechasRegistradas, 'fecha');
        
        return view('docentes/fiis/asistencia', [
            'docente' => $docente,
            'curso' => $curso,
            'matriculados' => $matriculados,
            'fecha_seleccionada' => $fechaSeleccionada,
            'resumen_general' => $resumenGeneral,
            'horarios' => $horarios,
            'fechas_clases' => $fechasClases,
            'es_dia_de_clase' => $esDiaDeClase,
            'fechas_registradas' => $fechasRegistradas
        ]);
    }
}
