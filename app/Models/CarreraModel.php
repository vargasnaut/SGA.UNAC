<?php

namespace App\Models;

use CodeIgniter\Model;

class CarreraModel extends Model
{
    protected $table = 'carreras';
    protected $primaryKey = 'id';
    protected $allowedFields = ['facultad_id', 'nombre', 'duracion'];
    
    public function getCarreraConFacultad($carreraId)
    {
        return $this->select('carreras.*, facultades.nombre as facultad_nombre')
            ->join('facultades', 'facultades.id = carreras.facultad_id')
            ->where('carreras.id', $carreraId)
            ->first();
    }
    
    public function getCarrerasPorFacultad($facultadId)
    {
        return $this->where('facultad_id', $facultadId)->findAll();
    }
}
