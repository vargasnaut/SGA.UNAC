<?php

namespace App\Models;

use CodeIgniter\Model;

class SolicitudMatriculaModel extends Model
{
    protected $table = 'solicitudes_matricula';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'estudiante_id', 'periodo_id', 'comprobante_pago', 'monto',
        'fecha_solicitud', 'estado', 'observaciones', 'revisado_por', 'fecha_revision'
    ];
    
    public function getSolicitudesPendientes()
    {
        return $this->select('solicitudes_matricula.*, estudiantes.codigo_estudiante, estudiantes.nombres, estudiantes.apellidos, periodos_academicos.nombre as periodo')
            ->join('estudiantes', 'estudiantes.id = solicitudes_matricula.estudiante_id')
            ->join('periodos_academicos', 'periodos_academicos.id = solicitudes_matricula.periodo_id')
            ->where('solicitudes_matricula.estado', 'pendiente')
            ->orderBy('solicitudes_matricula.fecha_solicitud', 'DESC')
            ->findAll();
    }
    
    public function getSolicitudPorEstudiante($estudianteId, $periodoId)
    {
        return $this->where('estudiante_id', $estudianteId)
            ->where('periodo_id', $periodoId)
            ->first();
    }
}
