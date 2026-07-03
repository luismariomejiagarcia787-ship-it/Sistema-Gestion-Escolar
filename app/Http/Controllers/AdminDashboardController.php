<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Calificacion;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Materia;
use App\Models\Matricula;
use App\Models\Profesor;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'estudiantes' => Estudiante::count(),
            'profesores'  => Profesor::count(),
            'cursos'      => Curso::count(),
            'materias'    => Materia::count(),
            'matriculas'  => Matricula::where('estado', 'activa')->count(),
            'asistencias' => Asistencia::whereDate('fecha', today())->count(),
            'promedio'    => round(Calificacion::avg('nota') ?? 0, 2),
        ];

        $ultimosEstudiantes = Estudiante::with('user')->latest()->take(5)->get();
        $ultimosProfesores  = Profesor::with('user')->latest()->take(5)->get();

        // Data for charts
        $asistenciaStats = [
            'presente' => Asistencia::where('estado', 'presente')->count(),
            'ausente'  => Asistencia::where('estado', 'ausente')->count(),
            'excusado' => Asistencia::where('estado', 'excusado')->count(),
            'tardanza' => Asistencia::where('estado', 'tardanza')->count(),
        ];

        $estudiantesPorCurso = Curso::withCount('estudiantes')
            ->orderByDesc('estudiantes_count')
            ->take(5)
            ->get();

        $notasPorPeriodo = Calificacion::selectRaw('periodo, AVG(nota) as promedio')
            ->groupBy('periodo')
            ->orderBy('periodo')
            ->get();

        return view('admin.dashboard.index', compact(
            'stats', 'ultimosEstudiantes', 'ultimosProfesores',
            'asistenciaStats', 'estudiantesPorCurso', 'notasPorPeriodo'
        ));
    }
}
