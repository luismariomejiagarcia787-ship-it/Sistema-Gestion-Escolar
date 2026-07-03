<?php

namespace App\Http\Controllers;

use App\Exports\CalificacionesExport;
use App\Exports\EstudiantesExport;
use App\Models\Asistencia;
use App\Models\Calificacion;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Materia;
use App\Models\Matricula;
use App\Models\Profesor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    /**
     * Devuelve el perfil de Profesor del usuario autenticado o aborta
     * con un mensaje claro si el usuario "profesor" no tiene perfil asociado.
     */
    private function profesorActual(): Profesor
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor) {
            abort(403, 'Su usuario no tiene un perfil de profesor asociado. Contacte al administrador.');
        }

        return $profesor;
    }

    public function index()
    {
        return view('admin.reportes.index');
    }

    public function general(Request $request)
    {
        $tipo = $request->get('tipo', 'estudiantes');

        $data = match($tipo) {
            'profesores' => Profesor::with('user')->get(),
            'cursos'     => Curso::with(['profesor.user'])->withCount('estudiantes')->get(),
            'materias'   => Materia::with('profesor.user')->get(),
            default      => Estudiante::with(['user', 'curso'])->get(),
        };

        return view('admin.reportes.general', compact('data', 'tipo'));
    }

    public function academico(Request $request)
    {
        $cursos         = Curso::orderBy('nombre')->get();
        $materias       = Materia::orderBy('nombre')->get();
        $calificaciones = collect();
        $promedios      = collect();

        if ($request->filled('curso_id')) {
            $estudianteIds = Estudiante::where('curso_id', $request->curso_id)->pluck('id');
            $calificaciones = Calificacion::with(['estudiante.user', 'materia'])
                ->whereIn('estudiante_id', $estudianteIds)
                ->when($request->filled('materia_id'), fn($q) => $q->where('materia_id', $request->materia_id))
                ->when($request->filled('periodo'),    fn($q) => $q->where('periodo', $request->periodo))
                ->get();

            $promedios = $calificaciones->groupBy('estudiante_id')->map(fn($group) => [
                'nombre'   => $group->first()->estudiante->user->name,
                'promedio' => round($group->avg('nota'), 2),
                'count'    => $group->count(),
            ]);
        }

        return view('admin.reportes.academico', compact('cursos', 'materias', 'calificaciones', 'promedios'));
    }

    public function exportarPdfEstudiantes()
    {
        $estudiantes = Estudiante::with(['user', 'curso'])->get();
        $pdf = Pdf::loadView('admin.reportes.pdf.estudiantes', compact('estudiantes'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('reporte_estudiantes_' . date('Ymd') . '.pdf');
    }

    public function exportarPdfCalificaciones(Request $request)
    {
        $calificaciones = Calificacion::with(['estudiante.user', 'materia', 'profesor.user'])
            ->when($request->filled('curso_id'), function ($q) use ($request) {
                $ids = Estudiante::where('curso_id', $request->curso_id)->pluck('id');
                $q->whereIn('estudiante_id', $ids);
            })
            ->get();

        $pdf = Pdf::loadView('admin.reportes.pdf.calificaciones', compact('calificaciones'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('reporte_calificaciones_' . date('Ymd') . '.pdf');
    }

    public function exportarExcelEstudiantes()
    {
        return Excel::download(new EstudiantesExport(), 'estudiantes_' . date('Ymd') . '.xlsx');
    }

    public function exportarExcelCalificaciones()
    {
        return Excel::download(new CalificacionesExport(), 'calificaciones_' . date('Ymd') . '.xlsx');
    }

    /*
    |--------------------------------------------------------------------------
    | Reportes del Profesor
    |--------------------------------------------------------------------------
    | El módulo de Reportes no existía para el rol "profesor": no había rutas,
    | ni vistas, ni métodos de controlador para él. Por eso cualquier intento
    | de acceso (directo o por enlace) terminaba en 403 vía RoleMiddleware,
    | al no estar autorizado bajo el grupo de rutas "role:admin".
    | Estos métodos exponen una versión acotada SOLO a los cursos/materias
    | del profesor autenticado, sin tocar el panel de administrador.
    */

    public function profesorIndex()
    {
        $profesor = $this->profesorActual();
        $cursos   = Curso::where('profesor_id', $profesor->id)->withCount('estudiantes')->get();
        $materias = Materia::where('profesor_id', $profesor->id)->get();

        return view('profesor.reportes.index', compact('profesor', 'cursos', 'materias'));
    }

    public function profesorAcademico(Request $request)
    {
        $profesor = $this->profesorActual();
        $cursos   = Curso::where('profesor_id', $profesor->id)->orderBy('nombre')->get();
        $materias = Materia::where('profesor_id', $profesor->id)->orderBy('nombre')->get();

        $calificaciones = collect();
        $promedios      = collect();

        if ($request->filled('curso_id')) {
            // Verificamos que el curso solicitado realmente pertenezca al profesor.
            $cursoValido = Curso::where('id', $request->curso_id)
                ->where('profesor_id', $profesor->id)
                ->exists();

            if (!$cursoValido) {
                abort(403, 'No tiene permiso para ver el reporte de este curso.');
            }

            $estudianteIds = Estudiante::where('curso_id', $request->curso_id)->pluck('id');
            $calificaciones = Calificacion::with(['estudiante.user', 'materia'])
                ->where('profesor_id', $profesor->id)
                ->whereIn('estudiante_id', $estudianteIds)
                ->when($request->filled('materia_id'), fn($q) => $q->where('materia_id', $request->materia_id))
                ->when($request->filled('periodo'),    fn($q) => $q->where('periodo', $request->periodo))
                ->get();

            $promedios = $calificaciones->groupBy('estudiante_id')->map(fn($group) => [
                'nombre'   => $group->first()->estudiante->user->name,
                'promedio' => round($group->avg('nota'), 2),
                'count'    => $group->count(),
            ]);
        }

        return view('profesor.reportes.academico', compact('cursos', 'materias', 'calificaciones', 'promedios'));
    }

    public function profesorAsistencia(Request $request)
    {
        $profesor = $this->profesorActual();
        $cursos   = Curso::where('profesor_id', $profesor->id)->orderBy('nombre')->get();
        $data     = collect();

        if ($request->filled('curso_id') && $request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $cursoValido = Curso::where('id', $request->curso_id)
                ->where('profesor_id', $profesor->id)
                ->exists();

            if (!$cursoValido) {
                abort(403, 'No tiene permiso para ver el reporte de este curso.');
            }

            $data = Asistencia::with(['estudiante.user'])
                ->where('curso_id', $request->curso_id)
                ->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin])
                ->orderBy('fecha')
                ->get()
                ->groupBy('estudiante_id');
        }

        return view('profesor.reportes.asistencia', compact('cursos', 'data'));
    }

    public function profesorExportarPdfCalificaciones(Request $request)
    {
        $profesor = $this->profesorActual();

        $calificaciones = Calificacion::with(['estudiante.user', 'materia', 'profesor.user'])
            ->where('profesor_id', $profesor->id)
            ->when($request->filled('curso_id'), function ($q) use ($request, $profesor) {
                $cursoValido = Curso::where('id', $request->curso_id)
                    ->where('profesor_id', $profesor->id)
                    ->exists();

                if (!$cursoValido) {
                    abort(403, 'No tiene permiso para exportar el reporte de este curso.');
                }

                $ids = Estudiante::where('curso_id', $request->curso_id)->pluck('id');
                $q->whereIn('estudiante_id', $ids);
            })
            ->get();

        $pdf = Pdf::loadView('admin.reportes.pdf.calificaciones', compact('calificaciones'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('mis_calificaciones_' . date('Ymd') . '.pdf');
    }
}
