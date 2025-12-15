<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($titulo ?? 'SGA - Sistema de Gestión Académica') ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .sidebar .logo {
            text-align: center;
            padding: 20px;
            color: white;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .logo h4 {
            margin: 10px 0 5px 0;
            font-weight: bold;
        }
        .sidebar .logo small {
            color: #bdc3c7;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 25px;
            margin: 5px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(52, 152, 219, 0.2);
            color: #3498db;
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            background-color: #3498db;
            color: white;
        }
        .sidebar .nav-link i {
            width: 25px;
            margin-right: 10px;
        }
        .main-content {
            margin-left: 260px;
            padding: 0;
        }
        .top-navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .content-area {
            padding: 0 30px 30px 30px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: white;
            border-bottom: 2px solid #f1f3f5;
            font-weight: 600;
            padding: 15px 20px;
        }
        .btn {
            border-radius: 8px;
            padding: 8px 20px;
        }
        .table {
            margin-bottom: 0;
        }
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
        }
        
        /* Chat IA Widget */
        #chat-widget {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 400px;
            max-height: 500px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            display: none;
            flex-direction: column;
            z-index: 9999;
            overflow: hidden;
        }
        #chat-widget.active {
            display: flex;
        }
        #chat-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            z-index: 9998;
            transition: all 0.3s ease;
        }
        #chat-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.6);
        }
        #chat-toggle.hidden {
            display: none;
        }
        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .chat-header h6 {
            margin: 0;
            font-weight: 600;
        }
        .chat-close {
            background: transparent;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 0;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
        }
        .chat-close:hover {
            background: rgba(255,255,255,0.2);
        }
        #chat-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            max-height: 350px;
            background: #f8f9fa;
        }
        #chat-messages p {
            margin: 8px 0;
            padding: 10px 14px;
            border-radius: 12px;
            max-width: 85%;
            word-wrap: break-word;
        }
        #chat-messages .usuario {
            background: #667eea;
            color: white;
            margin-left: auto;
            text-align: right;
        }
        #chat-messages .bot {
            background: white;
            color: #333;
            border: 1px solid #e0e0e0;
        }
        .chat-input-area {
            padding: 12px;
            border-top: 1px solid #e0e0e0;
            background: white;
            display: flex;
            gap: 8px;
        }
        .chat-input-area input {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 10px 16px;
            font-size: 14px;
            outline: none;
        }
        .chat-input-area input:focus {
            border-color: #667eea;
        }
        .chat-input-area button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            transition: transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .chat-input-area button:hover {
            transform: scale(1.05);
        }
        @media (max-width: 768px) {
            #chat-widget {
                width: calc(100vw - 40px);
                right: 20px;
                bottom: 20px;
            }
        }
    </style>
</head>
<body>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-graduation-cap fa-3x mb-2"></i>
            <h4>SGA UNAC</h4>
            <small>Sistema de Gestión Académica</small>
        </div>
        
        <nav class="nav flex-column">
            <?php 
            $rol_id = session('rol_id');
            $current_url = current_url();
            ?>
            
            <?php if ($rol_id == 1): // ADMINISTRADOR ?>
                <a class="nav-link <?= strpos($current_url, 'dashboard/admin') !== false ? 'active' : '' ?>" href="<?= base_url('dashboard/admin') ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                
                <a class="nav-link <?= strpos($current_url, 'administradores/reportes/matriculas') !== false ? 'active' : '' ?>" href="<?= base_url('administradores/reportes/matriculas') ?>">
                    <i class="fas fa-chart-bar"></i> Reportes de Matrícula
                </a>
                
                <a class="nav-link <?= strpos($current_url, 'administradores/docentes') !== false ? 'active' : '' ?>" href="<?= base_url('administradores/docentes') ?>">
                    <i class="fas fa-chalkboard-teacher"></i> Gestión Docentes
                </a>
                <a class="nav-link <?= strpos($current_url, 'administradores/administrativos') !== false ? 'active' : '' ?>" href="<?= base_url('administradores/administrativos') ?>">
                    <i class="fas fa-users-cog"></i> Gestión Administrativos
                </a>
                                

                <a class="nav-link" href="<?= base_url('assets/programacion_2025B.png') ?>" target="_blank">
                    <i class="fas fa-calendar-alt"></i> Programación Horaria
                </a>
                <a class="nav-link <?= strpos($current_url, 'administradores/perfil') !== false ? 'active' : '' ?>" href="<?= base_url('administradores/perfil') ?>">
                    <i class="fas fa-user"></i> Mi Perfil
                </a>
                
            <?php elseif ($rol_id == 2): // DOCENTE ?>
                <a class="nav-link <?= strpos($current_url, 'dashboard/docente') !== false ? 'active' : '' ?>" href="<?= base_url('dashboard/docente') ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link <?= strpos($current_url, 'docentes/cursos') !== false ? 'active' : '' ?>" href="<?= base_url('docentes/cursos') ?>">
                    <i class="fas fa-book"></i> Mis Cursos
                </a>
                <a class="nav-link <?= strpos($current_url, 'docentes/notificaciones') !== false ? 'active' : '' ?>" href="<?= base_url('docentes/notificaciones') ?>">
                    <i class="fas fa-bell"></i> Notificaciones
                </a>

                <a class="nav-link <?= strpos($current_url, 'docentes/perfil') !== false ? 'active' : '' ?>" href="<?= base_url('docentes/perfil') ?>">
                    <i class="fas fa-user"></i> Mi Perfil
                </a>
                
            <?php elseif ($rol_id == 3): // ESTUDIANTE ?>
                <a class="nav-link <?= strpos($current_url, 'dashboard/estudiante') !== false ? 'active' : '' ?>" href="<?= base_url('dashboard/estudiante') ?>">
                    <i class="fas fa-tachometer-alt"></i> Inicios
                </a>
                <a class="nav-link <?= strpos($current_url, 'estudiantes/matricula/solicitar') !== false ? 'active' : '' ?>" href="<?= base_url('estudiantes/matricula/solicitar') ?>">
                    <i class="fas fa-file-upload"></i> Solicitar Matrícula
                </a>
                <a class="nav-link <?= strpos($current_url, 'estudiantes/matricula/seleccionar') !== false ? 'active' : '' ?>" href="<?= base_url('estudiantes/matricula/seleccionar') ?>">
                    <i class="fas fa-list"></i> Realizar Matrícula
                </a>
                <a class="nav-link <?= strpos($current_url, 'estudiantes/matriculas') !== false ? 'active' : '' ?>" href="<?= base_url('estudiantes/matriculas') ?>">
                    <i class="fas fa-clipboard-list"></i> Mis Matrículas
                </a>
                <a class="nav-link <?= strpos($current_url, 'estudiantes/tramites') !== false ? 'active' : '' ?>" href="<?= base_url('estudiantes/tramites') ?>">
                    <i class="fas fa-file-alt"></i> Mis Trámites
                </a>
                <a class="nav-link <?= strpos($current_url, 'estudiantes/pagos') !== false ? 'active' : '' ?>" href="<?= base_url('estudiantes/pagos') ?>">
                    <i class="fas fa-money-bill-wave"></i> Mis Pagos
                </a>
                <a class="nav-link <?= strpos($current_url, 'estudiantes/notificaciones') !== false ? 'active' : '' ?>" href="<?= base_url('estudiantes/notificaciones') ?>">
                    <i class="fas fa-bell"></i> Notificaciones
                </a>
                <a class="nav-link <?= strpos($current_url, 'estudiantes/perfil') !== false ? 'active' : '' ?>" href="<?= base_url('estudiantes/perfil') ?>">
                    <i class="fas fa-user"></i> Mi Perfil
                </a>
                
            <?php elseif ($rol_id == 4): // ADMINISTRATIVO ?>
                <a class="nav-link <?= strpos($current_url, 'dashboard/administrativo') !== false ? 'active' : '' ?>" href="<?= base_url('dashboard/administrativo') ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                
                <a class="nav-link <?= strpos($current_url, 'administrativos/matriculas/solicitudes') !== false ? 'active' : '' ?>" href="<?= base_url('administrativos/matriculas/solicitudes') ?>">
                    <i class="fas fa-clipboard-check"></i> Solicitudes de Matrícula
                </a>
                
                <a class="nav-link <?= strpos($current_url, 'administrativos/estudiantes/por-ciclo') !== false ? 'active' : '' ?>" href="<?= base_url('administrativos/estudiantes/por-ciclo') ?>">
                    <i class="fas fa-users"></i> Estudiantes por Ciclo
                </a>
                
                <a class="nav-link <?= strpos($current_url, 'administrativos/tramites') !== false && strpos($current_url, 'matriculas') === false ? 'active' : '' ?>" href="<?= base_url('administrativos/tramites') ?>">
                    <i class="fas fa-file-alt"></i> Gestión Trámites
                </a>
                <a class="nav-link <?= strpos($current_url, 'administrativos/notificaciones') !== false ? 'active' : '' ?>" href="<?= base_url('administrativos/notificaciones') ?>">
                    <i class="fas fa-bell"></i> Notificaciones
                </a>
                <a class="nav-link <?= strpos($current_url, 'administrativos/perfil') !== false ? 'active' : '' ?>" href="<?= base_url('administrativos/perfil') ?>">
                    <i class="fas fa-user"></i> Mi Perfil
                </a>
            <?php endif; ?>
            
            <hr style="border-color: rgba(255,255,255,0.2); margin: 20px 15px;">
            
            <a class="nav-link" href="<?= base_url('auth/logout') ?>">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><?= esc($titulo ?? 'Panel de Control') ?></h5>
                </div>
                <div>
                    <span class="text-muted me-3">
                        <i class="fas fa-user-circle me-1"></i>
                        <?= esc(session('nombre')) ?>
                    </span>
                    <span class="badge bg-primary">
                        <?php
                        $roles = [1 => 'Administrador', 2 => 'Docente', 3 => 'Estudiante', 4 => 'Administrativo'];
                        echo $roles[$rol_id] ?? 'Usuario';
                        ?>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="content-area">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?= $this->renderSection('contenido') ?>
        </div>
    </div>
    
    <!-- Chat IA Widget -->
    <button id="chat-toggle" onclick="toggleChat()">
        <i class="fas fa-robot"></i>
    </button>
    
    <div id="chat-widget">
        <div class="chat-header">
            <h6><i class="fas fa-robot me-2"></i>Asistente Virtual SGA</h6>
            <button class="chat-close" onclick="toggleChat()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="chat-messages"></div>
        <div class="chat-input-area">
            <input id="chat-input" type="text" placeholder="Escribe tu pregunta..." onkeypress="if(event.key==='Enter') enviarMensaje()" />
            <button onclick="enviarMensaje()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chat IA Script -->
    <script>
        const OPENROUTER_KEY = "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";
        
        function toggleChat() {
            const widget = document.getElementById('chat-widget');
            const toggle = document.getElementById('chat-toggle');
            
            if (widget.classList.contains('active')) {
                widget.classList.remove('active');
                toggle.classList.remove('hidden');
            } else {
                widget.classList.add('active');
                toggle.classList.add('hidden');
                document.getElementById('chat-input').focus();
            }
        }
        
        async function enviarMensaje() {
            const chatMessages = document.getElementById("chat-messages");
            const inputField = document.getElementById("chat-input");
            const texto = inputField.value.trim();
            
            if (!texto) return;
            
            // Mostrar mensaje del usuario
            chatMessages.innerHTML += `<p class="usuario">Tú: ${texto}</p>`;
            inputField.value = "";
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            // Mostrar indicador de carga
            chatMessages.innerHTML += `<p class="bot" id="loading-msg"><i class="fas fa-spinner fa-spin me-2"></i>Escribiendo...</p>`;
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            try {
                const response = await fetch("https://openrouter.ai/api/v1/chat/completions", {
                    method: "POST",
                    headers: {
                        Authorization: `Bearer ${OPENROUTER_KEY}`,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        model: "openai/gpt-3.5-turbo",
                        messages: [{
                            role: "system",
                            content: "Eres un asistente virtual del Sistema de Gestión Académica (SGA) de la UNAC. Ayudas a estudiantes, docentes y personal administrativo con preguntas sobre trámites, matrículas, notificaciones y procesos académicos. Sé claro, conciso y amable."
                        }, {
                            role: "user",
                            content: texto
                        }]
                    })
                });
                
                const data = await response.json();
                
                // Eliminar indicador de carga
                document.getElementById("loading-msg").remove();
                
                // Mostrar respuesta del bot
                const botResponse = data.choices[0].message.content;
                chatMessages.innerHTML += `<p class="bot">Bot: ${botResponse}</p>`;
            } catch (error) {
                // Eliminar indicador de carga
                const loadingMsg = document.getElementById("loading-msg");
                if (loadingMsg) loadingMsg.remove();
                
                chatMessages.innerHTML += `<p class="bot" style="color: #dc3545;">Error: No se pudo conectar con el asistente. Intenta más tarde.</p>`;
            }
            
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>

