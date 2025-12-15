<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * CONTROLADOR ULTRA SIMPLE - GUARDADO DIRECTO SIN VALIDACIONES
 * Solo guarda en BD sin complejidad
 */
class DocentesDirect extends Controller
{
    /**
     * GUARDAR MATERIAL - DIRECTO
     */
    public function material($cursoId)
    {
        $db = \Config\Database::connect();
        
        // Validar sesión
        if (!session('id_usuario')) {
            die('ERROR: Sin sesión');
        }
        
        // Obtener docente
        $docente = $db->table('docentes')
            ->where('usuario_id', session('id_usuario'))
            ->get()
            ->getFirstRow('array');
        
        if (!$docente) {
            die('ERROR: Docente no encontrado');
        }
        
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        
        if (empty($titulo)) {
            return redirect()->back()->with('error', 'Título vacío');
        }
        
        // Subir archivo
        $file = $this->request->getFile('archivo');
        if ($file && $file->isValid()) {
            $uploadDir = FCPATH . 'uploads/materiales';
            @mkdir($uploadDir, 0777, true);
            
            $newName = $file->getRandomName();
            $file->move($uploadDir, $newName);
            
            // GUARDAR EN BD
            $db->table('materiales')->insert([
                'curso_id' => (int)$cursoId,
                'docente_id' => (int)$docente['id'],
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'archivo' => $newName
            ]);
            
            return redirect()->back()->with('success', '✓ Material guardado');
        }
        
        return redirect()->back()->with('error', 'Error archivo');
    }
    
    /**
     * GUARDAR CALIFICACIONES - DIRECTO
     */
    public function calificaciones($cursoId)
    {
        $db = \Config\Database::connect();
        
        if (!session('id_usuario')) {
            die('ERROR: Sin sesión');
        }
        
        $matriculas = $_POST['matriculas'] ?? [];
        
        if (empty($matriculas)) {
            return redirect()->back()->with('error', 'Sin datos');
        }
        
        $guardados = 0;
        
        foreach ($matriculas as $matId => $notas) {
            // Calcular promedio
            $valores = [];
            for ($i = 1; $i <= 5; $i++) {
                if (!empty($notas["componente$i"])) {
                    $valores[] = (float)$notas["componente$i"];
                }
            }
            $promedio = !empty($valores) ? array_sum($valores) / count($valores) : 0;
            
            // Verificar si existe
            $existe = $db->table('calificaciones')
                ->where('matricula_id', (int)$matId)
                ->countAllResults();
            
            $datos = [
                'componente1' => (float)($notas['componente1'] ?? 0),
                'componente2' => (float)($notas['componente2'] ?? 0),
                'componente3' => (float)($notas['componente3'] ?? 0),
                'componente4' => (float)($notas['componente4'] ?? 0),
                'componente5' => (float)($notas['componente5'] ?? 0),
                'nota_final' => $promedio,
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ];
            
            if ($existe > 0) {
                // UPDATE
                $db->table('calificaciones')
                    ->where('matricula_id', (int)$matId)
                    ->update($datos);
            } else {
                // INSERT
                $datos['matricula_id'] = (int)$matId;
                $db->table('calificaciones')->insert($datos);
            }
            
            $guardados++;
        }
        
        return redirect()->back()->with('success', "✓ $guardados calificaciones guardadas");
    }
    
    /**
     * GUARDAR ASISTENCIAS - DIRECTO
     */
    public function asistencias($cursoId)
    {
        $db = \Config\Database::connect();
        
        if (!session('id_usuario')) {
            die('ERROR: Sin sesión');
        }
        
        $asistencias = $_POST['asistencia'] ?? [];
        $fecha = $_POST['fecha_asistencia'] ?? '';
        
        if (empty($asistencias) || empty($fecha)) {
            return redirect()->back()->with('error', 'Datos incompletos');
        }
        
        $guardados = 0;
        
        foreach ($asistencias as $matId => $estado) {
            if (!in_array($estado, ['Asistió', 'Tardanza', 'Falta', 'Justificado'])) {
                continue;
            }
            
            // Verificar si existe
            $existe = $db->table('asistencias')
                ->where('matricula_id', (int)$matId)
                ->where('fecha', $fecha)
                ->countAllResults();
            
            if ($existe > 0) {
                // UPDATE
                $db->table('asistencias')
                    ->where('matricula_id', (int)$matId)
                    ->where('fecha', $fecha)
                    ->update([
                        'estado' => $estado,
                        'hora_registro' => date('Y-m-d H:i:s')
                    ]);
            } else {
                // INSERT
                $db->table('asistencias')->insert([
                    'matricula_id' => (int)$matId,
                    'fecha' => $fecha,
                    'estado' => $estado,
                    'hora_registro' => date('Y-m-d H:i:s')
                ]);
            }
            
            $guardados++;
        }
        
        return redirect()->back()->with('success', "✓ $guardados asistencias guardadas");
    }
}
