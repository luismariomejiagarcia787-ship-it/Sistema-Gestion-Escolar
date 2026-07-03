<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Materia;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    /**
     * Determina si la petición actual viene del panel de administrador
     * o del panel de profesor, según el prefijo de la ruta.
     * Esto permite que un mismo controlador sirva ambos paneles sin
     * mezclar vistas ni permisos (causa raíz del error 403 original).
     */
    private function esContextoAdmin(Request $request): bool
    {
        return $request->routeIs('admin.*');
    }

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

    public function index(Request $request)
    {
        $esAdmin = $this->esContextoAdmin($request);

        $query = Calificacion::with(['estudiante.user', 'materia', 'profesor.user']);

        // Un profesor solo puede ver las calificaciones que él mismo registró.
        if (!$esAdmin) {
            $profesor = $this->profesorActual();
            $query->where('profesor_id', $profesor->id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('estudiante.user', fn($q) => $q->where('name', 'like', "%$search%"));
        }

        if ($request->filled('materia_id')) {
            $query->where('materia_id', $request->materia_id);
        }

        if ($request->filled('periodo')) {
            $query->where('periodo', $request->periodo);
        }

        $calificaciones = $query->latest()->paginate(20)->withQueryString();
        $materias = Materia::orderBy('nombre')->get();

        $vista = $esAdmin ? 'admin.calificaciones.index' : 'profesor.calificaciones.index';

        return view($vista, compact('calificaciones', 'materias'));
    }

    public function create(Request $request)
    {
        $esAdmin = $this->esContextoAdmin($request);

        if ($esAdmin) {
            $estudiantes = Estudiante::with('user')->where('estado', 'activo')->get();
            $materias    = Materia::orderBy('nombre')->get();
            $profesores  = Profesor::with('user')->where('estado', 'activo')->get();

            return view('admin.calificaciones.create', compact('estudiantes', 'materias', 'profesores'));
        }

        // Contexto profesor: solo materias asignadas a él y estudiantes activos.
        $profesor    = $this->profesorActual();
        $estudiantes = Estudiante::with('user')->where('estado', 'activo')->get();
        $materias    = Materia::where('profesor_id', $profesor->id)->orderBy('nombre')->get();

        return view('profesor.calificaciones.create', compact('estudiantes', 'materias'));
    }

    public function store(Request $request)
    {
        $esAdmin = $this->esContextoAdmin($request);

        $reglas = [
            'estudiante_id' => 'required|exists:estudiantes,id',
            'materia_id'    => 'required|exists:materias,id',
            'nota'          => 'required|numeric|min:0|max:5',
            'periodo'       => 'required|in:1,2,3,4',
            'observacion'   => 'nullable|string|max:500',
        ];

        if ($esAdmin) {
            $reglas['profesor_id'] = 'nullable|exists:profesores,id';
        }

        $datos = $request->validate($reglas);

        if ($esAdmin) {
            Calificacion::create($datos);

            return redirect()->route('admin.calificaciones.index')
                ->with('success', 'Calificación registrada correctamente.');
        }

        // Un profesor SIEMPRE queda registrado como autor de su propia nota,
        // nunca confiamos en un profesor_id enviado desde el formulario.
        $profesor = $this->profesorActual();
        $datos['profesor_id'] = $profesor->id;

        Calificacion::create($datos);

        return redirect()->route('profesor.calificaciones.index')
            ->with('success', 'Calificación registrada correctamente.');
    }

    public function edit(Request $request, Calificacion $calificacion)
    {
        $esAdmin = $this->esContextoAdmin($request);

        if ($esAdmin) {
            $estudiantes = Estudiante::with('user')->where('estado', 'activo')->get();
            $materias    = Materia::orderBy('nombre')->get();
            $profesores  = Profesor::with('user')->where('estado', 'activo')->get();

            return view('admin.calificaciones.edit', compact('calificacion', 'estudiantes', 'materias', 'profesores'));
        }

        $profesor = $this->profesorActual();

        // Un profesor no puede editar calificaciones registradas por otro profesor.
        if ($calificacion->profesor_id != $profesor->id) {
            abort(403, 'No tiene permiso para editar esta calificación.');
        }

        $estudiantes = Estudiante::with('user')->where('estado', 'activo')->get();
        $materias    = Materia::where('profesor_id', $profesor->id)->orderBy('nombre')->get();

        return view('profesor.calificaciones.edit', compact('calificacion', 'estudiantes', 'materias'));
    }

    public function update(Request $request, Calificacion $calificacion)
    {
        $esAdmin = $this->esContextoAdmin($request);

        $reglas = [
            'estudiante_id' => 'required|exists:estudiantes,id',
            'materia_id'    => 'required|exists:materias,id',
            'nota'          => 'required|numeric|min:0|max:5',
            'periodo'       => 'required|in:1,2,3,4',
            'observacion'   => 'nullable|string|max:500',
        ];

        if ($esAdmin) {
            $reglas['profesor_id'] = 'nullable|exists:profesores,id';
        }

        $datos = $request->validate($reglas);

        if ($esAdmin) {
            $calificacion->update($datos);

            return redirect()->route('admin.calificaciones.index')
                ->with('success', 'Calificación actualizada correctamente.');
        }

        $profesor = $this->profesorActual();

        if ($calificacion->profesor_id != $profesor->id) {
            abort(403, 'No tiene permiso para editar esta calificación.');
        }

        $datos['profesor_id'] = $profesor->id;
        $calificacion->update($datos);

        return redirect()->route('profesor.calificaciones.index')
            ->with('success', 'Calificación actualizada correctamente.');
    }

    public function destroy(Request $request, Calificacion $calificacion)
    {
        $esAdmin = $this->esContextoAdmin($request);

        if (!$esAdmin) {
            // El profesor solo puede borrar lo que él mismo registró.
            $profesor = $this->profesorActual();
            if ($calificacion->profesor_id != $profesor->id) {
                abort(403, 'No tiene permiso para eliminar esta calificación.');
            }
        }

        $calificacion->delete();

        $ruta = $esAdmin ? 'admin.calificaciones.index' : 'profesor.calificaciones.index';

        return redirect()->route($ruta)
            ->with('success', 'Calificación eliminada correctamente.');
    }

    public function porEstudiante(Request $request)
    {
        $cursos      = Curso::orderBy('nombre')->get();
        $estudiantes = collect();
        $calificaciones = collect();
        $estudiante  = null;

        if ($request->filled('estudiante_id')) {
            $estudiante     = Estudiante::with('user')->findOrFail($request->estudiante_id);
            $calificaciones = Calificacion::with(['materia','profesor.user'])
                ->where('estudiante_id', $request->estudiante_id)
                ->orderBy('periodo')
                ->get();
        }

        if ($request->filled('curso_id')) {
            $estudiantes = Estudiante::with('user')->where('curso_id', $request->curso_id)->get();
        }

        return view('admin.calificaciones.por-estudiante', compact('cursos','estudiantes','calificaciones','estudiante'));
    }
}
