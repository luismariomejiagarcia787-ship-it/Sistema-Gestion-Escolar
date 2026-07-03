<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Curso;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    /**
     * Determina si la petición actual viene del panel de administrador
     * o del panel de profesor, según el prefijo de la ruta.
     */
    private function esContextoAdmin(Request $request): bool
    {
        return $request->routeIs('admin.*');
    }

    /**
     * Devuelve el perfil de Profesor del usuario autenticado o aborta
     * con un mensaje claro si el usuario "profesor" no tiene perfil asociado.
     */
    private function profesorActual()
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor) {
            abort(403, 'Su usuario no tiene un perfil de profesor asociado. Contacte al administrador.');
        }

        return $profesor;
    }

    public function index(Request $request)
    {
        $esAdmin = $this->esContextoAdmin($request);

        $query = Asistencia::with(['estudiante.user', 'curso']);

        if (!$esAdmin) {
            // El profesor solo ve asistencia de los cursos que él tiene a cargo.
            $profesor = $this->profesorActual();
            $cursoIds = Curso::where('profesor_id', $profesor->id)->pluck('id');
            $query->whereIn('curso_id', $cursoIds);
        }

        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $asistencias = $query->latest('fecha')->paginate(20)->withQueryString();

        $cursos = $esAdmin
            ? Curso::orderBy('nombre')->get()
            : Curso::where('profesor_id', $this->profesorActual()->id)->orderBy('nombre')->get();

        $vista = $esAdmin ? 'admin.asistencia.index' : 'profesor.asistencia.index';

        return view($vista, compact('asistencias', 'cursos'));
    }

    public function create(Request $request)
    {
        $esAdmin = $this->esContextoAdmin($request);

        $cursos = $esAdmin
            ? Curso::orderBy('nombre')->get()
            : Curso::where('profesor_id', $this->profesorActual()->id)->orderBy('nombre')->get();

        $vista = $esAdmin ? 'admin.asistencia.create' : 'profesor.asistencia.create';

        return view($vista, compact('cursos'));
    }

    public function getEstudiantesPorCurso(Request $request)
    {
        $esAdmin = $this->esContextoAdmin($request);

        $cursoQuery = Curso::where('id', $request->curso_id);

        // Un profesor solo puede listar estudiantes de SUS propios cursos.
        if (!$esAdmin) {
            $profesor = $this->profesorActual();
            $cursoQuery->where('profesor_id', $profesor->id);
        }

        if (!$cursoQuery->exists()) {
            abort(403, 'No tiene permiso para acceder a este curso.');
        }

        $estudiantes = Estudiante::with('user')
            ->where('curso_id', $request->curso_id)
            ->where('estado', 'activo')
            ->get()
            ->map(fn($e) => ['id' => $e->id, 'nombre' => $e->user->name]);

        return response()->json($estudiantes);
    }

    public function store(Request $request)
    {
        $esAdmin = $this->esContextoAdmin($request);

        $request->validate([
            'curso_id'       => 'required|exists:cursos,id',
            'fecha'          => 'required|date',
            'asistencias'    => 'required|array',
            'asistencias.*.estudiante_id' => 'required|exists:estudiantes,id',
            'asistencias.*.estado'        => 'required|in:presente,ausente,excusado,tardanza',
        ]);

        if (!$esAdmin) {
            // Un profesor solo puede registrar asistencia de sus propios cursos.
            $profesor = $this->profesorActual();
            $cursoValido = Curso::where('id', $request->curso_id)
                ->where('profesor_id', $profesor->id)
                ->exists();

            if (!$cursoValido) {
                abort(403, 'No tiene permiso para registrar asistencia en este curso.');
            }
        }

        foreach ($request->asistencias as $item) {
            Asistencia::updateOrCreate(
                ['estudiante_id' => $item['estudiante_id'], 'curso_id' => $request->curso_id, 'fecha' => $request->fecha],
                ['estado' => $item['estado']]
            );
        }

        $ruta = $esAdmin ? 'admin.asistencia.index' : 'profesor.asistencia.index';

        return redirect()->route($ruta)
            ->with('success', 'Asistencia registrada correctamente.');
    }

    public function edit(Request $request, Asistencia $asistencia)
    {
        $esAdmin = $this->esContextoAdmin($request);

        if (!$esAdmin) {
            $profesor = $this->profesorActual();
            if ($asistencia->curso->profesor_id != $profesor->id) {
                abort(403, 'No tiene permiso para editar este registro de asistencia.');
            }
        }

        $cursos = $esAdmin
            ? Curso::orderBy('nombre')->get()
            : Curso::where('profesor_id', $this->profesorActual()->id)->orderBy('nombre')->get();

        $vista = $esAdmin ? 'admin.asistencia.edit' : 'profesor.asistencia.edit';

        return view($vista, compact('asistencia', 'cursos'));
    }

    public function update(Request $request, Asistencia $asistencia)
    {
        $esAdmin = $this->esContextoAdmin($request);

        if (!$esAdmin) {
            $profesor = $this->profesorActual();
            if ($asistencia->curso->profesor_id != $profesor->id) {
                abort(403, 'No tiene permiso para editar este registro de asistencia.');
            }
        }

        $request->validate([
            'estado' => 'required|in:presente,ausente,excusado,tardanza',
            'fecha'  => 'required|date',
        ]);

        $asistencia->update($request->only('estado','fecha'));

        $ruta = $esAdmin ? 'admin.asistencia.index' : 'profesor.asistencia.index';

        return redirect()->route($ruta)
            ->with('success', 'Asistencia actualizada correctamente.');
    }

    public function destroy(Request $request, Asistencia $asistencia)
    {
        $esAdmin = $this->esContextoAdmin($request);

        if (!$esAdmin) {
            $profesor = $this->profesorActual();
            if ($asistencia->curso->profesor_id != $profesor->id) {
                abort(403, 'No tiene permiso para eliminar este registro de asistencia.');
            }
        }

        $asistencia->delete();

        $ruta = $esAdmin ? 'admin.asistencia.index' : 'profesor.asistencia.index';

        return redirect()->route($ruta)
            ->with('success', 'Registro eliminado correctamente.');
    }

    public function reporte(Request $request)
    {
        $esAdmin = $this->esContextoAdmin($request);

        $cursos = $esAdmin
            ? Curso::orderBy('nombre')->get()
            : Curso::where('profesor_id', $this->profesorActual()->id)->orderBy('nombre')->get();

        $data = collect();

        if ($request->filled('curso_id') && $request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            if (!$esAdmin) {
                $profesor = $this->profesorActual();
                $cursoValido = Curso::where('id', $request->curso_id)
                    ->where('profesor_id', $profesor->id)
                    ->exists();

                if (!$cursoValido) {
                    abort(403, 'No tiene permiso para ver el reporte de este curso.');
                }
            }

            $data = Asistencia::with(['estudiante.user'])
                ->where('curso_id', $request->curso_id)
                ->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin])
                ->orderBy('fecha')
                ->get()
                ->groupBy('estudiante_id');
        }

        $vista = $esAdmin ? 'admin.asistencia.reporte' : 'profesor.asistencia.reporte';

        return view($vista, compact('cursos', 'data'));
    }
}
