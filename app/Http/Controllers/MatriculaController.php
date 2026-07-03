<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Matricula;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function index(Request $request)
    {
        $query = Matricula::with(['estudiante.user', 'curso']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('estudiante.user', fn($q) => $q->where('name', 'like', "%$search%"));
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        $matriculas = $query->latest()->paginate(15)->withQueryString();
        $cursos = Curso::orderBy('nombre')->get();

        return view('admin.matriculas.index', compact('matriculas', 'cursos'));
    }

    public function create()
    {
        $estudiantes = Estudiante::with('user')->where('estado', 'activo')->get();
        $cursos = Curso::orderBy('nombre')->get();
        return view('admin.matriculas.create', compact('estudiantes', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id'  => 'required|exists:estudiantes,id',
            'curso_id'       => 'required|exists:cursos,id',
            'fecha_matricula'=> 'required|date',
            'anio_lectivo'   => 'required|digits:4',
            'estado'         => 'required|in:activa,retirada,finalizada',
        ]);

        Matricula::create($request->only('estudiante_id','curso_id','fecha_matricula','anio_lectivo','estado'));

        return redirect()->route('admin.matriculas.index')
            ->with('success', 'Matrícula registrada correctamente.');
    }

    public function edit(Matricula $matricula)
    {
        $estudiantes = Estudiante::with('user')->where('estado', 'activo')->get();
        $cursos = Curso::orderBy('nombre')->get();
        return view('admin.matriculas.edit', compact('matricula', 'estudiantes', 'cursos'));
    }

    public function update(Request $request, Matricula $matricula)
    {
        $request->validate([
            'estudiante_id'  => 'required|exists:estudiantes,id',
            'curso_id'       => 'required|exists:cursos,id',
            'fecha_matricula'=> 'required|date',
            'anio_lectivo'   => 'required|digits:4',
            'estado'         => 'required|in:activa,retirada,finalizada',
        ]);

        $matricula->update($request->only('estudiante_id','curso_id','fecha_matricula','anio_lectivo','estado'));

        return redirect()->route('admin.matriculas.index')
            ->with('success', 'Matrícula actualizada correctamente.');
    }

    public function destroy(Matricula $matricula)
    {
        $matricula->delete();
        return redirect()->route('admin.matriculas.index')
            ->with('success', 'Matrícula eliminada correctamente.');
    }
}
