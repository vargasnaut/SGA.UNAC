<?php

namespace App\Controllers;

use App\Models\MatriculaModel;
use App\Models\EstudianteModel;
use App\Controllers\BaseController;

class Matriculas extends BaseController
{
    protected $matriculaModel;
    protected $estudianteModel;

    public function __construct()
    {
        $this->matriculaModel = new MatriculaModel();
        $this->estudianteModel = new EstudianteModel();
    }

    // Listado de matrículas del estudiante logueado
    public function index()
    {
        $usuario_id = session('id_usuario'); // id del usuario logueado
        $estudiante = $this->estudianteModel->where('usuario_id', $usuario_id)->first();

        if (!$estudiante) {
            $data = [
                'title' => 'Mis Matrículas',
                'matriculas' => []
            ];
            return view('matriculas/index', $data);
        }

        $matriculas = $this->matriculaModel->getMatriculasPorEstudiante($estudiante['id']);

        $data = [
            'title' => 'Mis Matrículas',
            'matriculas' => $matriculas
        ];

        return view('matriculas/index', $data);
    }
}
