@extends('layouts.app')
@section('title','Editar Calificación')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.calificaciones.index') }}">Calificaciones</a></li><li class="breadcrumb-item active">Editar</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Calificación</h4>
    <a href="{{ route('admin.calificaciones.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:650px"><div class="card-body">
<form action="{{ url('admin/calificaciones/'.$calificacion->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-12"><label class="form-label fw-semibold">Estudiante *</label>
            <select name="estudiante_id" class="form-select" required>
                @foreach($estudiantes as $e)<option value="{{ $e->id }}" {{ old('estudiante_id',$calificacion->estudiante_id)==$e->id?'selected':'' }}>{{ $e->user->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Materia *</label>
            <select name="materia_id" class="form-select" required>
                @foreach($materias as $m)<option value="{{ $m->id }}" {{ old('materia_id',$calificacion->materia_id)==$m->id?'selected':'' }}>{{ $m->nombre }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Profesor</label>
            <select name="profesor_id" class="form-select">
                <option value="">Sin asignar</option>
                @foreach($profesores as $p)<option value="{{ $p->id }}" {{ old('profesor_id',$calificacion->profesor_id)==$p->id?'selected':'' }}>{{ $p->user->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Nota *</label><input type="number" name="nota" class="form-control" value="{{ old('nota',$calificacion->nota) }}" min="0" max="5" step="0.1" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Período *</label>
            <select name="periodo" class="form-select" required>
                @foreach(['1','2','3','4'] as $p)<option value="{{ $p }}" {{ old('periodo',$calificacion->periodo)===$p?'selected':'' }}>Período {{ $p }}</option>@endforeach
            </select>
        </div>
        <div class="col-12"><label class="form-label fw-semibold">Observación</label><textarea name="observacion" class="form-control" rows="3">{{ old('observacion',$calificacion->observacion) }}</textarea></div>
        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.calificaciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Actualizar</button>
        </div>
    </div>
</form>
</div></div>
@endsection
