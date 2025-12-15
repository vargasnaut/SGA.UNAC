<?php

namespace App\Models;

use CodeIgniter\Model;

class TramiteModel extends Model
{
    protected $table      = 'tramites';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'estudiante_id',
        'administrativo_id',
        'tipo',
        'descripcion',
        'motivo',
        'tipo_documento',
        'documento',
        'fecha_solicitud',
        'estado'
    ];


    // Obtener trámites de un estudiante
    public function getTramitesPorEstudiante($estudiante_id)
    {
        return $this->where('estudiante_id', $estudiante_id)
                    ->orderBy('fecha_solicitud', 'DESC')
                    ->findAll();
    }

    // Obtener todos los trámites con datos del estudiante
    public function obtenerTramitesConEstudiante()
    {
        return $this->select('
                tramites.*,
                estudiantes.nombres AS est_nombres,
                estudiantes.apellidos AS est_apellidos
            ')
            ->join('estudiantes', 'estudiantes.id = tramites.estudiante_id')
            ->orderBy('tramites.fecha_solicitud', 'DESC')
            ->findAll();
    }

    
    public function obtenerTramiteConEstudiantePorId($id)
    {
        return $this->select('
                tramites.*,
                estudiantes.nombres AS est_nombres,
                estudiantes.apellidos AS est_apellidos
            ')
            ->join('estudiantes', 'estudiantes.id = tramites.estudiante_id')
            ->where('tramites.id', $id)
            ->first();
    }


}
