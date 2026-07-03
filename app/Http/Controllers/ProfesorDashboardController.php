<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Calificacion;
use App\Models\Curso;
use Illuminate\Support\Facades\Auth;

class ProfesorDashboardController extends Controller
{
    public function index()
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor) {
            abort(403, 'No tiene un perfil de profesor asociado.');
        }

        $cursos       = Curso::where('profesor_id', $profesor->id)->withCount('estudiantes')->get();
        $totalNotas   = Calificacion::where('profesor_id', $profesor->id)->count();
        $totalAsist   = Asistencia::whereIn('curso_id', $cursos->pluck('id'))->whereDate('fecha', today())->count();

        $ultimasNotas = Calificacion::with(['estudiante.user','materia'])
            ->where('profesor_id', $profesor->id)
            ->latest()->take(10)->get();

        return view('profesor.dashboard.index', compact('profesor','cursos','totalNotas','totalAsist','ultimasNotas'));
    }
}
