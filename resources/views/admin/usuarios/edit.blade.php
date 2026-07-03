@extends('layouts.app')
@section('title','Editar Usuario')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.usuarios.index') }}">Usuarios</a></li><li class="breadcrumb-item active">Editar</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Usuario</h4>
    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:500px"><div class="card-body">
<form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-12"><label class="form-label fw-semibold">Nombre *</label><input type="text" name="name" class="form-control" value="{{ old('name',$usuario->name) }}" required></div>
        <div class="col-12"><label class="form-label fw-semibold">Email *</label><input type="email" name="email" class="form-control" value="{{ old('email',$usuario->email) }}" required></div>
        <div class="col-12"><label class="form-label fw-semibold">Rol *</label>
            <select name="role" class="form-select" required>
                <option value="admin"      {{ old('role',$usuario->role)==='admin'      ?'selected':'' }}>Administrador</option>
                <option value="profesor"   {{ old('role',$usuario->role)==='profesor'   ?'selected':'' }}>Profesor</option>
                <option value="estudiante" {{ old('role',$usuario->role)==='estudiante' ?'selected':'' }}>Estudiante</option>
            </select>
        </div>
        <div class="col-12"><label class="form-label fw-semibold">Nueva Contraseña</label><input type="password" name="password" class="form-control" placeholder="Dejar vacío para no cambiar"></div>
        <div class="col-12"><label class="form-label fw-semibold">Confirmar Contraseña</label><input type="password" name="password_confirmation" class="form-control"></div>
        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Actualizar</button>
        </div>
    </div>
</form>
</div></div>
@endsection
