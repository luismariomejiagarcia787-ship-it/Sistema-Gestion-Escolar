<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfesorController extends Controller
{
    public function index(Request $request)
    {
        $query = Profesor::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%"))
                ->orWhere('documento', 'like', "%$search%");
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $profesores = $query->latest()->paginate(15)->withQueryString();
        return view('admin.profesores.index', compact('profesores'));
    }

    public function create()
    {
        return view('admin.profesores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:8',
            'documento'     => 'required|unique:profesores',
            'telefono'      => 'nullable|string|max:20',
            'especialidad'  => 'nullable|string|max:100',
            'fecha_ingreso' => 'nullable|date',
            'estado'        => 'required|in:activo,inactivo',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'profesor',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos/profesores', 'public');
        }

        Profesor::create([
            'user_id'       => $user->id,
            'documento'     => $request->documento,
            'telefono'      => $request->telefono,
            'especialidad'  => $request->especialidad,
            'fecha_ingreso' => $request->fecha_ingreso,
            'estado'        => $request->estado,
            'foto'          => $fotoPath,
        ]);

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Profesor registrado correctamente.');
    }

    public function show(Profesor $profesor)
    {
        $profesor->load(['user', 'cursos', 'materias']);
        return view('admin.profesores.show', compact('profesor'));
    }

    public function edit(Profesor $profesor)
    {
        return view('admin.profesores.edit', compact('profesor'));
    }

    public function update(Request $request, Profesor $profesor)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,'.$profesor->user_id,
            'documento'     => 'required|unique:profesores,documento,'.$profesor->id,
            'telefono'      => 'nullable|string|max:20',
            'especialidad'  => 'nullable|string|max:100',
            'fecha_ingreso' => 'nullable|date',
            'estado'        => 'required|in:activo,inactivo',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $profesor->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $profesor->user->update(['password' => Hash::make($request->password)]);
        }

        $fotoPath = $profesor->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath) Storage::disk('public')->delete($fotoPath);
            $fotoPath = $request->file('foto')->store('fotos/profesores', 'public');
        }

        $profesor->update([
            'documento'     => $request->documento,
            'telefono'      => $request->telefono,
            'especialidad'  => $request->especialidad,
            'fecha_ingreso' => $request->fecha_ingreso,
            'estado'        => $request->estado,
            'foto'          => $fotoPath,
        ]);

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Profesor actualizado correctamente.');
    }

    public function destroy(Profesor $profesor)
    {
        if ($profesor->foto) Storage::disk('public')->delete($profesor->foto);
        $user = $profesor->user;
        $profesor->delete();
        $user->delete();

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Profesor eliminado correctamente.');
    }
}
