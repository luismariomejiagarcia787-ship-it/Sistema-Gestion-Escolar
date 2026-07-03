<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Materia;
use App\Models\Profesor;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $query = Curso::with(['profesor.user'])->withCount('estudiantes');

        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%'.$request->search.'%')
                ->orWhere('codigo', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('jornada')) {
            $query->where('jornada', $request->jornada);
        }

        $cursos = $query->latest()->paginate(15)->withQueryString();
        return view('admin.cursos.index', compact('cursos'));
    }

    public function create()
    {
        $profesores = Profesor::with('user')->where('estado', 'activo')->get();
        return view('admin.cursos.create', compact('profesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'codigo'       => 'required|string|unique:cursos',
            'jornada'      => 'required|in:manana,tarde,noche,completa',
            'anio_lectivo' => 'required|digits:4',
            'profesor_id'  => 'nullable|exists:profesores,id',
        ]);

        Curso::create($request->only('nombre','codigo','jornada','anio_lectivo','profesor_id'));

        return redirect()->route('admin.cursos.index')
            ->with('success', 'Curso creado correctamente.');
    }

    public function show(Curso $curso)
    {
        $curso->load(['profesor.user', 'estudiantes.user', 'materias']);
        return view('admin.cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        $profesores = Profesor::with('user')->where('estado', 'activo')->get();
        return view('admin.cursos.edit', compact('curso', 'profesores'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'codigo'       => 'required|string|unique:cursos,codigo,'.$curso->id,
            'jornada'      => 'required|in:manana,tarde,noche,completa',
            'anio_lectivo' => 'required|digits:4',
            'profesor_id'  => 'nullable|exists:profesores,id',
        ]);

        $curso->update($request->only('nombre','codigo','jornada','anio_lectivo','profesor_id'));

        return redirect()->route('admin.cursos.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('admin.cursos.index')
            ->with('success', 'Curso eliminado correctamente.');
    }

    public function asignarMaterias(Request $request, Curso $curso)
    {
        $request->validate(['materias' => 'array', 'materias.*' => 'exists:materias,id']);
        $curso->materias()->sync($request->materias ?? []);
        return back()->with('success', 'Materias asignadas correctamente.');
    }
}
