<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PagoModel;
use App\Models\TramiteModel;
use App\Models\EstudianteModel;
use Dompdf\Dompdf;

class Pagos extends BaseController
{
    protected $pagoModel;
    protected $tramiteModel;
    protected $estudianteModel;

    public function __construct()
    {
        $this->pagoModel       = new PagoModel();
        $this->tramiteModel    = new TramiteModel();
        $this->estudianteModel = new EstudianteModel();
    }


    // ===============================
    // LISTAR PAGOS DEL ESTUDIANTE
    // =============================

    public function indexEstudiante()
    {
        $usuarioId = session('id_usuario');

        // Obtener estudiante
        $estudianteModel = new \App\Models\EstudianteModel();
        $tramiteModel    = new \App\Models\TramiteModel();

        $estudiante = $estudianteModel->getByUsuarioId($usuarioId);

        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }

        // Traer trámites del estudiante
        $tramites = $tramiteModel
            ->where('estudiante_id', $estudiante['id'])
            ->orderBy('fecha_solicitud', 'DESC')
            ->findAll();

        return view('estudiantes/pagos/resumen', [
            'estudiante' => $estudiante,
            'tramites'   => $tramites
        ]);
    }
    // ===============================
    // LISTAR PAGOS DE UN TRÁMITE
    // ===============================
    public function pagosPorTramite($tramiteId)
    {
        $usuarioId  = session('id_usuario');
        $estudiante = $this->estudianteModel->getByUsuarioId($usuarioId);

        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }

        $tramite = $this->tramiteModel->find($tramiteId);

        if (!$tramite || $tramite['estudiante_id'] != $estudiante['id']) {
            return redirect()->back()->with('error', 'Trámite no válido.');
        }

        return view('estudiantes/pagos/index', [
            'tramite' => $tramite,
            'pagos'   => $this->pagoModel->getPagosPorTramite($tramiteId),
            'total'   => $this->pagoModel->totalPagadoTramite($tramiteId)
        ]);
    }

    // ===============================
    // FORMULARIO REGISTRAR PAGO
    // ===============================
    public function nuevo($tramiteId)
    {
        $tramite = $this->tramiteModel->find($tramiteId);

        if (!$tramite) {
            return redirect()->back()->with('error', 'Trámite no encontrado.');
        }

        return view('estudiantes/pagos/nuevo', compact('tramite'));
    }

    // ===============================
    // GUARDAR PAGO
    // ===============================
    public function guardar()
    {
        $tramiteId = $this->request->getPost('tramite_id');
        $monto     = $this->request->getPost('monto');
        $metodo    = $this->request->getPost('metodo_pago');

        if (!$this->tramiteModel->find($tramiteId)) {
            return redirect()->back()->with('error', 'Trámite no válido.');
        }

        if (!is_numeric($monto) || $monto <= 0) {
            return redirect()->back()->with('error', 'Monto inválido.');
        }

        $this->pagoModel->registrarPago($tramiteId, $monto, $metodo);

        $this->tramiteModel->update($tramiteId, [
            'estado' => 'en proceso'
        ]);

        return redirect()->to(base_url("estudiantes/pagos/$tramiteId"))
            ->with('success', 'Pago registrado correctamente.');
    }

    // ===============================
    // VER PAGO
    // ===============================
    public function ver($id)
    {
        $pago = $this->pagoModel->obtenerPago($id);

        if (!$pago) {
            return redirect()->back()->with('error', 'Pago no encontrado.');
        }

        return view('estudiantes/pagos/ver', compact('pago'));
    }


    

    public function comprobante($pagoId)
{
    $pago = $this->pagoModel->obtenerPago($pagoId);

    if (!$pago) {
        return redirect()->back()->with('error', 'Pago no encontrado.');
    }

    $tramite = $this->tramiteModel->find($pago['tramite_id']);

    $estudianteModel = new \App\Models\EstudianteModel();
    $estudiante = $estudianteModel->find($tramite['estudiante_id']);

    return view('estudiantes/pagos/comprobante', [
        'pago'       => $pago,
        'tramite'    => $tramite,
        'estudiante' => $estudiante
    ]);
}


    

}

