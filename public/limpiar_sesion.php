<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Limpiar Sesión - SGA UNAC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .success {
            color: #28a745;
            font-size: 18px;
            margin: 20px 0;
        }
        .info {
            background: #e7f3ff;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>🔧 Limpieza de Sesión</h1>
        
        <div class="info">
            <strong>⚠️ Si recibes el error "ERR_TOO_MANY_REDIRECTS":</strong>
            <ol style="text-align: left; margin-left: 20px;">
                <li>Haz clic en "Limpiar Cookies y Sesión" abajo</li>
                <li>Cierra TODAS las pestañas del navegador</li>
                <li>Abre una nueva ventana</li>
                <li>Vuelve a intentar el login</li>
            </ol>
        </div>

        <div id="status"></div>

        <button class="btn btn-danger" onclick="limpiarTodo()">
            🗑️ Limpiar Cookies y Sesión
        </button>

        <a href="<?= base_url('auth') ?>" class="btn">
            🔐 Ir al Login
        </a>
    </div>

    <script>
        function limpiarTodo() {
            // Limpiar localStorage
            localStorage.clear();
            
            // Limpiar sessionStorage
            sessionStorage.clear();
            
            // Limpiar cookies
            document.cookie.split(";").forEach(function(c) { 
                document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); 
            });
            
            // Mostrar mensaje de éxito
            document.getElementById('status').innerHTML = '<div class="success">✅ Cookies y sesión limpiadas correctamente<br><br>Ahora cierra todas las pestañas y abre una nueva ventana</div>';
            
            // Redirigir después de 3 segundos
            setTimeout(function() {
                window.location.href = '<?= base_url('auth') ?>';
            }, 3000);
        }
    </script>
</body>
</html>
