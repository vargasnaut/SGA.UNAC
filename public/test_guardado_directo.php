<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TEST ULTRA RÁPIDO - GUARDADO DIRECTO</title>
    <style>
        body { font-family: Arial; margin: 40px; background: #f5f5f5; }
        .success { color: #28a745; font-weight: bold; font-size: 18px; }
        .error { color: #dc3545; font-weight: bold; font-size: 18px; }
        .info { color: #007bff; }
        .box { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        h2 { color: #666; border-bottom: 2px solid #28a745; padding-bottom: 10px; }
        code { background: #f8f9fa; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>✓ TEST ULTRA RÁPIDO - GUARDADO DIRECTO</h1>
    
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // Incluir BD
    require __DIR__ . '/../app/Config/Database.php';
    require __DIR__ . '/../vendor/autoload.php';
    
    $db = \Config\Database::connect();
    
    echo "<div class='box'>";
    echo "<h2>1. CONEXIÓN A BD</h2>";
    try {
        $result = $db->query("SELECT COUNT(*) as total FROM matriculas WHERE estado = 'aprobada'");
        $row = $result->getRow();
        echo "<p class='success'>✓ BD Conectada. Matrículas aprobadas: " . $row->total . "</p>";
    } catch (\Exception $e) {
        echo "<p class='error'>✗ Error: " . $e->getMessage() . "</p>";
        exit;
    }
    echo "</div>";
    
    echo "<div class='box'>";
    echo "<h2>2. TEST DE GUARDADO DIRECTO</h2>";
    
    // Test INSERT en materiales
    echo "<h3>📄 Test Materiales</h3>";
    try {
        $testMaterial = [
            'curso_id' => 1,
            'docente_id' => 1,
            'titulo' => 'TEST_' . date('His'),
            'descripcion' => 'Material de prueba',
            'archivo' => 'test.pdf'
        ];
        
        $db->table('materiales')->insert($testMaterial);
        $idInsertado = $db->insertID();
        
        echo "<p class='success'>✓ Material insertado con ID: $idInsertado</p>";
        
        // Verificar
        $verificar = $db->table('materiales')->where('id', $idInsertado)->get()->getFirstRow('array');
        if ($verificar) {
            echo "<p class='info'>✓ Verificado: " . $verificar['titulo'] . "</p>";
        }
    } catch (\Exception $e) {
        echo "<p class='error'>✗ Error materiales: " . $e->getMessage() . "</p>";
    }
    
    // Test INSERT/UPDATE en calificaciones
    echo "<h3>📊 Test Calificaciones</h3>";
    try {
        // Obtener primera matrícula
        $matricula = $db->table('matriculas')->where('estado', 'aprobada')->get()->getFirstRow('array');
        
        if ($matricula) {
            $testCalif = [
                'matricula_id' => $matricula['id'],
                'componente1' => 15.5,
                'componente2' => 16.0,
                'componente3' => 14.5,
                'nota_final' => 15.33,
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ];
            
            // Verificar si existe
            $existe = $db->table('calificaciones')->where('matricula_id', $matricula['id'])->countAllResults();
            
            if ($existe > 0) {
                $db->table('calificaciones')->where('matricula_id', $matricula['id'])->update($testCalif);
                echo "<p class='success'>✓ Calificación ACTUALIZADA para matrícula {$matricula['id']}</p>";
            } else {
                $db->table('calificaciones')->insert($testCalif);
                echo "<p class='success'>✓ Calificación INSERTADA para matrícula {$matricula['id']}</p>";
            }
            
            // Verificar
            $verificar = $db->table('calificaciones')->where('matricula_id', $matricula['id'])->get()->getFirstRow('array');
            if ($verificar) {
                echo "<p class='info'>✓ Verificado: Nota final = " . $verificar['nota_final'] . "</p>";
            }
        } else {
            echo "<p class='error'>✗ No hay matrículas aprobadas</p>";
        }
    } catch (\Exception $e) {
        echo "<p class='error'>✗ Error calificaciones: " . $e->getMessage() . "</p>";
    }
    
    // Test INSERT/UPDATE en asistencias
    echo "<h3>👥 Test Asistencias</h3>";
    try {
        $matricula = $db->table('matriculas')->where('estado', 'aprobada')->get()->getFirstRow('array');
        
        if ($matricula) {
            $testAsist = [
                'matricula_id' => $matricula['id'],
                'fecha' => date('Y-m-d'),
                'estado' => 'Asistió',
                'hora_registro' => date('Y-m-d H:i:s')
            ];
            
            // Verificar si existe
            $existe = $db->table('asistencias')
                ->where('matricula_id', $matricula['id'])
                ->where('fecha', date('Y-m-d'))
                ->countAllResults();
            
            if ($existe > 0) {
                $db->table('asistencias')
                    ->where('matricula_id', $matricula['id'])
                    ->where('fecha', date('Y-m-d'))
                    ->update(['estado' => 'Asistió', 'hora_registro' => date('Y-m-d H:i:s')]);
                echo "<p class='success'>✓ Asistencia ACTUALIZADA para matrícula {$matricula['id']}</p>";
            } else {
                $db->table('asistencias')->insert($testAsist);
                echo "<p class='success'>✓ Asistencia INSERTADA para matrícula {$matricula['id']}</p>";
            }
            
            // Verificar
            $verificar = $db->table('asistencias')
                ->where('matricula_id', $matricula['id'])
                ->where('fecha', date('Y-m-d'))
                ->get()
                ->getFirstRow('array');
            if ($verificar) {
                echo "<p class='info'>✓ Verificado: Estado = " . $verificar['estado'] . "</p>";
            }
        }
    } catch (\Exception $e) {
        echo "<p class='error'>✗ Error asistencias: " . $e->getMessage() . "</p>";
    }
    echo "</div>";
    
    // Contadores finales
    echo "<div class='box'>";
    echo "<h2>3. CONTADORES FINALES</h2>";
    
    $totalMateriales = $db->table('materiales')->countAllResults();
    $totalCalificaciones = $db->table('calificaciones')->countAllResults();
    $totalAsistencias = $db->table('asistencias')->countAllResults();
    
    echo "<p><strong>📄 Materiales totales:</strong> $totalMateriales</p>";
    echo "<p><strong>📊 Calificaciones totales:</strong> $totalCalificaciones</p>";
    echo "<p><strong>👥 Asistencias totales:</strong> $totalAsistencias</p>";
    echo "</div>";
    
    // Verificar controlador
    echo "<div class='box'>";
    echo "<h2>4. VERIFICAR CONTROLADOR DIRECTO</h2>";
    
    $controllerPath = __DIR__ . '/../app/Controllers/DocentesDirect.php';
    if (file_exists($controllerPath)) {
        echo "<p class='success'>✓ DocentesDirect.php existe</p>";
    } else {
        echo "<p class='error'>✗ DocentesDirect.php NO EXISTE</p>";
    }
    
    $routesPath = __DIR__ . '/../app/Config/Routes.php';
    $routesContent = file_get_contents($routesPath);
    if (strpos($routesContent, 'DocentesDirect') !== false) {
        echo "<p class='success'>✓ Rutas DocentesDirect configuradas</p>";
    } else {
        echo "<p class='error'>✗ Rutas DocentesDirect NO CONFIGURADAS</p>";
    }
    echo "</div>";
    
    echo "<div class='box'>";
    echo "<h2>✓ INSTRUCCIONES FINALES</h2>";
    echo "<p><strong>Si todos los tests están en ✓ verde:</strong></p>";
    echo "<ol>";
    echo "<li>Entra a <code>docentes/facultad/fiis/sistemas/materiales/{id_curso}</code></li>";
    echo "<li>Sube un archivo y guarda</li>";
    echo "<li>Debe mostrar '<strong>✓ Material guardado</strong>'</li>";
    echo "<li>Lo mismo para calificaciones y asistencias</li>";
    echo "</ol>";
    echo "<p class='info'>Las rutas ahora son: <code>docente-direct/material</code>, <code>docente-direct/calificaciones</code>, <code>docente-direct/asistencias</code></p>";
    echo "</div>";
    ?>
</body>
</html>
