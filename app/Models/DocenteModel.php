<?php

namespace App\Models;

use CodeIgniter\Model;



class DocenteModel extends Model
{
    protected $table = 'docentes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'usuario_id', 'nombres', 'apellidos', 'dni',
        'especialidad', 'telefono', 'fecha_ingreso'
    ];

    // Obtener datos del docente logueado
    public function getByUsuarioId($usuario_id)
    {
        return $this->where('usuario_id', $usuario_id)->first();
    }
}
