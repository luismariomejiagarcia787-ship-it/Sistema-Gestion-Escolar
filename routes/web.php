<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EstudianteDashboardController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ProfesorDashboardController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Redirect root
Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',          [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',         [AuthController::class, 'login'])->name('login.post');
    Route::get('/register',       [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',      [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Estudiantes
    Route::resource('estudiantes', EstudianteController::class);

    // Profesores
    Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);

    // Cursos
    Route::resource('cursos', CursoController::class);
    Route::post('cursos/{curso}/materias', [CursoController::class, 'asignarMaterias'])->name('cursos.materias');

    // Materias
    Route::resource('materias', MateriaController::class)->except(['show']);

    // Matrículas
    Route::resource('matriculas', MatriculaController::class)->except(['show']);

    // Calificaciones
    Route::get('/calificaciones/por-estudiante', [CalificacionController::class, 'porEstudiante'])->name('calificaciones.por-estudiante');
    Route::resource('calificaciones', CalificacionController::class)
    ->parameters([
        'calificaciones' => 'calificacion'
    ])
    ->except(['show']);

    // Asistencia
    Route::get('/asistencia/reporte',  [AsistenciaController::class, 'reporte'])->name('asistencia.reporte');
    Route::get('/asistencia/estudiantes', [AsistenciaController::class, 'getEstudiantesPorCurso'])->name('asistencia.estudiantes');
    Route::resource('asistencia', AsistenciaController::class)
    ->parameters([
        'asistencia' => 'asistencia'
    ])
    ->except(['show']);

    // Reportes
    Route::get('/reportes',                   [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/general',           [ReporteController::class, 'general'])->name('reportes.general');
    Route::get('/reportes/academico',         [ReporteController::class, 'academico'])->name('reportes.academico');
    Route::get('/reportes/pdf/estudiantes',   [ReporteController::class, 'exportarPdfEstudiantes'])->name('reportes.pdf.estudiantes');
    Route::get('/reportes/pdf/calificaciones',[ReporteController::class, 'exportarPdfCalificaciones'])->name('reportes.pdf.calificaciones');
    Route::get('/reportes/excel/estudiantes', [ReporteController::class, 'exportarExcelEstudiantes'])->name('reportes.excel.estudiantes');
    Route::get('/reportes/excel/calificaciones', [ReporteController::class, 'exportarExcelCalificaciones'])->name('reportes.excel.calificaciones');

    // Usuarios
    Route::resource('usuarios', UsuarioController::class)->only(['index','edit','update','destroy']);
});

// Profesor routes
Route::middleware(['auth', 'role:profesor'])->prefix('profesor')->name('profesor.')->group(function () {
    Route::get('/dashboard', [ProfesorDashboardController::class, 'index'])->name('dashboard');

    // Notas (profesor view)
    Route::get('/calificaciones', [CalificacionController::class, 'index'])->name('calificaciones.index');
    Route::get('/calificaciones/create', [CalificacionController::class, 'create'])->name('calificaciones.create');
    Route::post('/calificaciones', [CalificacionController::class, 'store'])->name('calificaciones.store');
    Route::get('/calificaciones/{calificacion}/edit', [CalificacionController::class, 'edit'])->name('calificaciones.edit');
    Route::put('/calificaciones/{calificacion}', [CalificacionController::class, 'update'])->name('calificaciones.update');
    Route::delete('/calificaciones/{calificacion}', [CalificacionController::class, 'destroy'])->name('calificaciones.destroy');

    // Asistencia (profesor view)
    Route::get('/asistencia', [AsistenciaController::class, 'index'])->name('asistencia.index');
    Route::get('/asistencia/create', [AsistenciaController::class, 'create'])->name('asistencia.create');
    Route::post('/asistencia', [AsistenciaController::class, 'store'])->name('asistencia.store');
    Route::get('/asistencia/reporte', [AsistenciaController::class, 'reporte'])->name('asistencia.reporte');
    Route::get('/asistencia/estudiantes', [AsistenciaController::class, 'getEstudiantesPorCurso'])->name('asistencia.estudiantes');
    Route::get('/asistencia/{asistencia}/edit', [AsistenciaController::class, 'edit'])->name('asistencia.edit');
    Route::put('/asistencia/{asistencia}', [AsistenciaController::class, 'update'])->name('asistencia.update');
    Route::delete('/asistencia/{asistencia}', [AsistenciaController::class, 'destroy'])->name('asistencia.destroy');

    // Reportes (profesor view) — antes inexistente, causaba 403 al no haber ruta autorizada.
    Route::get('/reportes', [ReporteController::class, 'profesorIndex'])->name('reportes.index');
    Route::get('/reportes/academico', [ReporteController::class, 'profesorAcademico'])->name('reportes.academico');
    Route::get('/reportes/asistencia', [ReporteController::class, 'profesorAsistencia'])->name('reportes.asistencia');
    Route::get('/reportes/pdf/calificaciones', [ReporteController::class, 'profesorExportarPdfCalificaciones'])->name('reportes.pdf.calificaciones');
});

// Estudiante routes
Route::middleware(['auth', 'role:estudiante'])->prefix('estudiante')->name('estudiante.')->group(function () {
    Route::get('/dashboard', [EstudianteDashboardController::class, 'index'])->name('dashboard');
});
