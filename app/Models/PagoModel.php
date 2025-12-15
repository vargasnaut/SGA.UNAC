<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'tramite_id',
        'monto',
        'metodo_pago',
        'fecha_pago',
        'estado'
    ];

    protected $useTimestamps = false; // Tu tabla NO tiene created_at / updated_at

    /**
     * Obtiene todos los pagos asociados a un trámite
     */
    public function getPagosPorTramite($tramiteId)
    {
        return $this->where('tramite_id', $tramiteId)
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    /**
     * Registrar un pago para un trámite
     */
    public function registrarPago($tramiteId, $monto, $metodoPago)
    {
        return $this->insert([
            'tramite_id' => $tramiteId,
            'monto'      => $monto,
            'metodo_pago'=> $metodoPago,
            'fecha_pago' => date('Y-m-d'),
            'estado'     => 'pagado'
        ]);
    }

    /**
     * Obtener pago por ID
     */
    public function obtenerPago($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Marcar un pago como anulado
     */
    public function anularPago($id)
    {
        return $this->update($id, ['estado' => 'anulado']);
    }

    /**
     * Validar si un trámite ya fue pagado
     */
    public function tramitePagado($tramiteId)
    {
        return $this->where('tramite_id', $tramiteId)
                    ->where('estado', 'pagado')
                    ->countAllResults() > 0;
    }

    /**
     * Obtener monto total pagado de un trámite
     */
    public function totalPagadoTramite($tramiteId)
    {
        return $this->selectSum('monto')
                    ->where('tramite_id', $tramiteId)
                    ->where('estado', 'pagado')
                    ->get()
                    ->getRow()
                    ->monto;
    }
}
