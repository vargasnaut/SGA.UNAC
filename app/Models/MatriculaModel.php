<?php

namespace App\Models;

use CodeIgniter\Model;

class MatriculaModel extends Model
{
    protected $table = 'matriculas';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'estudiante_id', 'curso_id', 'periodo_id', 'fecha_matricula', 'estado'
    ];

    public function getMatriculasPorEstudiante($usuarioId)
    {
        return $this->select("
                    matriculas.*, 
                    cursos.nombre AS curso,
                    periodos_academicos.nombre AS periodo")
            ->join('estudiantes', 'estudiantes.id = matriculas.estudiante_id')
            ->join('cursos', 'cursos.id = matriculas.curso_id')
            ->join('periodos_academicos', 'periodos_academicos.id = matriculas.periodo_id')
            ->where('estudiantes.usuario_id', $usuarioId)
            ->findAll();
    }
    
    public function getMatriculasPorCurso($cursoId)
    {
        return $this->select(
                "MIN(matriculas.id) AS id, " .
                "matriculas.estudiante_id, " .
                "matriculas.curso_id, " .
                "matriculas.periodo_id, " .
                "estudiantes.codigo_estudiante, " .
                "estudiantes.nombres AS estudiante_nombres, " .
                "estudiantes.apellidos AS estudiante_apellidos, " .
                "calificaciones.nota1, calificaciones.nota2, calificaciones.nota3, calificaciones.nota_final, " .
                "calificaciones.componente1, calificaciones.componente2, calificaciones.componente3, calificaciones.componente4, calificaciones.componente5"
            )
            ->join('estudiantes', 'estudiantes.id = matriculas.estudiante_id')
            ->join('calificaciones', 'calificaciones.matricula_id = matriculas.id', 'left')
            ->where('matriculas.curso_id', $cursoId)
            ->groupBy('matriculas.estudiante_id, matriculas.curso_id, matriculas.periodo_id')
            ->orderBy('estudiantes.apellidos', 'ASC')
            ->findAll();
    }
}

