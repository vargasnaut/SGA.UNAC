<?php

namespace App\Models;

use CodeIgniter\Model;

class EstudianteModel extends Model
{
    protected $table = 'estudiantes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'usuario_id', 'codigo_estudiante', 'nombres', 'apellidos', 'dni',
        'direccion', 'telefono', 'carrera_id', 'fecha_registro'
    ];

    // Obtener datos del estudiante logueado
    public function getByUsuarioId($usuario_id)
    {
        return $this->where('usuario_id', $usuario_id)
                    ->join('carreras', 'carreras.id = estudiantes.carrera_id')
                    ->select('estudiantes.*, carreras.nombre AS carrera')
                    ->first();
    }
}
