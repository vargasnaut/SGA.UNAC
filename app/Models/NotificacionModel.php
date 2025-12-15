<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificacionModel extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'usuario_id', 'titulo', 'mensaje', 'tipo', 'fecha_envio', 'leido', 'archivo'
    ];

    // Marcar una notificación como leída
    public function marcarLeida($id)
    {
        return $this->update($id, ['leido' => 1]);
    }
}

