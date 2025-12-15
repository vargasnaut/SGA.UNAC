<?php

namespace App\Models;

use CodeIgniter\Model;

class FormulaCalificacionModel extends Model
{
    protected $table = 'formulas_calificacion';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $returnType = 'array';

    protected $allowedFields = [
        'curso_id', 
        'nombre_componente', 
        'porcentaje', 
        'orden', 
        'activo', 
        'fecha_creacion'
    ];

    /**
     * Obtener todas las fórmulas activas de un curso ordenadas
     */
    public function getFormulasPorCurso($cursoId)
    {
        return $this->where('curso_id', $cursoId)
                    ->where('activo', 1)
                    ->orderBy('orden', 'ASC')
                    ->findAll();
    }

    /**
     * Validar que los porcentajes sumen 100%
     */
    public function validarPorcentajes($cursoId)
    {
        $formulas = $this->getFormulasPorCurso($cursoId);
        $total = 0;
        foreach ($formulas as $formula) {
            $total += $formula['porcentaje'];
        }
        return abs($total - 100.0) < 0.01; // Tolerancia de 0.01
    }

    /**
     * Calcular nota final basada en fórmula
     */
    public function calcularNotaFinal($componentes, $cursoId)
    {
        $formulas = $this->getFormulasPorCurso($cursoId);
        $notaFinal = 0;
        
        foreach ($formulas as $index => $formula) {
            $componenteKey = 'componente' . ($index + 1);
            if (isset($componentes[$componenteKey]) && $componentes[$componenteKey] !== null) {
                $notaFinal += ($componentes[$componenteKey] * $formula['porcentaje']) / 100;
            }
        }
        
        return round($notaFinal, 2);
    }

    /**
     * Crear fórmula por defecto para un curso
     */
    public function crearFormulaPorDefecto($cursoId)
    {
        $formulasDefault = [
            ['nombre_componente' => 'Prácticas Calificadas (PC)', 'porcentaje' => 30.00, 'orden' => 1],
            ['nombre_componente' => 'Examen Parcial (EP)', 'porcentaje' => 30.00, 'orden' => 2],
            ['nombre_componente' => 'Examen Final (EF)', 'porcentaje' => 40.00, 'orden' => 3],
        ];

        foreach ($formulasDefault as $formula) {
            $this->insert([
                'curso_id' => $cursoId,
                'nombre_componente' => $formula['nombre_componente'],
                'porcentaje' => $formula['porcentaje'],
                'orden' => $formula['orden'],
                'activo' => 1
            ]);
        }
    }

    /**
     * Actualizar fórmulas de un curso
     */
    public function actualizarFormulas($cursoId, $formulas)
    {
        // Desactivar todas las fórmulas existentes
        $this->where('curso_id', $cursoId)->set(['activo' => 0])->update();
        
        // Insertar o actualizar nuevas fórmulas
        foreach ($formulas as $index => $formula) {
            if (!empty($formula['nombre']) && !empty($formula['porcentaje'])) {
                $this->insert([
                    'curso_id' => $cursoId,
                    'nombre_componente' => $formula['nombre'],
                    'porcentaje' => floatval($formula['porcentaje']),
                    'orden' => $index + 1,
                    'activo' => 1
                ]);
            }
        }
    }
}
