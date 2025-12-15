<?php

namespace App\Models;

use CodeIgniter\Model;

class FacultadModel extends Model
{
    protected $table = 'facultades';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion'];
    
    public function getCarrerasPorFacultad($facultadId)
    {
        return $this->db->table('carreras')
            ->where('facultad_id', $facultadId)
            ->get()
            ->getResultArray();
    }
    
    public function getAllFacultadesConCarreras()
    {
        return $this->select('facultades.*, COUNT(carreras.id) as total_carreras')
            ->join('carreras', 'carreras.facultad_id = facultades.id', 'left')
            ->groupBy('facultades.id')
            ->findAll();
    }
}
