@extends('layouts.app')
@section('title','Editar Profesor')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.profesores.index') }}">Profesores</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Profesor</h4>
    <a href="{{ route('admin.profesores.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<form action="{{ route('admin.profesores.update', $profesor) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h6 class="fw-bold mb-0">Información del Profesor</h6></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre Completo *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $profesor->user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Documento *</label>
                            <input type="text" name="documento" class="form-control" value="{{ old('documento', $profesor->documento) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Correo *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $profesor->user->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nueva Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para no cambiar">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $profesor->telefono) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Especialidad</label>
                            <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad', $profesor->especialidad) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fecha de Ingreso</label>
                            <input type="date" name="fecha_ingreso" class="form-control" value="{{ old('fecha_ingreso', $profesor->fecha_ingreso?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estado *</label>
                            <select name="estado" class="form-select" required>
                                <option value="activo"   {{ old('estado', $profesor->estado) === 'activo'   ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado', $profesor->estado) === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h6 class="fw-bold mb-0">Foto</h6></div>
                <div class="card-body text-center">
                    <img id="foto-preview" src="{{ $profesor->foto ? asset('storage/'.$profesor->foto) : asset('assets/img/default-avatar.svg') }}" class="avatar-xl rounded-circle mb-3 border" style="object-fit:cover">
                    <input type="file" name="foto" id="foto" class="form-control form-control-sm" accept="image/*">
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3 d-flex gap-2 justify-content-end">
        <a href="{{ route('admin.profesores.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Actualizar</button>
    </div>
</form>
@endsection
