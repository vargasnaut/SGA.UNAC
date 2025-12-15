<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materiales';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $returnType = 'array';

    protected $allowedFields = [
        'curso_id', 'docente_id', 'titulo', 'descripcion', 'archivo', 'fecha_subida'
    ];
    
    /**
     * Obtener materiales por curso con información del docente
     */
    public function getMaterialesPorCurso($cursoId)
    {
        return $this->select('materiales.*, docentes.nombres, docentes.apellidos')
                    ->join('docentes', 'docentes.id = materiales.docente_id', 'left')
                    ->where('materiales.curso_id', $cursoId)
                    ->orderBy('materiales.fecha_subida', 'DESC')
                    ->findAll();
    }

    /**
     * Verificar si el archivo existe
     */
    public function verificarArchivo($materialId)
    {
        $material = $this->find($materialId);
        if (!$material) {
            return false;
        }
        
        $path = FCPATH . 'uploads/materiales/' . $material['archivo'];
        return file_exists($path);
    }

    /**
     * Obtener extensión del archivo
     */
    public function getExtension($archivo)
    {
        return strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
    }

    /**
     * Validar tipo de archivo permitido
     */
    public function esTipoPermitido($archivo)
    {
        $permitidos = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'gif', 'zip', 'rar'];
        $extension = $this->getExtension($archivo);
        return in_array($extension, $permitidos);
    }

    /**
     * Obtener icono según tipo de archivo
     */
    public function getIcono($archivo)
    {
        $extension = $this->getExtension($archivo);
        
        $iconos = [
            'pdf' => 'fa-file-pdf text-danger',
            'doc' => 'fa-file-word text-primary',
            'docx' => 'fa-file-word text-primary',
            'ppt' => 'fa-file-powerpoint text-warning',
            'pptx' => 'fa-file-powerpoint text-warning',
            'xls' => 'fa-file-excel text-success',
            'xlsx' => 'fa-file-excel text-success',
            'jpg' => 'fa-file-image text-info',
            'jpeg' => 'fa-file-image text-info',
            'png' => 'fa-file-image text-info',
            'gif' => 'fa-file-image text-info',
            'zip' => 'fa-file-archive text-secondary',
            'rar' => 'fa-file-archive text-secondary',
        ];
        
        return $iconos[$extension] ?? 'fa-file text-muted';
    }

    /**
     * Eliminar material con su archivo físico
     */
    public function eliminarMaterial($materialId)
    {
        $material = $this->find($materialId);
        if (!$material) {
            return false;
        }
        
        // Eliminar archivo físico
        $path = FCPATH . 'uploads/materiales/' . $material['archivo'];
        if (file_exists($path)) {
            @unlink($path);
        }
        
        // Eliminar registro
        return $this->delete($materialId);
    }
}
