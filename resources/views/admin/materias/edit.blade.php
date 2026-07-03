@extends('layouts.app')
@section('title','Editar Materia')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.materias.index') }}">Materias</a></li><li class="breadcrumb-item active">Editar</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Materia</h4>
    <a href="{{ route('admin.materias.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:600px"><div class="card-body">
<form action="{{ route('admin.materias.update', $materia) }}" method="POST">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold">Nombre *</label><input type="text" name="nombre" class="form-control" value="{{ old('nombre', $materia->nombre) }}" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Código *</label><input type="text" name="codigo" class="form-control" value="{{ old('codigo', $materia->codigo) }}" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Intensidad Horaria *</label><input type="number" name="intensidad_horaria" class="form-control" value="{{ old('intensidad_horaria', $materia->intensidad_horaria) }}" min="1" max="40" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Profesor Asignado</label>
            <select name="profesor_id" class="form-select">
                <option value="">Sin asignar</option>
                @foreach($profesores as $p)<option value="{{ $p->id }}" {{ old('profesor_id',$materia->profesor_id)==$p->id?'selected':'' }}>{{ $p->user->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.materias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Actualizar</button>
        </div>
    </div>
</form>
</div></div>
@endsection
