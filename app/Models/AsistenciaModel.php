<?php

namespace App\Models;

use CodeIgniter\Model;

class AsistenciaModel extends Model
{
    protected $table = 'asistencias';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $returnType = 'array';

    protected $allowedFields = [
        'matricula_id', 
        'fecha', 
        'estado', 
        'observacion',
        'hora_registro',
        'registrado_por'
    ];

    /**
     * Obtener asistencias de un curso en una fecha específica
     */
    public function getAsistenciasPorCursoFecha($cursoId, $fecha)
    {
        return $this->select('asistencias.*, matriculas.id as matricula_id,
                             estudiantes.codigo_estudiante, estudiantes.nombres, estudiantes.apellidos')
                    ->join('matriculas', 'matriculas.id = asistencias.matricula_id')
                    ->join('estudiantes', 'estudiantes.id = matriculas.estudiante_id')
                    ->where('matriculas.curso_id', $cursoId)
                    ->where('asistencias.fecha', $fecha)
                    ->orderBy('estudiantes.apellidos', 'ASC')
                    ->findAll();
    }

    /**
     * Registrar asistencia para una matrícula en una fecha
     */
    public function registrarAsistencia($matriculaId, $fecha, $estado, $observacion = null, $usuarioId = null)
    {
        $existe = $this->where('matricula_id', $matriculaId)
                       ->where('fecha', $fecha)
                       ->first();
        
        $datos = [
            'estado' => $estado,
            'observacion' => $observacion,
            'hora_registro' => date('H:i:s'),
            'registrado_por' => $usuarioId
        ];
        
        if ($existe) {
            return $this->update($existe['id'], $datos);
        } else {
            $datos['matricula_id'] = $matriculaId;
            $datos['fecha'] = $fecha;
            return $this->insert($datos);
        }
    }

    /**
     * Obtener resumen de asistencias de un estudiante en un curso
     */
    public function getResumenAsistenciaEstudiante($matriculaId)
    {
        $asistencias = $this->where('matricula_id', $matriculaId)
                            ->orderBy('fecha', 'ASC')
                            ->findAll();
        
        $resumen = [
            'total' => count($asistencias),
            'asistio' => 0,
            'tardanza' => 0,
            'falta' => 0,
            'justificado' => 0
        ];
        
        foreach ($asistencias as $asistencia) {
            switch ($asistencia['estado']) {
                case 'Asistió':
                    $resumen['asistio']++;
                    break;
                case 'Tardanza':
                    $resumen['tardanza']++;
                    break;
                case 'Falta':
                    $resumen['falta']++;
                    break;
                case 'Justificado':
                    $resumen['justificado']++;
                    break;
            }
        }
        
        // Calcular porcentajes
        if ($resumen['total'] > 0) {
            $resumen['porcentaje_asistencia'] = round(
                (($resumen['asistio'] + $resumen['tardanza']) / $resumen['total']) * 100, 
                1
            );
        } else {
            $resumen['porcentaje_asistencia'] = 0;
        }
        
        return $resumen;
    }

    /**
     * Obtener resumen de asistencias de un curso en una fecha
     */
    public function getResumenCursoFecha($cursoId, $fecha)
    {
        $db = \Config\Database::connect();
        
        // Total de matriculados
        $totalMatriculados = $db->table('matriculas')
                                ->where('curso_id', $cursoId)
                                ->countAllResults();
        
        // Contar por estado
        $query = "SELECT 
                    COUNT(CASE WHEN a.estado = 'Asistió' THEN 1 END) as asistio,
                    COUNT(CASE WHEN a.estado = 'Tardanza' THEN 1 END) as tardanza,
                    COUNT(CASE WHEN a.estado = 'Falta' THEN 1 END) as falta,
                    COUNT(CASE WHEN a.estado = 'Justificado' THEN 1 END) as justificado
                  FROM asistencias a
                  JOIN matriculas m ON m.id = a.matricula_id
                  WHERE m.curso_id = ? AND a.fecha = ?";
        
        $result = $db->query($query, [$cursoId, $fecha])->getRowArray();
        
        $resumen = [
            'total' => $totalMatriculados,
            'asistio' => (int)$result['asistio'],
            'tardanza' => (int)$result['tardanza'],
            'falta' => (int)$result['falta'],
            'justificado' => (int)$result['justificado'],
            'registrados' => (int)($result['asistio'] + $result['tardanza'] + $result['falta'] + $result['justificado'])
        ];
        
        // Porcentajes
        $den = max(1, $resumen['total']);
        $resumen['pct_asistio'] = round(($resumen['asistio'] / $den) * 100, 1);
        $resumen['pct_tardanza'] = round(($resumen['tardanza'] / $den) * 100, 1);
        $resumen['pct_falta'] = round(($resumen['falta'] / $den) * 100, 1);
        $resumen['pct_justificado'] = round(($resumen['justificado'] / $den) * 100, 1);
        
        return $resumen;
    }

    /**
     * Obtener todas las fechas con asistencia de un curso
     */
    public function getFechasConAsistencia($cursoId)
    {
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT DISTINCT a.fecha 
            FROM asistencias a
            JOIN matriculas m ON m.id = a.matricula_id
            WHERE m.curso_id = ?
            ORDER BY a.fecha DESC
        ", [$cursoId]);
        
        $result = $query->getResultArray();
        return array_column($result, 'fecha');
    }

    /**
     * Verificar si ya existe asistencia para una fecha
     */
    public function existeAsistenciaFecha($cursoId, $fecha)
    {
        return $this->select('asistencias.*')
                    ->join('matriculas', 'matriculas.id = asistencias.matricula_id')
                    ->where('matriculas.curso_id', $cursoId)
                    ->where('asistencias.fecha', $fecha)
                    ->countAllResults() > 0;
    }
}
