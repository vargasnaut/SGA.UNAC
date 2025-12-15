<?php

namespace App\Models;

use CodeIgniter\Model;

class CursoModel extends Model
{
    protected $table = 'cursos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'carrera_id', 'docente_id', 'nombre', 'creditos', 'horas_semana'
    ];

    // Cursos en los que el estudiante está matriculado
    public function getCursosPorEstudiante($usuarioId)
    {
        return $this->select("cursos.*, docentes.nombres AS docente_nombres, docentes.apellidos AS docente_apellidos")
            ->join('matriculas', 'matriculas.curso_id = cursos.id')
            ->join('estudiantes', 'estudiantes.id = matriculas.estudiante_id')
            ->join('docentes', 'docentes.id = cursos.docente_id', 'left')
            ->where('estudiantes.usuario_id', $usuarioId)
            ->findAll();
    }
}
