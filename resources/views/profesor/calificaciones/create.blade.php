@extends('layouts.app')
@section('title','Nueva Nota')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('profesor.calificaciones.index') }}">Calificaciones</a></li><li class="breadcrumb-item active">Nueva</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-clipboard2-plus text-primary me-2"></i>Registrar Nota</h4>
    <a href="{{ route('profesor.calificaciones.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:650px"><div class="card-body">
<form action="{{ route('profesor.calificaciones.store') }}" method="POST">
    @csrf
    <div class="row g-3">
        <div class="col-12"><label class="form-label fw-semibold">Estudiante *</label>
            <select name="estudiante_id" class="form-select" required>
                <option value="">Seleccionar estudiante...</option>
                @foreach($estudiantes as $e)<option value="{{ $e->id }}" {{ old('estudiante_id')==$e->id?'selected':'' }}>{{ $e->user->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Materia *</label>
            <select name="materia_id" class="form-select" required>
                <option value="">Seleccionar...</option>
                @foreach($materias as $m)<option value="{{ $m->id }}" {{ old('materia_id')==$m->id?'selected':'' }}>{{ $m->nombre }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Nota (0.0 – 5.0) *</label><input type="number" name="nota" class="form-control" value="{{ old('nota') }}" min="0" max="5" step="0.1" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Período *</label>
            <select name="periodo" class="form-select" required>
                @foreach(['1','2','3','4'] as $p)<option value="{{ $p }}" {{ old('periodo')===$p?'selected':'' }}>Período {{ $p }}</option>@endforeach
            </select>
        </div>
        <div class="col-12"><label class="form-label fw-semibold">Observación</label><textarea name="observacion" class="form-control" rows="2">{{ old('observacion') }}</textarea></div>
        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="{{ route('profesor.calificaciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Guardar</button>
        </div>
    </div>
</form>
</div></div>
@endsection
