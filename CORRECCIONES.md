# Informe de Correcciones — Sistema de Gestión Escolar

Fecha: 2026-06-19
Stack: Laravel 12 · PHP 8.3 · MySQL · Bootstrap 5
Control de acceso: middleware de roles propio (`RoleMiddleware`), sin Spatie Permission, sin Policies ni Gates registrados.

---

## 1. Rol Profesor — Error 403 en Calificaciones, Asistencia y Reportes

### Causa raíz (la misma para los tres módulos)

El sistema de roles funcionaba correctamente: las rutas `profesor.calificaciones.*` y
`profesor.asistencia.*` ya existían en `routes/web.php` y estaban protegidas con
`role:profesor`. El error NO estaba en el middleware, ni en Policies/Gates (no existen
en el proyecto), sino en los **controladores**, que ignoraban por completo el contexto
de profesor:

- `CalificacionController` y `AsistenciaController` son compartidos entre las rutas
  `admin.*` y `profesor.*` (mismo controlador, dos grupos de rutas).
- Todos sus métodos (`index`, `create`, `store`, `edit`, `update`, `destroy`, `reporte`)
  estaban *hardcodeados* para devolver siempre las vistas `admin.*` y redirigir siempre
  a `admin.*`.
- Cuando un profesor abría `/profesor/calificaciones/create`, el método `create()` SÍ se
  ejecutaba (el middleware lo permitía), pero devolvía la vista `admin.calificaciones.create`.
  Esa vista genera un `<form action="{{ route('admin.calificaciones.store') }}">`.
- Al enviar el formulario, el navegador hacía POST a `/admin/calificaciones`, ruta protegida
  con `role:admin`. Como el usuario autenticado tiene `role = profesor`, el `RoleMiddleware`
  ejecutaba `abort(403)`.
- El mismo patrón ocurría en Asistencia.
- El módulo de **Reportes** ni siquiera tenía rutas, vistas ni métodos de controlador para
  el rol profesor: solo existía `admin.reportes.*`. Cualquier intento de acceso terminaba
  en 403 por el mismo middleware, al no haber ninguna ruta autorizada para `profesor`.
- Además, el menú lateral del profesor (`layouts/app.blade.php`) ni siquiera mostraba la
  opción "Reportes", confirmando que el módulo nunca se implementó para este rol.

### Solución aplicada

- `CalificacionController` y `AsistenciaController`: se añadió un método privado
  `esContextoAdmin(Request $request)` que detecta el panel actual con
  `$request->routeIs('admin.*')`. Cada método ahora:
  - Sirve la vista correcta (`admin.*` o `profesor.*`).
  - Redirige a la ruta correcta tras guardar/actualizar/eliminar.
  - Filtra los datos del profesor por su propio `profesor_id` (no puede ver ni modificar
    calificaciones/asistencia de otros profesores).
  - Fuerza `profesor_id` al valor del profesor autenticado al crear/editar (nunca confía
    en un `profesor_id` enviado desde el formulario), evitando que un profesor se asigne
    notas a nombre de otro.
- `routes/web.php`: se completaron las rutas faltantes del profesor:
  - `DELETE /profesor/calificaciones/{calificacion}` (no existía).
  - `GET/PUT/DELETE /profesor/asistencia/{asistencia}` (edit/update/destroy no existían).
  - `GET /profesor/asistencia/reporte` (no existía).
  - Todo el bloque `GET /profesor/reportes*` (módulo completo, no existía).
- `ReporteController`: se añadieron los métodos `profesorIndex()`, `profesorAcademico()`,
  `profesorAsistencia()` y `profesorExportarPdfCalificaciones()`, todos acotados
  exclusivamente a los cursos/materias del profesor autenticado.
- Vistas nuevas: `profesor/reportes/index.blade.php`, `profesor/reportes/academico.blade.php`,
  `profesor/reportes/asistencia.blade.php`, `profesor/asistencia/edit.blade.php`,
  `profesor/asistencia/reporte.blade.php`.
- `layouts/app.blade.php`: se agregó el enlace "Reportes" al menú lateral del profesor.

---

## 2. Rol Administrador — Botones Editar/Eliminar "no funcionan"

### Causa raíz

Las vistas y controladores del admin para Calificaciones, Asistencia y Profesores ya
estaban correctamente implementados: rutas resource, CSRF (`@csrf`), spoofing de método
(`@method('PUT')` / `@method('DELETE')`), y lógica del controlador con mensajes flash.

El problema real era un bug de **JavaScript en producción** que rompía el comportamiento
interactivo de TODA la aplicación (no solo de estos botones):

- El layout cargaba `public/assets/js/app.js` como `<script>` clásico.
- Ese archivo empezaba con `import './bootstrap';` — sintaxis de **módulo ES**, ilegal en
  un script clásico (sin `type="module"`). Cualquier navegador lanza un `SyntaxError`
  inmediato al parsear esa línea, lo cual **detiene la ejecución de todo el archivo**.
- Además, `public/assets/js/bootstrap.js` (el archivo importado) **no existía** en absoluto
  dentro del docroot público; solo existía su fuente en `resources/js/bootstrap.js`, que
  Vite nunca compiló (no existe `public/build/`).
- Resultado: ningún listener de `app.js` se registraba. Esto incluye el `confirm()` antes
  de enviar los formularios `.delete-form`, los tooltips de Bootstrap, el toggle del sidebar
  y el preview de imagen al editar un profesor. Desde la perspectiva del usuario esto se
  percibe como "los botones no funcionan", aunque las rutas y el backend eran correctos.

### Solución aplicada

- Se reescribió `public/assets/js/app.js` como un script clásico 100% válido:
  - Se eliminó el `import './bootstrap'`.
  - Se protegió el uso de `window.axios` y `window.bootstrap` con comprobaciones
    (`if (window.bootstrap) ...`) para que el script no truene si esas librerías no están
    cargadas en una página concreta.
  - Se conservó exactamente el mismo comportamiento esperado: confirmación antes de
    eliminar, auto-cierre de alertas, toggle de sidebar, preview de imagen y tooltips.
- No se modificó `resources/js/app.js` ni `resources/js/bootstrap.js`: quedan como código
  fuente válido para un futuro build con `npm run build` + directiva `@vite()`, sin que el
  funcionamiento actual dependa de ello.

Con este fix, los botones "Editar" (enlaces `<a>` normales) y "Eliminar" (formularios POST
con `@method('DELETE')`) de Calificaciones, Asistencia y Profesores vuelven a funcionar de
forma consistente en cualquier navegador, con confirmación antes de borrar y mensajes flash
de éxito que ya estaban implementados en los controladores (`->with('success', ...)`).

---

## 3. Mensajes flash de éxito / error

Ya existía soporte completo en `layouts/app.blade.php` para `session('success')`,
`session('error')` y `$errors` de validación, y todos los controladores ya devolvían
`->with('success', '...')` en sus operaciones. No se requirió ningún cambio adicional aquí;
los nuevos métodos de profesor creados (`store`, `update`, `destroy` de Calificaciones y
Asistencia, y los de Reportes) siguen el mismo patrón.

---

## Archivos modificados

- `app/Http/Controllers/CalificacionController.php` — reescrito completo.
- `app/Http/Controllers/AsistenciaController.php` — reescrito completo.
- `app/Http/Controllers/ReporteController.php` — ampliado (métodos de profesor agregados,
  métodos de admin sin cambios).
- `routes/web.php` — rutas de profesor completadas.
- `resources/views/layouts/app.blade.php` — enlace de Reportes agregado al menú del profesor.
- `public/assets/js/app.js` — reescrito como script clásico válido.
- `resources/views/profesor/calificaciones/index.blade.php` — botón Eliminar agregado.
- `resources/views/profesor/asistencia/index.blade.php` — botones Editar/Eliminar y enlace
  a Reporte agregados.

## Archivos nuevos

- `resources/views/profesor/asistencia/edit.blade.php`
- `resources/views/profesor/asistencia/reporte.blade.php`
- `resources/views/profesor/reportes/index.blade.php`
- `resources/views/profesor/reportes/academico.blade.php`
- `resources/views/profesor/reportes/asistencia.blade.php`

## Archivos NO modificados (ya estaban correctos)

- `app/Http/Middleware/RoleMiddleware.php`
- `app/Http/Controllers/ProfesorController.php`
- `app/Http/Controllers/AuthController.php`
- Todas las vistas `admin/calificaciones/*`, `admin/asistencia/*`, `admin/profesores/*`
  (rutas, CSRF y métodos HTTP ya eran correctos).

---

## Pruebas realizadas (análisis estático — no se pudo ejecutar PHP/Artisan en este entorno)

No hay PHP CLI disponible en el entorno de corrección ni acceso a red, por lo que no fue
posible ejecutar `php artisan serve`, `route:list` ni la suite de tests (el proyecto no
trae tests). La verificación se realizó mediante:

1. Lectura completa de `routes/web.php`, confirmando que cada vista usa exactamente los
   nombres de ruta definidos (sin typos) y que el orden de las rutas literales
   (`create`, `reporte`, `estudiantes`) precede a las rutas con parámetro
   (`{asistencia}/edit`), evitando colisiones de matching.
2. Verificación de balance de llaves/paréntesis en los tres controladores modificados.
3. Trazado manual del flujo completo request → middleware → controlador → vista → acción
   de submit → ruta de destino, para cada uno de los 3 módulos del profesor y los 3
   botones del administrador.
4. Verificación cruzada con los seeders (`UserSeeder`, `ProfesorSeeder`, `MateriaSeeder`,
   `CursoSeeder`, `CalificacionSeeder`) para confirmar que el usuario de prueba
   `profesor@colegio.com` / `12345678` queda con un curso y una materia asignados, y que
   por tanto las nuevas vistas de profesor (calificaciones, asistencia, reportes)
   recibirán datos reales y no listas vacías.

### Recomendación para pruebas reales antes de producción

```bash
composer install
npm install        # opcional, solo si se desea compilar Vite con @vite()
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Iniciar sesión con `profesor@colegio.com` / `12345678` y verificar:
- Calificaciones → Nueva Calificación → guardar → debe redirigir con mensaje de éxito.
- Asistencia → Registrar Nueva Asistencia → cargar estudiantes → guardar → mensaje de éxito.
- Reportes → debe cargar sin 403 y mostrar solo los cursos del profesor.

Iniciar sesión con `admin@colegio.com` / `12345678` y verificar:
- Calificaciones/Asistencia/Profesores → Editar → debe abrir el formulario de edición.
- Eliminar → debe mostrar el `confirm()` del navegador y, al aceptar, eliminar el registro
  con mensaje flash de éxito.
