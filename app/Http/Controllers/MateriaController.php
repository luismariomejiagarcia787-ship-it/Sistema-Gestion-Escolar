<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Profesor;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Materia::with('profesor.user');

        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%'.$request->search.'%')
                ->orWhere('codigo', 'like', '%'.$request->search.'%');
        }

        $materias = $query->latest()->paginate(15)->withQueryString();
        return view('admin.materias.index', compact('materias'));
    }

    public function create()
    {
        $profesores = Profesor::with('user')->where('estado', 'activo')->get();
        return view('admin.materias.create', compact('profesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'            => 'required|string|max:100',
            'codigo'            => 'required|string|unique:materias',
            'intensidad_horaria'=> 'required|integer|min:1|max:40',
            'profesor_id'       => 'nullable|exists:profesores,id',
        ]);

        Materia::create($request->only('nombre','codigo','intensidad_horaria','profesor_id'));

        return redirect()->route('admin.materias.index')
            ->with('success', 'Materia creada correctamente.');
    }

    public function edit(Materia $materia)
    {
        $profesores = Profesor::with('user')->where('estado', 'activo')->get();
        return view('admin.materias.edit', compact('materia', 'profesores'));
    }

    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'nombre'            => 'required|string|max:100',
            'codigo'            => 'required|string|unique:materias,codigo,'.$materia->id,
            'intensidad_horaria'=> 'required|integer|min:1|max:40',
            'profesor_id'       => 'nullable|exists:profesores,id',
        ]);

        $materia->update($request->only('nombre','codigo','intensidad_horaria','profesor_id'));

        return redirect()->route('admin.materias.index')
            ->with('success', 'Materia actualizada correctamente.');
    }

    public function destroy(Materia $materia)
    {
        $materia->delete();
        return redirect()->route('admin.materias.index')
            ->with('success', 'Materia eliminada correctamente.');
    }
}
