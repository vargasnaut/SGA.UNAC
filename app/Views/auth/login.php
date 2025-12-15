<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión | SGA UNAC</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        /* Mantener fondo original pero agregar efectos */
        .login-background {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        /* Tarjeta de login mejorada con glassmorphism */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15),
                        0 0 0 1px rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.4);
            animation: slideIn 0.6s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 15px;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .text-center h1 {
            font-size: 22px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 5px;
        }
        
        .text-center p {
            font-size: 14px;
            color: #718096;
        }
        
        /* Inputs mejorados */
        .form-floating {
            margin-bottom: 20px;
        }
        
        .form-floating input {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        
        .form-floating input:focus {
            border-color: #0056b3;
            box-shadow: 0 0 0 4px rgba(0, 86, 179, 0.1);
            outline: none;
        }
        
        .form-floating label {
            padding-left: 16px;
            color: #718096;
        }
        
        /* Botón mejorado */
        .btn-primary {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            background-color: #0056b3;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3);
        }
        
        .btn-primary:hover {
            background-color: #003f80;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 86, 179, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        /* Link mejorado */
        .text-center a {
            color: #0056b3;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        
        .text-center a:hover {
            color: #003f80;
        }
        
        /* Alert mejorado */
        .alert {
            border-radius: 12px;
            border: none;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                padding: 30px 20px;
                border-radius: 20px;
            }
            
            .text-center h1 {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="login-background">
        <div class="login-card">
            <div class="text-center mb-4">
                <img src="<?= base_url('assets/img/logo_unac.jpg') ?>" alt="Logo UNAC" class="logo-img">
                <h1>Universidad Nacional del Callao</h1>
                <p>Sistema de Gestión Académica</p>
            </div>

            <?php if (session()->getFlashdata('msg')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('msg') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/login') ?>" method="post">
                <div class="form-floating">
                    <input type="text" name="email" class="form-control" id="floatingInput" placeholder="Usuario o correo" required>
                    <label for="floatingInput">
                        <i class="fas fa-user me-2"></i>Usuario o correo
                    </label>
                </div>

                <div class="form-floating">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Contraseña" required>
                    <label for="floatingPassword">
                        <i class="fas fa-lock me-2"></i>Contraseña
                    </label>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                    </button>
                </div>

                <div class="text-center">
                    <a href="#">
                        <i class="fas fa-question-circle me-1"></i>¿Olvidaste tu contraseña?
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
