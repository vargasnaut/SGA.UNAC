
# ESTRUCTURA DEL SISTEMA (v2.0)

```
sga_final/
│
├── LEEME.txt                  ← Guía rápida de inicio
├── README.md                  ← Documentación completa y técnica
├── sga_unac.sql               ← Base de datos principal
├── actualizacion_sistema.sql  ← Script de actualización (tablas y columnas nuevas)
├── composer.json              ← Dependencias PHP
├── env, .env                  ← Variables de entorno
│
├── app/                       ← Aplicación principal (CodeIgniter 4)
│   ├── Controllers/           ← Controladores (Auth, Dashboard, Docentes, DocentesDirect, Estudiantes, Administrativos, Administradores, etc.)
│   ├── Models/                ← Modelos de datos (incluye FormulaCalificacionModel, HorarioCursoModel)
│   ├── Views/                 ← Vistas HTML/PHP (paneles, materiales, calificaciones, asistencia, etc.)
│   └── Config/                ← Configuración (Database, Routes, etc.)
│
├── public/                    ← Carpeta pública (DocumentRoot)
│   ├── index.php              ← Punto de entrada
│   ├── assets/                ← CSS, JS, imágenes
│   ├── uploads/               ← Archivos subidos
│   │   └── materiales/        ← Materiales de docentes
│   └── test_guardado_directo.php ← Test de guardado directo
│
├── system/                    ← Framework CodeIgniter 4
├── writable/                  ← Logs, cache, sesiones, uploads temporales
│
├── scripts_sql/               ← Scripts SQL de soporte
├── documentacion/             ← Guías, manuales y credenciales
└── tests/                     ← Pruebas unitarias
```

---

## 🎯 Archivos Clave por Función


### Archivos clave por función

#### Para usuarios (inicio)
- LEEME.txt — Guía rápida
- README.md — Documentación completa

#### Para instalación
- sga_unac.sql — Base de datos
- actualizacion_sistema.sql — Script de actualización
- scripts_sql/ — Scripts de soporte

#### Para desarrollo
- app/Controllers/ — Lógica de negocio (incluye DocentesDirect)
- app/Models/ — Acceso a datos (incluye fórmulas y horarios)
- app/Views/ — Interfaz de usuario (paneles, materiales, calificaciones, asistencia)

#### Para configuración
- app/Config/Database.php — Conexión BD
- app/Config/App.php — URL base
- app/Config/Routes.php — Rutas del sistema

#### Para soporte
- documentacion/ — Guías y soluciones
- writable/logs/ — Logs de errores

---

## 📊 Resumen de Archivos


### Archivos esenciales
- sga_unac.sql — Base de datos
- actualizacion_sistema.sql — Script de actualización
- LEEME.txt — Guía rápida
- README.md — Documentación
- app/ — Aplicación principal
- public/ — Punto de entrada
- system/ — Framework

### Archivos de soporte
- scripts_sql/ — Scripts útiles
- documentacion/ — Guías de uso
- writable/ — Logs y cache

### Archivos opcionales
- tests/ — Pruebas unitarias
- .env, env — Configuración
- composer.json — Dependencias PHP
- phpunit.xml.dist — Configuración de tests

---

## 🔍 Dónde Encontrar Cada Cosa

### Quiero cambiar el logo
📂 `public/assets/images/`

### Quiero modificar estilos
📂 `public/assets/css/`

### Quiero agregar un nuevo módulo
📂 `app/Controllers/` + `app/Views/`

### Quiero revisar errores
📂 `writable/logs/log-YYYY-MM-DD.log`


### Quiero ver archivos subidos
📂 public/uploads/materiales/ — Materiales de docentes


### Quiero modificar usuarios
📂 scripts_sql/corregir_usuarios.sql

### Quiero leer la guía completa

📄 README.md
📂 documentacion/GUIA_PRUEBAS.md

---


## ✨ Cambios y mejoras recientes (v2.0)

- Nuevo controlador DocentesDirect para guardado directo
- Nuevas tablas: formulas_calificacion, horarios_curso
- Nuevas vistas: materiales, calificaciones, asistencia (panel docente)
- Test de guardado directo: public/test_guardado_directo.php
- Seguridad mejorada: CSRF, validación de roles, archivos
- Organización y limpieza de archivos y carpetas

Todo está ordenado, documentado y listo para usar.
