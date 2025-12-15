<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodoAcademicoModel extends Model
{
    protected $table = 'periodos_academicos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nombre', 'fecha_inicio', 'fecha_fin'
    ];
    
    public function getPeriodoActual()
    {
        $hoy = date('Y-m-d');
        return $this->where('fecha_inicio <=', $hoy)
            ->where('fecha_fin >=', $hoy)
            ->first();
    }
    
    public function getPeriodoProximo()
    {
        $hoy = date('Y-m-d');
        return $this->where('fecha_inicio >', $hoy)
            ->orderBy('fecha_inicio', 'ASC')
            ->first();
    }
}
