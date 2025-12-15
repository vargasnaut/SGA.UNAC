<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramacionHorariaModel extends Model
{
    protected $table = 'programacion_horaria';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'curso_id', 'periodo_id', 'docente_id', 'dia_semana', 'hora_inicio', 'hora_fin',
        'aula', 'cupos_totales', 'cupos_ocupados', 'activo'
    ];
    // La tabla programacion_horaria no tiene columnas created_at/updated_at
    protected $useTimestamps = false;

    /**
     * Obtener programación horaria de un curso para un periodo
     */
    public function getProgramacionCurso($cursoId, $periodoId)
    {
        return $this->where('curso_id', $cursoId)
                    ->where('periodo_id', $periodoId)
                    ->where('activo', 1)
                    ->findAll();
    }

    /**
     * Verificar si hay conflicto de horarios
     */
    public function verificarConflictoHorario($estudianteId, $cursoId, $periodoId)
    {
        $db = \Config\Database::connect();
        
        // 1. Obtener horarios del nuevo curso
        $horariosNuevoCurso = $this->where('curso_id', $cursoId)
            ->where('periodo_id', $periodoId)
            ->where('activo', 1)
            ->findAll();
        
        if (empty($horariosNuevoCurso)) {
            return [
                'conflicto' => false,
                'mensaje' => 'Curso sin programación horaria',
                'detalles' => []
            ];
        }
        
        // 2. Obtener cursos ya matriculados del estudiante
        $cursosMatriculados = $db->table('matriculas')
            ->select('curso_id')
            ->where('estudiante_id', $estudianteId)
            ->where('periodo_id', $periodoId)
            ->where('estado', 'matriculado')
            ->get()->getResultArray();
        
        if (empty($cursosMatriculados)) {
            return [
                'conflicto' => false,
                'mensaje' => 'Sin cursos matriculados',
                'detalles' => []
            ];
        }
        
        $cursoIds = array_column($cursosMatriculados, 'curso_id');
        
        // 3. Obtener horarios de cursos matriculados
        $horariosMatriculados = $this->select('programacion_horaria.*, cursos.nombre as curso_nombre')
            ->join('cursos', 'cursos.id = programacion_horaria.curso_id')
            ->whereIn('programacion_horaria.curso_id', $cursoIds)
            ->where('programacion_horaria.periodo_id', $periodoId)
            ->where('programacion_horaria.activo', 1)
            ->findAll();
        
        // 4. Verificar solapamiento de horarios
        $conflictos = [];
        foreach ($horariosNuevoCurso as $nuevoHorario) {
            foreach ($horariosMatriculados as $horarioExistente) {
                if ($nuevoHorario['dia_semana'] === $horarioExistente['dia_semana']) {
                    if ($this->horariosSeSolapan(
                        $nuevoHorario['hora_inicio'], 
                        $nuevoHorario['hora_fin'],
                        $horarioExistente['hora_inicio'], 
                        $horarioExistente['hora_fin']
                    )) {
                        $conflictos[] = [
                            'dia' => $nuevoHorario['dia_semana'],
                            'hora_nuevo' => $nuevoHorario['hora_inicio'] . ' - ' . $nuevoHorario['hora_fin'],
                            'hora_existente' => $horarioExistente['hora_inicio'] . ' - ' . $horarioExistente['hora_fin'],
                            'curso_conflicto' => $horarioExistente['curso_nombre'] ?? 'Desconocido',
                            'aula_nuevo' => $nuevoHorario['aula'] ?? 'S/A',
                            'aula_existente' => $horarioExistente['aula'] ?? 'S/A'
                        ];
                    }
                }
            }
        }
        
        return [
            'conflicto' => !empty($conflictos),
            'mensaje' => !empty($conflictos) ? 'Hay conflictos de horario' : 'Sin conflictos',
            'detalles' => $conflictos
        ];
    }

    /**
     * Verificar si dos horarios se solapan
     */
    private function horariosSeSolapan($inicio1, $fin1, $inicio2, $fin2)
    {
        $inicio1_ts = strtotime($inicio1);
        $fin1_ts = strtotime($fin1);
        $inicio2_ts = strtotime($inicio2);
        $fin2_ts = strtotime($fin2);
        
        return ($inicio1_ts < $fin2_ts) && ($fin1_ts > $inicio2_ts);
    }

    /**
     * Verificar cupos disponibles
     */
    public function verificarCuposDisponibles($cursoId, $periodoId)
    {
        $programacion = $this->where('curso_id', $cursoId)
            ->where('periodo_id', $periodoId)
            ->where('activo', 1)
            ->first();
        
        if (!$programacion) {
            return [
                'disponible' => false,
                'mensaje' => 'Curso no tiene programación activa para este periodo',
                'cupos_restantes' => 0,
                'total_cupos' => 0
            ];
        }
        
        $cuposTotales = $programacion['cupos_totales'] ?? 30;
        $cuposOcupados = $programacion['cupos_ocupados'] ?? 0;
        
        if ($cuposOcupados >= $cuposTotales) {
            return [
                'disponible' => false,
                'mensaje' => 'Curso lleno (' . $cuposOcupados . '/' . $cuposTotales . ')',
                'cupos_restantes' => 0,
                'total_cupos' => $cuposTotales,
                'matriculados' => $cuposOcupados
            ];
        }
        
        return [
            'disponible' => true,
            'mensaje' => 'Cupos disponibles',
            'cupos_restantes' => $cuposTotales - $cuposOcupados,
            'total_cupos' => $cuposTotales,
            'matriculados' => $cuposOcupados
        ];
    }

    /**
     * Incrementar contador de matriculados
     */
    public function incrementarMatriculados($cursoId, $periodoId)
    {
        $programacion = $this->where('curso_id', $cursoId)
            ->where('periodo_id', $periodoId)
            ->where('activo', 1)
            ->first();
        
        if ($programacion) {
            return $this->update($programacion['id'], [
                'cupos_ocupados' => ($programacion['cupos_ocupados'] ?? 0) + 1
            ]);
        }
        
        return false;
    }

    /**
     * Decrementar contador de matriculados (cuando se retira)
     */
    public function decrementarMatriculados($cursoId, $periodoId)
    {
        $programacion = $this->where('curso_id', $cursoId)
            ->where('periodo_id', $periodoId)
            ->where('activo', 1)
            ->first();
        
        if ($programacion && ($programacion['cupos_ocupados'] ?? 0) > 0) {
            return $this->update($programacion['id'], [
                'cupos_ocupados' => $programacion['cupos_ocupados'] - 1
            ]);
        }
        
        return false;
    }

    /**
     * Obtener horario semanal de un estudiante
     */
    public function getHorarioEstudiante($estudianteId, $periodoId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('programacion_horaria')
            ->select('programacion_horaria.*, cursos.nombre as curso_nombre, cursos.codigo_curso')
            ->join('cursos', 'cursos.id = programacion_horaria.curso_id')
            ->join('matriculas', 'matriculas.curso_id = cursos.id')
            ->where('matriculas.estudiante_id', $estudianteId)
            ->where('matriculas.periodo_id', $periodoId)
            ->where('matriculas.estado', 'matriculado')
            ->where('programacion_horaria.activo', 1)
            ->orderBy('programacion_horaria.dia_semana', 'ASC')
            ->orderBy('programacion_horaria.hora_inicio', 'ASC')
            ->get()->getResultArray();
    }

    /**
     * Verificar límite de créditos
     */
    public function verificarLimiteCreditos($estudianteId, $cursoId, $periodoId, $limiteMax = 22)
    {
        $db = \Config\Database::connect();
        
        // Obtener créditos ya matriculados
        $creditosActuales = $db->table('matriculas')
            ->select('SUM(cursos.creditos) as total_creditos')
            ->join('cursos', 'cursos.id = matriculas.curso_id')
            ->where('matriculas.estudiante_id', $estudianteId)
            ->where('matriculas.periodo_id', $periodoId)
            ->where('matriculas.estado', 'matriculado')
            ->get()->getRow()->total_creditos ?? 0;
        
        // Obtener créditos del nuevo curso
        $nuevoCurso = $db->table('cursos')
            ->select('creditos, nombre')
            ->where('id', $cursoId)
            ->get()->getRow();
        
        if (!$nuevoCurso) {
            return [
                'permitido' => false,
                'mensaje' => 'Curso no encontrado'
            ];
        }
        
        $creditosNuevos = $nuevoCurso->creditos ?? 0;
        $totalCreditos = $creditosActuales + $creditosNuevos;
        
        if ($totalCreditos > $limiteMax) {
            return [
                'permitido' => false,
                'creditos_actuales' => (int)$creditosActuales,
                'creditos_nuevos' => $creditosNuevos,
                'total' => $totalCreditos,
                'limite' => $limiteMax,
                'creditos_disponibles' => max(0, $limiteMax - $creditosActuales),
                'mensaje' => "Excedes el límite de créditos. Tienes {$creditosActuales} créditos y este curso suma {$creditosNuevos} más (Límite: {$limiteMax})"
            ];
        }
        
        return [
            'permitido' => true,
            'creditos_actuales' => (int)$creditosActuales,
            'creditos_nuevos' => $creditosNuevos,
            'total' => $totalCreditos,
            'limite' => $limiteMax,
            'creditos_disponibles' => $limiteMax - $totalCreditos,
            'mensaje' => "Puedes matricularte. Tendrás {$totalCreditos}/{$limiteMax} créditos"
        ];
    }

    /**
     * Obtener estadísticas de programación
     */
    public function getEstadisticasPeriodo($periodoId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('programacion_horaria')
            ->select('COUNT(*) as total_horarios, SUM(cupos_totales) as total_cupos, SUM(cupos_ocupados) as total_matriculados')
            ->where('periodo_id', $periodoId)
            ->where('activo', 1)
            ->get()->getRowArray();
    }
}
