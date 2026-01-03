# 📚 SISTEMA DE GESTIÓN ACADÉMICA - SGA UNAC

## 🎯 Descripción General

Sistema de Gestión Académica desarrollado para la Universidad Nacional del Callao (UNAC) que permite la administración integral de procesos académicos entre docentes, estudiantes y administrativos.

**Tecnologías**: PHP 8.2 + CodeIgniter 4 + MySQL/MariaDB + Bootstrap 5

---

## 📂 ESTRUCTURA DEL PROYECTO

```
sga/
├── app/                          # Aplicación CodeIgniter
│   ├── Controllers/              # Controladores MVC
│   │   ├── Auth.php             # Autenticación
│   │   ├── Dashboard.php        # Paneles por rol
│   │   ├── Docentes.php         # Funciones docente (completas)
│   │   ├── DocentesDirect.php   # ⭐ Guardado directo (NUEVO)
│   │   ├── Estudiantes.php      # Funciones estudiante
│   │   ├── Administrativos.php  # Funciones administrativo
│   │   └── Administradores.php  # Gestión del sistema
│   │
│   ├── Models/                   # Modelos de datos
│   │   ├── DocenteModel.php
│   │   ├── EstudianteModel.php
│   │   ├── CursoModel.php
│   │   ├── MatriculaModel.php
│   │   ├── CalificacionModel.php
│   │   ├── AsistenciaModel.php
│   │   ├── MaterialModel.php
│   │   ├── FormulaCalificacionModel.php  # ⭐ NUEVO
│   │   └── HorarioCursoModel.php         # ⭐ NUEVO
│   │
│   ├── Views/                    # Vistas (HTML + PHP)
│   │   ├── layout/              # Plantilla base
│   │   ├── auth/                # Login/registro
│   │   ├── dashboard/           # Paneles principales
│   │   ├── docentes/
│   │   │   └── fiis/
│   │   │       ├── materiales.php      # ⭐ Subir archivos
│   │   │       ├── calificaciones.php  # ⭐ Ingresar notas
│   │   │       └── asistencia.php      # ⭐ Registro asistencia
│   │   ├── estudiantes/         # Vistas estudiante
│   │   └── administrativos/     # Vistas administrativo
│   │
│   └── Config/
│       ├── Database.php         # Configuración BD
│       └── Routes.php           # Rutas del sistema
│
├── public/                       # Carpeta pública (DocumentRoot)
│   ├── index.php                # Punto de entrada
│   ├── assets/                  # CSS, JS, imágenes
│   ├── uploads/
│   │   └── materiales/          # ⭐ Archivos subidos (NUEVO)
│   └── test_guardado_directo.php  # Test de verificación
│
├── system/                       # Framework CodeIgniter 4
├── writable/                     # Logs, cache, sesiones
├── vendor/                       # Dependencias Composer
│
├── .env                         # Variables de entorno
├── composer.json                # Dependencias PHP
├── spark                        # CLI de CodeIgniter
│
└── Documentación:
    ├── README.md                           # ⭐ Este archivo
    ├── ESTRUCTURA.md                       # Detalle técnico
    ├── actualizacion_sistema.sql          # Script de actualización BD
    └── sga_unac.sql                       # BD completa
```

---

## 🚀 INSTALACIÓN Y CONFIGURACIÓN

### 1. Requisitos previos
- PHP 8.2 o superior
- MySQL 5.7+ / MariaDB 10.3+
- Servidor web (Apache/Nginx)
- Composer

### 2. Clonar/copiar proyecto
```bash
# Copiar a htdocs (XAMPP) o directorio del servidor
cp -r sga /xampp/htdocs/
cd /xampp/htdocs/sga
```

### 3. Instalar dependencias
```bash
composer install
```

### 4. Configurar base de datos
```bash
# Crear BD en MySQL
mysql -u root -p
CREATE DATABASE sga_unac;
EXIT;

# Importar estructura completa
mysql -u root -p sga_unac < sga_unac.sql

# Ejecutar actualizaciones (materiales, calificaciones, asistencias)
mysql -u root -p sga_unac < actualizacion_sistema.sql
```

### 5. Configurar `.env`
```bash
# Copiar archivo de ejemplo
cp env .env

# Editar credenciales de BD
nano .env
```

```env
# Base de datos
database.default.hostname = localhost
database.default.database = sga_unac
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

### 6. Configurar permisos
```bash
# Dar permisos de escritura
chmod -R 777 writable/
chmod -R 777 public/uploads/
```

### 7. Iniciar servidor
```bash
# Opción 1: Servidor integrado de PHP
php spark serve

# Opción 2: Apache (XAMPP)
# Acceder a: http://localhost/sga/public
```

### 8. Verificar instalación
```
http://localhost/sga/public/test_guardado_directo.php
```
Debe mostrar todos los tests en ✓ verde.

---

## 🎓 FUNCIONALIDADES PRINCIPALES

### 👨‍🏫 MÓDULO DOCENTE

#### 1. 📄 Gestión de Materiales
- Subir archivos (PDF, DOC, PPT, imágenes, etc.)
- Máximo 10MB por archivo
- Los estudiantes pueden descargar
- Historial de materiales subidos

**Ruta**: `docente-direct/material/{curso_id}`  
**Vista**: `app/Views/docentes/fiis/materiales.php`

#### 2. 📊 Gestión de Calificaciones
- Hasta 5 componentes configurables (PC, EP, EF, etc.)
- Cálculo automático de nota final
- Estadísticas en tiempo real:
  - Promedio del curso
  - Nota máxima y mínima
  - Aprobados vs desaprobados
- Guardado directo sin recargar

**Ruta**: `docente-direct/calificaciones/{curso_id}`  
**Vista**: `app/Views/docentes/fiis/calificaciones.php`

**Base de datos**:
```sql
calificaciones:
- componente1-5 (DECIMAL)
- nota_final (calculada)
- fecha_actualizacion

formulas_calificacion:
- nombre_componente
- porcentaje (0-100)
```

#### 3. 👥 Registro de Asistencia
Sistema estilo OpenBravo con 4 estados:
- ✓ **Asistió**
- ⏰ **Tardanza**
- ✗ **Falta**
- 📋 **Justificado**

**Características**:
- Registro por fecha
- Selector rápido de próximos días de clase
- Porcentaje de asistencia individual
- Resumen general del curso

**Ruta**: `docente-direct/asistencias/{curso_id}`  
**Vista**: `app/Views/docentes/fiis/asistencia.php`

---

### 👨‍🎓 MÓDULO ESTUDIANTE

- Ver materiales de cursos matriculados
- Descargar archivos
- Consultar calificaciones por componente
- Ver historial de asistencias
- Porcentaje de asistencia acumulado
- Solicitar matrículas
- Gestionar trámites

---

### 👔 MÓDULO ADMINISTRATIVO

- Gestionar notificaciones
- Aprobar/rechazar trámites
- Revisar solicitudes de matrícula
- Ver reportes de matrículas
- Gestionar estudiantes por ciclo

---

### 🔐 MÓDULO ADMINISTRADOR

- CRUD de docentes
- CRUD de administrativos
- Gestión de usuarios
- Configuración del sistema

---

## 🗄️ BASE DE DATOS

### Tablas principales:
- `usuarios` - Credenciales del sistema
- `estudiantes`, `docentes`, `administrativos` - Perfiles
- `cursos` - Información de asignaturas
- `matriculas` - Inscripciones estudiante-curso
- `calificaciones` - Notas con componentes
- `asistencias` - Registro de presencia
- `materiales` - Archivos compartidos
- `formulas_calificacion` ⭐ NUEVA
- `horarios_curso` ⭐ NUEVA

### Archivos SQL:
1. **`sga_unac.sql`** - Base de datos completa (estructura + datos iniciales)
2. **`actualizacion_sistema.sql`** - Mejoras recientes (ejecutar después de sga_unac.sql)

---

## 🔧 CONFIGURACIÓN AVANZADA

### Rutas del sistema (`app/Config/Routes.php`):

```php
// Autenticación
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');

// Docentes - Guardado directo ⭐
$routes->post('docente-direct/material/(:num)', 'DocentesDirect::material/$1');
$routes->post('docente-direct/calificaciones/(:num)', 'DocentesDirect::calificaciones/$1');
$routes->post('docente-direct/asistencias/(:num)', 'DocentesDirect::asistencias/$1');

// Docentes - Funciones completas
$routes->get('docentes/cursos', 'Docentes::cursos');
$routes->get('docentes/facultad/fiis/sistemas/materiales/(:num)', 'Docentes::fiisSistemasMateriales/$1');
$routes->get('docentes/facultad/fiis/sistemas/calificaciones/(:num)', 'Docentes::fiisSistemasCalificaciones/$1');
$routes->get('docentes/facultad/fiis/sistemas/asistencia/(:num)', 'Docentes::fiisSistemasAsistencia/$1');

// Estudiantes
$routes->get('estudiantes/materiales/(:num)', 'Estudiantes::verMateriales/$1');
$routes->get('estudiantes/calificaciones/(:num)', 'Estudiantes::verCalificaciones/$1');
$routes->get('estudiantes/asistencias/(:num)', 'Estudiantes::verAsistencias/$1');
```

---

## 🛠️ SOLUCIÓN DE PROBLEMAS

### Problema: "No se guardan los datos"
**Solución**:
1. Verificar que uses rutas `docente-direct/*` (no `docentes/*`)
2. Ejecutar test: `http://localhost/sga/public/test_guardado_directo.php`
3. Verificar permisos de `writable/` y `public/uploads/`

### Problema: "Método no permitido"
**Solución**: Asegurarse de usar controlador `DocentesDirect` en las vistas.

### Problema: "Archivo muy grande"
**Solución**: 
```php
// En php.ini:
upload_max_filesize = 10M
post_max_size = 10M
```

### Problema: "Error 404 en rutas"
**Solución**:
```bash
# Limpiar cache de CodeIgniter
php spark cache:clear
```

---

## 🔐 SEGURIDAD

- ✅ Sesiones con validación de roles
- ✅ Verificación docente-curso (no puede modificar cursos ajenos)
- ✅ Validación de tipos de archivo
- ✅ Límite de tamaño de archivos (10MB)
- ✅ Nombres aleatorios para archivos subidos
- ✅ Prepared statements (protección contra SQL injection)
- ✅ CSRF tokens en formularios

---

## 👥 ROLES Y PERMISOS

| Funcionalidad | Docente | Estudiante | Administrativo | Admin |
|---------------|---------|------------|----------------|-------|
| Subir materiales | ✅ | ❌ | ❌ | ❌ |
| Ver materiales | ✅ | ✅ (propios) | ✅ | ✅ |
| Ingresar calificaciones | ✅ | ❌ | ❌ | ❌ |
| Ver calificaciones | ✅ | ✅ (propias) | ✅ | ✅ |
| Registrar asistencia | ✅ | ❌ | ❌ | ❌ |
| Ver asistencias | ✅ | ✅ (propias) | ✅ | ✅ |
| Gestionar usuarios | ❌ | ❌ | ❌ | ✅ |
| Aprobar matrículas | ❌ | ❌ | ✅ | ✅ |

---

## 📊 ESTADÍSTICAS DEL SISTEMA

### Calificaciones:
- Total de estudiantes
- Promedio del curso
- Nota máxima y mínima
- Aprobados vs desaprobados (nota ≥ 10.5)

### Asistencias:
- Total de registros
- Distribución por estado
- Porcentaje individual
- Porcentaje general del curso

---

## 🧪 TESTING

### Test principal:
```
URL: http://localhost/sga/public/test_guardado_directo.php
```

**Verifica**:
- ✅ Conexión a BD
- ✅ INSERT en materiales
- ✅ INSERT/UPDATE en calificaciones
- ✅ INSERT/UPDATE en asistencias
- ✅ Controlador DocentesDirect
- ✅ Rutas configuradas

---

## 📝 CREDENCIALES POR DEFECTO

### Administrador:
- **Usuario**: admin
- **Contraseña**: admin123

### Docente (ejemplo):
- **Usuario**: juan.perez@unac.edu.pe
- **Contraseña**: docente123

### Estudiante (ejemplo):
- **Usuario**: 2025001
- **Contraseña**: estudiante123

⚠️ **IMPORTANTE**: Cambiar contraseñas en producción.

---

## 🔄 ACTUALIZACIONES RECIENTES (v2.0)

### ⭐ Nuevas funcionalidades:
1. **Controlador DocentesDirect** - Guardado ultra simple sin validaciones complejas
2. **Sistema de materiales** - Subida de archivos con múltiples formatos
3. **Calificaciones con componentes** - Hasta 5 componentes configurables
4. **Asistencias estilo OpenBravo** - 4 estados de presencia
5. **Estadísticas en tiempo real** - Cálculos automáticos
6. **Fórmulas personalizables** - Por curso

### 🗄️ Nuevas tablas:
- `formulas_calificacion`
- `horarios_curso`

### 📊 Nuevas columnas:
- `calificaciones.componente1-5`
- `calificaciones.nota_final`
- `asistencias.hora_registro`
- `asistencias.registrado_por`

---

## 📞 SOPORTE Y CONTACTO

Para problemas técnicos o mejoras, contactar al equipo de desarrollo.

---

## 📄 LICENCIA

Este proyecto es propiedad de la Universidad Nacional del Callao (UNAC).

---

## 📚 DOCUMENTACIÓN ADICIONAL

- `ESTRUCTURA.md` - Detalle completo de la arquitectura
- `actualizacion_sistema.sql` - Script SQL con comentarios
---

**Versión**: 2.0  
**Última actualización**: Diciembre 2025  
**Desarrollado para**: Universidad Nacional del Callao (UNAC)

