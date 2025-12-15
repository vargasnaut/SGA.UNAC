<?php

namespace App\Models;

use CodeIgniter\Model;

class HorarioCursoModel extends Model
{
    protected $table = 'horarios_curso';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $returnType = 'array';

    protected $allowedFields = [
        'curso_id', 
        'dia_semana', 
        'hora_inicio', 
        'hora_fin', 
        'aula_id', 
        'periodo_academico_id', 
        'activo'
    ];

    protected $diasSemana = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo'
    ];

    /**
     * Obtener horarios de un curso
     */
    public function getHorariosPorCurso($cursoId, $periodoId = null)
    {
        $builder = $this->where('curso_id', $cursoId)
                        ->where('activo', 1);
        
        if ($periodoId) {
            $builder->where('periodo_academico_id', $periodoId);
        }
        
        return $builder->orderBy('dia_semana', 'ASC')
                       ->orderBy('hora_inicio', 'ASC')
                       ->findAll();
    }

    /**
     * Obtener fechas de clases basadas en horario
     * Genera todas las fechas entre fecha_inicio y fecha_fin
     */
    public function getFechasClases($cursoId, $fechaInicio, $fechaFin)
    {
        $horarios = $this->getHorariosPorCurso($cursoId);
        $fechasClases = [];
        
        foreach ($horarios as $horario) {
            $diaSemana = (int)$horario['dia_semana'];
            $fechasClases = array_merge(
                $fechasClases, 
                $this->generarFechasPorDia($fechaInicio, $fechaFin, $diaSemana, $horario)
            );
        }
        
        sort($fechasClases);
        return $fechasClases;
    }

    /**
     * Generar fechas para un día específico de la semana
     */
    private function generarFechasPorDia($fechaInicio, $fechaFin, $diaSemana, $horarioInfo)
    {
        $fechas = [];
        $current = strtotime($fechaInicio);
        $end = strtotime($fechaFin);
        
        // Ajustar al primer día de la semana deseado
        $currentDayOfWeek = date('N', $current); // 1=Lunes, 7=Domingo
        
        if ($currentDayOfWeek != $diaSemana) {
            $daysToAdd = ($diaSemana - $currentDayOfWeek + 7) % 7;
            $current = strtotime("+{$daysToAdd} days", $current);
        }
        
        // Generar todas las fechas
        while ($current <= $end) {
            $fechas[] = [
                'fecha' => date('Y-m-d', $current),
                'dia_nombre' => $this->diasSemana[$diaSemana],
                'hora_inicio' => $horarioInfo['hora_inicio'],
                'hora_fin' => $horarioInfo['hora_fin']
            ];
            $current = strtotime('+1 week', $current);
        }
        
        return $fechas;
    }

    /**
     * Obtener nombre del día
     */
    public function getNombreDia($numerodia)
    {
        return $this->diasSemana[$numerodia] ?? 'Desconocido';
    }

    /**
     * Verificar si una fecha es día de clase
     */
    public function esDiaDeClase($cursoId, $fecha)
    {
        $diaSemana = date('N', strtotime($fecha)); // 1=Lunes, 7=Domingo
        
        return $this->where('curso_id', $cursoId)
                    ->where('dia_semana', $diaSemana)
                    ->where('activo', 1)
                    ->countAllResults() > 0;
    }
}
