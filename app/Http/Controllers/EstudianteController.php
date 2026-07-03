<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EstudianteController extends Controller
{
    public function index(Request $request)
    {
        $query = Estudiante::with(['user', 'curso']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%"))
                ->orWhere('documento', 'like', "%$search%");
        }

        if ($request->filled('curso')) {
            $query->where('curso_id', $request->curso);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $estudiantes = $query->latest()->paginate(15)->withQueryString();
        $cursos = Curso::orderBy('nombre')->get();

        return view('admin.estudiantes.index', compact('estudiantes', 'cursos'));
    }

    public function create()
    {
        $cursos = Curso::orderBy('nombre')->get();
        return view('admin.estudiantes.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users',
            'password'         => 'required|min:8',
            'documento'        => 'required|unique:estudiantes',
            'telefono'         => 'nullable|string|max:20',
            'direccion'        => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'genero'           => 'required|in:masculino,femenino,otro',
            'curso_id'         => 'nullable|exists:cursos,id',
            'estado'           => 'required|in:activo,inactivo,retirado',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'estudiante',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos/estudiantes', 'public');
        }

        Estudiante::create([
            'user_id'          => $user->id,
            'documento'        => $request->documento,
            'telefono'         => $request->telefono,
            'direccion'        => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero'           => $request->genero,
            'curso_id'         => $request->curso_id,
            'estado'           => $request->estado,
            'foto'             => $fotoPath,
        ]);

        return redirect()->route('admin.estudiantes.index')
            ->with('success', 'Estudiante registrado correctamente.');
    }

    public function show(Estudiante $estudiante)
    {
        $estudiante->load(['user', 'curso', 'calificaciones.materia', 'asistencias', 'matriculas.curso']);
        return view('admin.estudiantes.show', compact('estudiante'));
    }

    public function edit(Estudiante $estudiante)
    {
        $cursos = Curso::orderBy('nombre')->get();
        return view('admin.estudiantes.edit', compact('estudiante', 'cursos'));
    }

    public function update(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,'.$estudiante->user_id,
            'documento'        => 'required|unique:estudiantes,documento,'.$estudiante->id,
            'telefono'         => 'nullable|string|max:20',
            'direccion'        => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'genero'           => 'required|in:masculino,femenino,otro',
            'curso_id'         => 'nullable|exists:cursos,id',
            'estado'           => 'required|in:activo,inactivo,retirado',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $estudiante->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $estudiante->user->update(['password' => Hash::make($request->password)]);
        }

        $fotoPath = $estudiante->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath) Storage::disk('public')->delete($fotoPath);
            $fotoPath = $request->file('foto')->store('fotos/estudiantes', 'public');
        }

        $estudiante->update([
            'documento'        => $request->documento,
            'telefono'         => $request->telefono,
            'direccion'        => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero'           => $request->genero,
            'curso_id'         => $request->curso_id,
            'estado'           => $request->estado,
            'foto'             => $fotoPath,
        ]);

        return redirect()->route('admin.estudiantes.index')
            ->with('success', 'Estudiante actualizado correctamente.');
    }

    public function destroy(Estudiante $estudiante)
    {
        if ($estudiante->foto) Storage::disk('public')->delete($estudiante->foto);
        $user = $estudiante->user;
        $estudiante->delete();
        $user->delete();

        return redirect()->route('admin.estudiantes.index')
            ->with('success', 'Estudiante eliminado correctamente.');
    }
}
