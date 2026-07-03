<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Calificacion;
use Illuminate\Support\Facades\Auth;

class EstudianteDashboardController extends Controller
{
    public function index()
    {
        $estudiante = Auth::user()->estudiante;

        if (!$estudiante) {
            abort(403, 'No tiene un perfil de estudiante asociado.');
        }

        $estudiante->load(['user', 'curso.materias.profesor.user']);

        $calificaciones = Calificacion::with(['materia'])
            ->where('estudiante_id', $estudiante->id)
            ->orderBy('periodo')
            ->get();

        $promedio = round($calificaciones->avg('nota') ?? 0, 2);

        $asistencias = Asistencia::where('estudiante_id', $estudiante->id)
            ->latest('fecha')->take(30)->get();

        $totalPresente  = $asistencias->where('estado','presente')->count();
        $totalAusente   = $asistencias->where('estado','ausente')->count();
        $porcentajeAsist = $asistencias->count() > 0
            ? round(($totalPresente / $asistencias->count()) * 100, 1)
            : 0;

        return view('estudiante.dashboard.index', compact(
            'estudiante','calificaciones','promedio','asistencias','porcentajeAsist'
        ));
    }
}
