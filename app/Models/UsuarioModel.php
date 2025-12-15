<?php 
namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username',
        'password',
        'email',
        'rol_id',
        'estado',
        'fecha_registro'
    ];
}
