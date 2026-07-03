@extends('layouts.app')
@section('title', 'Nuevo Estudiante')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.estudiantes.index') }}">Estudiantes</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-person-plus-fill text-primary me-2"></i>Nuevo Estudiante</h4>
    <a href="{{ route('admin.estudiantes.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Volver
    </a>
</div>

<form action="{{ route('admin.estudiantes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h6 class="fw-bold mb-0">Información Personal</h6></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Documento <span class="text-danger">*</span></label>
                            <input type="text" name="documento" class="form-control" value="{{ old('documento') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Género <span class="text-danger">*</span></label>
                            <select name="genero" class="form-select" required>
                                <option value="masculino" {{ old('genero') === 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino"  {{ old('genero') === 'femenino'  ? 'selected' : '' }}>Femenino</option>
                                <option value="otro"      {{ old('genero') === 'otro'      ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Curso</label>
                            <select name="curso_id" class="form-select">
                                <option value="">Sin asignar</option>
                                @foreach($cursos as $c)
                                    <option value="{{ $c->id }}" {{ old('curso_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                            <select name="estado" class="form-select" required>
                                <option value="activo"   {{ old('estado','activo') === 'activo'   ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="retirado" {{ old('estado') === 'retirado' ? 'selected' : '' }}>Retirado</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Dirección</label>
                            <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h6 class="fw-bold mb-0">Foto del Estudiante</h6></div>
                <div class="card-body text-center">
                    <img id="foto-preview" src="{{ asset('assets/img/default-avatar.svg') }}"
                        class="avatar-xl rounded-circle mb-3 border" style="object-fit:cover">
                    <div>
                        <label class="form-label fw-semibold d-block">Subir Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control form-control-sm" accept="image/jpg,image/jpeg,image/png">
                        <small class="text-muted">JPG, PNG. Máx 2MB</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex gap-2 justify-content-end">
        <a href="{{ route('admin.estudiantes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Guardar Estudiante
        </button>
    </div>
</form>
@endsection
