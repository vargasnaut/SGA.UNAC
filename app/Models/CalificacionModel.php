<?php

namespace App\Models;

use CodeIgniter\Model;

class CalificacionModel extends Model
{
    protected $table = 'calificaciones';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $returnType = 'array';

    protected $allowedFields = [
        'matricula_id', 
        'nota1', 
        'nota2', 
        'nota3', 
        'componente1',
        'componente2',
        'componente3',
        'componente4',
        'componente5',
        'nota_final', 
        'observaciones',
        'fecha_actualizacion'
    ];

    /**
     * Obtener calificaciones por curso con información del estudiante
     */
    public function getCalificacionesPorCurso($cursoId)
    {
        return $this->select('calificaciones.*, matriculas.id as matricula_id, 
                             estudiantes.codigo_estudiante, estudiantes.nombres, estudiantes.apellidos,
                             estudiantes.id as estudiante_id')
                    ->join('matriculas', 'matriculas.id = calificaciones.matricula_id')
                    ->join('estudiantes', 'estudiantes.id = matriculas.estudiante_id')
                    ->where('matriculas.curso_id', $cursoId)
                    ->orderBy('estudiantes.apellidos', 'ASC')
                    ->findAll();
    }

    /**
     * Obtener calificación por matrícula
     */
    public function getCalificacionPorMatricula($matriculaId)
    {
        return $this->where('matricula_id', $matriculaId)->first();
    }

    /**
     * Guardar o actualizar calificación
     */
    public function guardarCalificacion($matriculaId, $datos)
    {
        $existe = $this->where('matricula_id', $matriculaId)->first();
        
        $datos['fecha_actualizacion'] = date('Y-m-d H:i:s');
        
        if ($existe) {
            return $this->update($existe['id'], $datos);
        } else {
            $datos['matricula_id'] = $matriculaId;
            return $this->insert($datos);
        }
    }

    /**
     * Calcular nota final basado en componentes
     */
    public function calcularNotaFinal($componentes, $formulas)
    {
        $notaFinal = 0;
        
        foreach ($formulas as $index => $formula) {
            $componenteKey = 'componente' . ($index + 1);
            if (isset($componentes[$componenteKey]) && $componentes[$componenteKey] !== null && $componentes[$componenteKey] !== '') {
                $nota = floatval($componentes[$componenteKey]);
                $porcentaje = floatval($formula['porcentaje']);
                $notaFinal += ($nota * $porcentaje) / 100;
            }
        }
        
        return round($notaFinal, 2);
    }

    /**
     * Obtener estadísticas de un curso
     */
    public function getEstadisticasCurso($cursoId)
    {
        $calificaciones = $this->getCalificacionesPorCurso($cursoId);
        
        $notasFinales = array_filter(array_column($calificaciones, 'nota_final'), function($nota) {
            return $nota !== null && $nota !== '';
        });
        
        if (empty($notasFinales)) {
            return [
                'promedio' => 0,
                'maxima' => 0,
                'minima' => 0,
                'aprobados' => 0,
                'desaprobados' => 0,
                'total' => count($calificaciones)
            ];
        }
        
        return [
            'promedio' => round(array_sum($notasFinales) / count($notasFinales), 2),
            'maxima' => max($notasFinales),
            'minima' => min($notasFinales),
            'aprobados' => count(array_filter($notasFinales, fn($n) => $n >= 10.5)),
            'desaprobados' => count(array_filter($notasFinales, fn($n) => $n < 10.5)),
            'total' => count($calificaciones)
        ];
    }
}
