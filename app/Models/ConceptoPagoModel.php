<?php

namespace App\Models;

use CodeIgniter\Model;

class ConceptoPagoModel extends Model
{
    protected $table = 'conceptos_pago';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion', 'monto_base', 'tipo', 'activo'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Obtener conceptos activos
     */
    public function getConceptosActivos()
    {
        return $this->where('activo', 1)->findAll();
    }

    /**
     * Obtener conceptos por tipo
     */
    public function getConceptosPorTipo($tipo)
    {
        return $this->where('tipo', $tipo)
            ->where('activo', 1)
            ->findAll();
    }
}
