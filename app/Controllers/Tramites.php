<?php

namespace App\Controllers;

use App\Models\TramiteModel;
use App\Controllers\BaseController;

class Tramites extends BaseController
{
    protected $tramiteModel;

    public function __construct()
    {
        $this->tramiteModel = new TramiteModel();
    }

    // Listado de trámites del estudiante logueado
    public function index()
    {
        $estudiante_id = session('usuario_id');
        $tramites = $this->tramiteModel->getTramitesPorEstudiante($estudiante_id);

        $data = [
            'title' => 'Mis Trámites',
            'tramites' => $tramites
        ];

        return view('tramites/index', $data);
    }

    // Crear nuevo trámite
    public function create()
    {
        $data = [
            'title' => 'Nuevo Trámite'
        ];

        return view('tramites/create', $data);
    }

    // Guardar trámite
    public function store()
    {
        $estudiante_id = session('usuario_id');

        $this->tramiteModel->save([
            'estudiante_id' => $estudiante_id,
            'tipo' => $this->request->getPost('tipo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => 'pendiente'
        ]);

        return redirect()->to(base_url('tramites'))->with('success', 'Trámite registrado correctamente.');
    }

    
   

}
