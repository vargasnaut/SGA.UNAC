<?php

namespace App\Models;

use CodeIgniter\Model;

class PrerrequisitoModel extends Model
{
    protected $table = 'prerrequisitos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'curso_id', 'curso_prerrequisito_id', 'obligatorio'
    ];
    
    public function getPrerrequisitos($cursoId)
    {
        return $this->select('prerrequisitos.*, cursos.nombre as curso_prerrequisito, cursos.codigo_curso')
            ->join('cursos', 'cursos.id = prerrequisitos.curso_prerrequisito_id')
            ->where('prerrequisitos.curso_id', $cursoId)
            ->findAll();
    }
    
    public function validarPrerrequisitos($estudianteId, $cursoId)
    {
        $prerrequisitos = $this->getPrerrequisitos($cursoId);
        
        if (empty($prerrequisitos)) {
            return ['valido' => true, 'pendientes' => []];
        }
        
        $db = \Config\Database::connect();
        $pendientes = [];
        
        foreach ($prerrequisitos as $prereq) {
            // Verificar si el estudiante aprobó el curso prerrequisito (nota_final >= 10.5)
            $resultado = $db->table('matriculas')
                ->select('calificaciones.nota_final, cursos.nombre, cursos.codigo_curso')
                ->join('calificaciones', 'calificaciones.matricula_id = matriculas.id', 'left')
                ->join('cursos', 'cursos.id = matriculas.curso_id')
                ->where('matriculas.estudiante_id', $estudianteId)
                ->where('matriculas.curso_id', $prereq['curso_prerrequisito_id'])
                ->get()
                ->getRowArray();
            
            if (!$resultado || $resultado['nota_final'] === null || $resultado['nota_final'] < 10.5) {
                $pendientes[] = [
                    'codigo' => $prereq['codigo_curso'],
                    'nombre' => $prereq['curso_prerrequisito'],
                    'aprobado' => $resultado ? ($resultado['nota_final'] ?? 0) : 0
                ];
            }
        }
        
        return [
            'valido' => empty($pendientes),
            'pendientes' => $pendientes
        ];
    }
}
