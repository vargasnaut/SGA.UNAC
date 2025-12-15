<?php   
namespace App\Controllers;
use App\Models\AdministrativoModel;
use App\Models\UsuarioModel;
use App\Models\EstudianteModel;
use App\Models\DocenteModel;
use App\Models\CursoModel;
use App\Models\MatriculaModel;
use App\Models\SolicitudMatriculaModel;
use App\Models\PeriodoAcademicoModel;
use App\Models\TramiteModel;
use App\Models\NotificacionModel;

class Administradores extends BaseController
{
    protected $adminModel;
    protected $usuarioModel;
    protected $estudianteModel;
    protected $docenteModel;
    protected $cursoModel;
    protected $matriculaModel;
    protected $solicitudMatriculaModel;
    protected $periodoModel;
    protected $tramiteModel;
    protected $notificacionModel;

    public function __construct()
    {
        $this->adminModel = new AdministrativoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->estudianteModel = new EstudianteModel();
        $this->docenteModel = new DocenteModel();
        $this->cursoModel = new CursoModel();
        $this->matriculaModel = new MatriculaModel();
        $this->solicitudMatriculaModel = new SolicitudMatriculaModel();
        $this->periodoModel = new PeriodoAcademicoModel();
        $this->tramiteModel = new TramiteModel();
        $this->notificacionModel = new NotificacionModel();
    }

    // =========================================
    // DASHBOARD ADMINISTRADOR
    // =========================================
    
    public function dashboard()
    {
        // Estadísticas generales
        $data['total_estudiantes'] = $this->estudianteModel->countAll();
        $data['total_docentes'] = $this->docenteModel->countAll();
        $data['total_cursos'] = $this->cursoModel->countAll();
        // Total administrativos
        $data['total_administrativos'] = $this->adminModel->countAll();
        
        // Solicitudes de matrícula pendientes
        $data['solicitudes_pendientes'] = $this->solicitudMatriculaModel
            ->where('estado', 'pendiente')
            ->countAllResults();
        
        // Trámites pendientes
        $data['tramites_pendientes'] = $this->tramiteModel
            ->where('estado', 'pendiente')
            ->countAllResults();
        
        // Últimas solicitudes de matrícula (5 más recientes)
        $data['ultimas_solicitudes'] = $this->solicitudMatriculaModel
            ->select('solicitudes_matricula.*, estudiantes.nombres, estudiantes.apellidos, estudiantes.codigo_estudiante, periodos_academicos.nombre as periodo_nombre')
            ->join('estudiantes', 'estudiantes.id = solicitudes_matricula.estudiante_id')
            ->join('periodos_academicos', 'periodos_academicos.id = solicitudes_matricula.periodo_id')
            ->orderBy('solicitudes_matricula.fecha_solicitud', 'DESC')
            ->limit(5)
            ->findAll();
        
        // Estadísticas de matrícula por periodo actual
        $periodoActual = $this->periodoModel->orderBy('fecha_inicio', 'DESC')->first();
        if ($periodoActual) {
            $data['matriculas_periodo'] = $this->matriculaModel
                ->where('periodo_id', $periodoActual['id'])
                ->countAllResults();
        } else {
            $data['matriculas_periodo'] = 0;
        }
        
        $data['periodo_actual'] = $periodoActual;
        
        return view('administradores/dashboard', $data);
    }

    // =========================================
    // LISTADO DE DOCENTES (ADMIN)
    // =========================================
    public function listarDocentes()
    {
        $pagina = (int) ($this->request->getGet('page') ?? 1);
        $porPagina = 15;
        $busqueda = trim($this->request->getGet('q') ?? '');

        $builder = $this->docenteModel->select('docentes.*, (
            SELECT COUNT(*) FROM cursos c WHERE c.docente_id = docentes.id
        ) AS total_cursos');

        if ($busqueda !== '') {
            $builder->groupStart()
                ->like('docentes.nombres', $busqueda)
                ->orLike('docentes.apellidos', $busqueda)
                ->orLike('docentes.dni', $busqueda)
            ->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $docentes = $builder->orderBy('docentes.apellidos', 'ASC')
            ->limit($porPagina, ($pagina - 1) * $porPagina)
            ->get()->getResultArray();

        $data = [
            'docentes' => $docentes,
            'pagina' => $pagina,
            'porPagina' => $porPagina,
            'total' => $total,
            'busqueda' => $busqueda,
            'totalPaginas' => $porPagina > 0 ? (int) ceil($total / $porPagina) : 1
        ];

        return view('administradores/docentes/index', $data);
    }

    public function nuevoDocente()
    {
        return view('administradores/docentes/form');
    }

    public function guardarDocente()
    {
        $datos = $this->request->getPost();

        // Validaciones de unicidad
        if ($this->usuarioModel->where('username', $datos['username'])->first()) {
            return redirect()->back()->withInput()->with('error', 'El nombre de usuario ya existe');
        }
        if ($this->usuarioModel->where('email', $datos['email'])->first()) {
            return redirect()->back()->withInput()->with('error', 'El email ya está registrado');
        }
        if ($this->docenteModel->where('dni', $datos['dni'])->first()) {
            return redirect()->back()->withInput()->with('error', 'El DNI ya pertenece a otro docente');
        }

        // Crear usuario
        $usuarioId = $this->usuarioModel->insert([
            'username' => $datos['username'],
            'password' => password_hash($datos['password'], PASSWORD_DEFAULT),
            'email' => $datos['email'],
            'rol_id' => 2, // Docente
            'estado' => 'activo',
            'fecha_registro' => date('Y-m-d H:i:s')
        ]);

        // Crear registro docente
        $this->docenteModel->insert([
            'usuario_id' => $usuarioId,
            'nombres' => $datos['nombres'],
            'apellidos' => $datos['apellidos'],
            'dni' => $datos['dni'],
            'especialidad' => $datos['especialidad'] ?? '',
            'telefono' => $datos['telefono'] ?? '',
            'fecha_ingreso' => date('Y-m-d')
        ]);

        return redirect()->to(base_url('administradores/docentes'))
            ->with('success', 'Docente creado correctamente');
    }

    public function editarDocente($id)
    {
        $docente = $this->docenteModel->find($id);
        if (!$docente) {
            return redirect()->back()->with('error', 'Docente no encontrado');
        }
        $usuario = $this->usuarioModel->find($docente['usuario_id']);
        return view('administradores/docentes/edit', ['docente' => $docente, 'usuario' => $usuario]);
    }

    public function actualizarDocente($id)
    {
        $docente = $this->docenteModel->find($id);
        if (!$docente) {
            return redirect()->back()->with('error', 'Docente no encontrado');
        }
        $datos = $this->request->getPost();
        // Validaciones de unicidad en actualización (ignorar el propio registro)
        $existeEmail = $this->usuarioModel
            ->where('email', $datos['email'])
            ->where('id !=', $docente['usuario_id'])
            ->first();
        if ($existeEmail) {
            return redirect()->back()->withInput()->with('error', 'El email ya está en uso por otro usuario');
        }
        $existeDni = $this->docenteModel
            ->where('dni', $datos['dni'])
            ->where('id !=', $id)
            ->first();
        if ($existeDni) {
            return redirect()->back()->withInput()->with('error', 'El DNI ya está registrado en otro docente');
        }
        // Actualizar usuario
        $usuarioData = [
            'email' => $datos['email']
        ];
        if (!empty($datos['password'])) {
            $usuarioData['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
        }
        $this->usuarioModel->update($docente['usuario_id'], $usuarioData);
        // Actualizar docente
        $this->docenteModel->update($id, [
            'nombres' => $datos['nombres'],
            'apellidos' => $datos['apellidos'],
            'dni' => $datos['dni'],
            'especialidad' => $datos['especialidad'] ?? '',
            'telefono' => $datos['telefono'] ?? ''
        ]);
        return redirect()->to(base_url('administradores/docentes'))
            ->with('success', 'Docente actualizado');
    }

    public function eliminarDocente($id)
    {
        $docente = $this->docenteModel->find($id);
        if ($docente) {
            // Eliminar primero cursos asignados opcionalmente (o prevenir si existen)
            // $this->cursoModel->where('docente_id', $id)->set(['docente_id' => null])->update();
            $this->docenteModel->delete($id);
            $this->usuarioModel->delete($docente['usuario_id']);
        }
        return redirect()->to(base_url('administradores/docentes'))
            ->with('success', 'Docente eliminado');
    }

    // =========================================
    // LISTADO DE ADMINISTRATIVOS (ADMIN)
    // =========================================
    public function listarAdministrativos()
    {
        $pagina = (int) ($this->request->getGet('page') ?? 1);
        $porPagina = 15;
        $busqueda = trim($this->request->getGet('q') ?? '');

        $builder = $this->adminModel->select('administrativos.*');
        if ($busqueda !== '') {
            $builder->groupStart()
                ->like('administrativos.nombres', $busqueda)
                ->orLike('administrativos.apellidos', $busqueda)
                ->orLike('administrativos.dni', $busqueda)
            ->groupEnd();
        }
        $total = $builder->countAllResults(false);
        $administrativos = $builder->orderBy('administrativos.apellidos', 'ASC')
            ->limit($porPagina, ($pagina - 1) * $porPagina)
            ->get()->getResultArray();

        $data = [
            'administrativos' => $administrativos,
            'pagina' => $pagina,
            'porPagina' => $porPagina,
            'total' => $total,
            'busqueda' => $busqueda,
            'totalPaginas' => $porPagina > 0 ? (int) ceil($total / $porPagina) : 1
        ];
        return view('administradores/administrativos/index', $data);
    }

    public function nuevoAdministrativo()
    {
        return view('administradores/administrativos/form');
    }

    public function guardarAdministrativo()
    {
        $datos = $this->request->getPost();
        // Validaciones de unicidad
        if ($this->usuarioModel->where('username', $datos['username'])->first()) {
            return redirect()->back()->withInput()->with('error', 'El nombre de usuario ya existe');
        }
        if ($this->usuarioModel->where('email', $datos['email'])->first()) {
            return redirect()->back()->withInput()->with('error', 'El email ya está registrado');
        }
        if ($this->adminModel->where('dni', $datos['dni'])->first()) {
            return redirect()->back()->withInput()->with('error', 'El DNI ya pertenece a otro administrativo');
        }
        $usuarioId = $this->usuarioModel->insert([
            'username' => $datos['username'],
            'password' => password_hash($datos['password'], PASSWORD_DEFAULT),
            'email' => $datos['email'],
            'rol_id' => 4, // Administrativo
            'estado' => 'activo',
            'fecha_registro' => date('Y-m-d H:i:s')
        ]);
        $this->adminModel->insert([
            'usuario_id' => $usuarioId,
            'nombres' => $datos['nombres'],
            'apellidos' => $datos['apellidos'],
            'dni' => $datos['dni'],
            'area' => $datos['area'] ?? '',
            'telefono' => $datos['telefono'] ?? '',
            'fecha_ingreso' => date('Y-m-d')
        ]);
        return redirect()->to(base_url('administradores/administrativos'))
            ->with('success', 'Administrativo creado');
    }

    public function editarAdministrativo($id)
    {
        $administrativo = $this->adminModel->find($id);
        if (!$administrativo) {
            return redirect()->back()->with('error', 'Administrativo no encontrado');
        }
        $usuario = $this->usuarioModel->find($administrativo['usuario_id']);
        return view('administradores/administrativos/edit', ['administrativo' => $administrativo, 'usuario' => $usuario]);
    }

    public function actualizarAdministrativo($id)
    {
        $administrativo = $this->adminModel->find($id);
        if (!$administrativo) {
            return redirect()->back()->with('error', 'Administrativo no encontrado');
        }
        $datos = $this->request->getPost();
        // Validaciones de unicidad en actualización
        $existeEmail = $this->usuarioModel
            ->where('email', $datos['email'])
            ->where('id !=', $administrativo['usuario_id'])
            ->first();
        if ($existeEmail) {
            return redirect()->back()->withInput()->with('error', 'El email ya está en uso por otro usuario');
        }
        $existeDni = $this->adminModel
            ->where('dni', $datos['dni'])
            ->where('id !=', $id)
            ->first();
        if ($existeDni) {
            return redirect()->back()->withInput()->with('error', 'El DNI ya está registrado en otro administrativo');
        }
        $usuarioData = [
            'email' => $datos['email']
        ];
        if (!empty($datos['password'])) {
            $usuarioData['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
        }
        $this->usuarioModel->update($administrativo['usuario_id'], $usuarioData);
        $this->adminModel->update($id, [
            'nombres' => $datos['nombres'],
            'apellidos' => $datos['apellidos'],
            'dni' => $datos['dni'],
            'area' => $datos['area'] ?? '',
            'telefono' => $datos['telefono'] ?? ''
        ]);
        return redirect()->to(base_url('administradores/administrativos'))
            ->with('success', 'Administrativo actualizado');
    }

    public function eliminarAdministrativo($id)
    {
        $administrativo = $this->adminModel->find($id);
        if ($administrativo) {
            $this->adminModel->delete($id);
            $this->usuarioModel->delete($administrativo['usuario_id']);
        }
        return redirect()->to(base_url('administradores/administrativos'))
            ->with('success', 'Administrativo eliminado');
    }

    // =========================================
    // GESTIÓN DE SOLICITUDES DE MATRÍCULA
    // =========================================
    
    public function solicitudesMatricula()
    {
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

        return view('administradores/matriculas/solicitudes', [
            'solicitudes' => $solicitudes
        ]);
    }

    public function verSolicitud($id)
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

        return view('administradores/matriculas/ver', [
            'solicitud' => $solicitud
        ]);
    }

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

        $extension = pathinfo($solicitud['comprobante_pago'], PATHINFO_EXTENSION);
        $contentType = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']) 
            ? 'image/' . ($extension === 'jpg' ? 'jpeg' : $extension)
            : 'application/pdf';

        return $this->response
            ->setHeader('Content-Type', $contentType)
            ->setHeader('Content-Disposition', 'inline; filename="' . $solicitud['comprobante_pago'] . '"')
            ->setBody(file_get_contents($ruta));
    }

    public function aprobarSolicitud($id)
    {
        $solicitud = $this->solicitudMatriculaModel->find($id);

        if (!$solicitud || $solicitud['estado'] !== 'pendiente') {
            return redirect()->back()->with('error', 'No se puede procesar esta solicitud.');
        }

        $usuarioLogeado = session()->get('id_usuario');
        $admin = $this->adminModel->where('usuario_id', $usuarioLogeado)->first();

        $this->solicitudMatriculaModel->update($id, [
            'estado' => 'aprobado',
            'revisado_por' => $admin['id'] ?? null,
            'fecha_revision' => date('Y-m-d H:i:s'),
            'observaciones' => $this->request->getPost('observaciones') ?? 'Solicitud aprobada por administrador'
        ]);

        $estudiante = $this->estudianteModel->find($solicitud['estudiante_id']);
        if ($estudiante) {
            $this->notificacionModel->insert([
                'usuario_id' => $estudiante['usuario_id'],
                'titulo' => '✅ Solicitud de Matrícula Aprobada',
                'mensaje' => 'Tu solicitud de matrícula ha sido APROBADA por el administrador. Ya puedes seleccionar tus cursos.',
                'tipo' => 'matricula',
                'fecha_envio' => date('Y-m-d H:i:s'),
                'leido' => 0
            ]);
        }

        return redirect()->to(base_url('administradores/matriculas/solicitudes'))
            ->with('success', 'Solicitud aprobada correctamente.');
    }

    public function rechazarSolicitud($id)
    {
        $solicitud = $this->solicitudMatriculaModel->find($id);

        if (!$solicitud || $solicitud['estado'] !== 'pendiente') {
            return redirect()->back()->with('error', 'No se puede procesar esta solicitud.');
        }

        $observaciones = $this->request->getPost('observaciones');
        if (!$observaciones) {
            return redirect()->back()->with('error', 'Debes especificar el motivo del rechazo.');
        }

        $usuarioLogeado = session()->get('id_usuario');
        $admin = $this->adminModel->where('usuario_id', $usuarioLogeado)->first();

        $this->solicitudMatriculaModel->update($id, [
            'estado' => 'rechazado',
            'revisado_por' => $admin['id'] ?? null,
            'fecha_revision' => date('Y-m-d H:i:s'),
            'observaciones' => $observaciones
        ]);

        $estudiante = $this->estudianteModel->find($solicitud['estudiante_id']);
        if ($estudiante) {
            $this->notificacionModel->insert([
                'usuario_id' => $estudiante['usuario_id'],
                'titulo' => '❌ Solicitud de Matrícula Rechazada',
                'mensaje' => 'Tu solicitud ha sido RECHAZADA. Motivo: ' . $observaciones,
                'tipo' => 'matricula',
                'fecha_envio' => date('Y-m-d H:i:s'),
                'leido' => 0
            ]);
        }

        return redirect()->to(base_url('administradores/matriculas/solicitudes'))
            ->with('success', 'Solicitud rechazada.');
    }

    // =========================================
    // REPORTES Y ESTADÍSTICAS
    // =========================================
    
    public function reporteMatriculas()
    {
        $periodos = $this->periodoModel->orderBy('fecha_inicio', 'DESC')->findAll();
        
        $estadisticas = [];
        foreach ($periodos as $periodo) {
            $estadisticas[$periodo['id']] = [
                'periodo' => $periodo['nombre'],
                'total_matriculas' => $this->matriculaModel->where('periodo_id', $periodo['id'])->countAllResults(),
                'solicitudes_pendientes' => $this->solicitudMatriculaModel->where('periodo_id', $periodo['id'])->where('estado', 'pendiente')->countAllResults(),
                'solicitudes_aprobadas' => $this->solicitudMatriculaModel->where('periodo_id', $periodo['id'])->where('estado', 'aprobado')->countAllResults(),
                'solicitudes_rechazadas' => $this->solicitudMatriculaModel->where('periodo_id', $periodo['id'])->where('estado', 'rechazado')->countAllResults(),
            ];
        }
        
        return view('administradores/reportes/matriculas', [
            'periodos' => $periodos,
            'estadisticas' => $estadisticas
        ]);
    }

    // =========================================
    // PERFIL DEL ADMINISTRADOR
    // =========================================

    public function perfil()
    {
        $usuarioId = session('id_usuario');

        // Intentar obtener datos del administrador si existe en la tabla administrativos
        $administrador = $this->adminModel->where('usuario_id', $usuarioId)->first();

        return view('administradores/perfil', [
            'administrador' => $administrador
        ]);
    }

    public function actualizarPerfil()
    {
        $usuarioId = session('id_usuario');

        $data = [
            'nombres' => $this->request->getPost('nombres'),
            'apellidos' => $this->request->getPost('apellidos'),
            'dni' => $this->request->getPost('dni'),
            'telefono' => $this->request->getPost('telefono'),
        ];

        // Verificar si ya existe un registro para este usuario
        $existente = $this->adminModel->where('usuario_id', $usuarioId)->first();

        if ($existente) {
            // Actualizar registro existente
            $this->adminModel->update($existente['id'], $data);
        } else {
            // Crear nuevo registro
            $data['usuario_id'] = $usuarioId;
            $data['area'] = 'Administración';
            $data['fecha_ingreso'] = date('Y-m-d');
            $this->adminModel->insert($data);
        }

        // Cambiar contraseña si se proporcionó
        $nuevaPassword = $this->request->getPost('nueva_password');
        $confirmarPassword = $this->request->getPost('confirmar_password');

        if (!empty($nuevaPassword)) {
            if ($nuevaPassword === $confirmarPassword) {
                $this->usuarioModel->update($usuarioId, [
                    'password' => $nuevaPassword  // En producción usar password_hash
                ]);
                session()->setFlashdata('msg', 'Perfil y contraseña actualizados correctamente.');
            } else {
                session()->setFlashdata('error', 'Las contraseñas no coinciden.');
                return redirect()->back()->withInput();
            }
        } else {
            session()->setFlashdata('msg', 'Perfil actualizado correctamente.');
        }

        return redirect()->to(base_url('administradores/perfil'));
    }

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
        
        // Verificar contraseña actual (texto plano por ahora)
        if ($usuario['password'] !== $passwordActual) {
            return redirect()->back()->with('error', 'La contraseña actual es incorrecta');
        }

        $this->usuarioModel->update($usuarioId, [
            'password' => $passwordNueva  // En producción usar password_hash
        ]);

        return redirect()->to(base_url('administradores/perfil'))->with('success', 'Contraseña actualizada correctamente');
    }
}