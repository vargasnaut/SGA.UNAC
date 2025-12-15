<?php

namespace App\Controllers;

use App\Models\NotificacionModel;
use App\Controllers\BaseController;

class Notificaciones extends BaseController
{
    protected $notificacionModel;

    public function __construct()
    {
        $this->notificacionModel = new NotificacionModel();
    }

    // Listado de notificaciones del usuario logueado
    public function index()
    {
        $usuario_id = session('usuario_id'); // id del usuario logueado
        $notificaciones = $this->notificacionModel->getNotificacionesPorUsuario($usuario_id);

        $data = [
            'title' => 'Mis Notificaciones',
            'notificaciones' => $notificaciones
        ];

        return view('notificaciones/index', $data);
    }
    // Marcar notificación como leída
    public function marcarLeida($id)
    {
        $this->notificacionModel->marcarLeida($id);
        return redirect()->back()->with('success', 'Notificación marcada como leída.');
    }


}
