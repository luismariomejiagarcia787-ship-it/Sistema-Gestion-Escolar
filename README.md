# 🏫 Sistema de Gestión Escolar — Laravel 12

Panel administrativo completo para la gestión de un colegio.

---

## ⚙️ Requisitos

- PHP 8.2+
- Composer
- MySQL 8+
- Node.js 18+ y NPM
- Extensiones PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

---

## 🚀 Instalación

```bash
# 1. Instalar dependencias PHP
composer install

# 2. Copiar archivo de entorno
cp .env.example .env

# 3. Generar clave de aplicación
php artisan key:generate

# 4. Configurar base de datos en .env
# DB_DATABASE=sistema_escolar
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Ejecutar migraciones y seeders
php artisan migrate --seed

# 6. Crear enlace simbólico para storage
php artisan storage:link

# 7. Instalar dependencias JS
npm install

# 8. Compilar assets
npm run dev

# 9. Iniciar servidor
php artisan serve
```

Abrir: http://localhost:8000

---

## 👤 Usuarios de Prueba

| Rol           | Email                      | Contraseña |
|---------------|----------------------------|------------|
| Administrador | admin@colegio.com          | 12345678   |
| Profesor      | profesor@colegio.com       | 12345678   |
| Estudiante    | estudiante@colegio.com     | 12345678   |

---

## 📦 Módulos

| Módulo          | Descripción                              |
|-----------------|------------------------------------------|
| Dashboard       | Estadísticas y gráficas con Chart.js     |
| Estudiantes     | CRUD completo con foto y perfil          |
| Profesores      | CRUD completo con foto y perfil          |
| Cursos          | Gestión de cursos y asignación de materias |
| Materias        | Asignación de materias a profesores      |
| Matrículas      | Registro de matrículas por año lectivo   |
| Calificaciones  | Notas por período con promedios          |
| Asistencia      | Registro masivo con reportes             |
| Reportes        | Export PDF y Excel (DomPDF + Laravel Excel) |
| Usuarios        | Gestión de cuentas y roles               |

---

## 🛠 Stack Tecnológico

- **Backend:** Laravel 12, PHP 8.2+, Eloquent ORM
- **Base de Datos:** MySQL
- **Frontend:** Blade, Bootstrap 5, Bootstrap Icons
- **Charts:** Chart.js 4
- **PDF:** DomPDF (barryvdh/laravel-dompdf)
- **Excel:** Maatwebsite/Laravel-Excel
- **Auth:** Laravel Auth con middleware de roles

---

## 📁 Estructura

```
app/
├── Exports/           # Excel exports
├── Http/
│   ├── Controllers/   # Todos los controladores
│   └── Middleware/    # RoleMiddleware
├── Models/            # Modelos Eloquent
└── Providers/         # AppServiceProvider

database/
├── migrations/        # 8 migraciones
└── seeders/           # Datos de prueba

resources/views/
├── admin/             # Vistas del administrador
├── profesor/          # Vistas del profesor
├── estudiante/        # Vistas del estudiante
├── auth/              # Login y Registro
└── layouts/           # Layout principal y auth
```
