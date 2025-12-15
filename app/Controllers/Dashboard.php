<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\NotificacionModel;
use App\Models\EstudianteModel;
use App\Models\DocenteModel;
use App\Models\FacultadModel;
use App\Models\CursoModel;

class Dashboard extends Controller
{
    protected $notificacionModel;
    protected $estudianteModel;
    protected $docenteModel;
    protected $facultadModel;
    protected $cursoModel;

    public function __construct()
    {
        $this->notificacionModel = new NotificacionModel();
        $this->estudianteModel = new EstudianteModel();
        $this->docenteModel = new DocenteModel();
        $this->facultadModel = new FacultadModel();
        $this->cursoModel = new CursoModel();
    }
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('auth'));
        }

        $rol_id = $session->get('rol_id');

        // Redirigir según el rol
        switch ($rol_id) {
            case 1:
                return redirect()->to(base_url('administradores/dashboard'));
            case 2:
                return redirect()->to(base_url('dashboard/docente'));
            case 3:
                return redirect()->to(base_url('dashboard/estudiante'));
            case 4:
                return redirect()->to(base_url('dashboard/administrativo'));
            default:
                return redirect()->to(base_url('auth/logout'));
        }
    }

    public function docente()
    {
        $session = session();
        $usuarioId = $session->get('id_usuario');
        
        // Obtener notificaciones del docente (últimas 5)
        $notificaciones = $this->notificacionModel
            ->where('usuario_id', $usuarioId)
            ->orderBy('fecha_envio', 'DESC')
            ->limit(5)
            ->findAll();
        
        // Contar notificaciones no leídas
        $noLeidas = $this->notificacionModel
            ->where('usuario_id', $usuarioId)
            ->where('leido', 0)
            ->countAllResults();
        
        // Obtener información del docente
        $docente = $this->docenteModel->getByUsuarioId($usuarioId);
        
        // Obtener todas las facultades con sus carreras
        $facultades = $this->facultadModel->getAllFacultadesConCarreras();
        
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
        
        return view('dashboard/docente', [
            'nombre' => $session->get('nombre'),
            'notificaciones' => $notificaciones,
            'notificaciones_no_leidas' => $noLeidas,
            'facultades' => $facultades,
            'cursos' => $cursos,
            'docente' => $docente
        ]);
    }

    public function estudiante()
    {
        $session = session();
        
        // Verificar si el usuario está autenticado
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('auth'));
        }
        
        $usuarioId = $session->get('id_usuario');
        
        // Obtener notificaciones del estudiante (últimas 5)
        $notificaciones = $this->notificacionModel
            ->where('usuario_id', $usuarioId)
            ->orderBy('fecha_envio', 'DESC')
            ->limit(5)
            ->findAll();
        
        // Contar notificaciones no leídas
        $noLeidas = $this->notificacionModel
            ->where('usuario_id', $usuarioId)
            ->where('leido', 0)
            ->countAllResults();
        
        // Obtener cursos del estudiante
        $cursos = $this->cursoModel->getCursosPorEstudiante($usuarioId);
        
        return view('dashboard/estudiante', [
            'nombre' => $session->get('nombre'),
            'notificaciones' => $notificaciones,
            'notificaciones_no_leidas' => $noLeidas,
            'cursos' => $cursos
        ]);
    }

    public function administrativo()
    {
        $session = session();
        return view('dashboard/administrativo', ['nombre' => $session->get('nombre')]);
    }
}
