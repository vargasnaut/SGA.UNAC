<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $userModel = new UsuarioModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // Buscar por email o username
        $user = $userModel->where('email', $email)
                          ->orWhere('username', $email)
                          ->first();

        if ($user) {
            // 🔹 Comparación directa SIN password_verify (solo para pruebas)
            if ($password === $user['password']) {
                if ($user['estado'] === 'inactivo') {
                    $session->setFlashdata('msg', 'Tu cuenta está inactiva.');
                    return redirect()->to(base_url('auth'));
                }

                $ses_data = [
                    'id_usuario' => $user['id'],
                    'nombre'     => $user['username'],
                    'email'      => $user['email'],
                    'rol_id'     => $user['rol_id'],
                    'isLoggedIn' => true
                ];
                $session->set($ses_data);

                return redirect()->to(base_url('dashboard'));
            } else {
                $session->setFlashdata('msg', 'Contraseña incorrecta.');
            }
        } else {
            $session->setFlashdata('msg', 'Usuario no encontrado.');
        }

        return redirect()->to(base_url('auth'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth'));
    }
}

