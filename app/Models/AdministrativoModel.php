<?php

namespace App\Models;

use CodeIgniter\Model;

class AdministrativoModel extends Model
{
    protected $table      = 'administrativos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'usuario_id', 
        'nombres', 
        'apellidos', 
        'dni', 
        'area', 
        'telefono', 
        'fecha_ingreso'
    ];

    // Obtener administrativo por usuario
    public function getByUsuarioId($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)->first();
    }
}
