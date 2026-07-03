@extends('layouts.app')
@section('title','Nueva Matrícula')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.matriculas.index') }}">Matrículas</a></li><li class="breadcrumb-item active">Nueva</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-card-checklist text-primary me-2"></i>Nueva Matrícula</h4>
    <a href="{{ route('admin.matriculas.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:650px"><div class="card-body">
<form action="{{ route('admin.matriculas.store') }}" method="POST">
    @csrf
    <div class="row g-3">
        <div class="col-12"><label class="form-label fw-semibold">Estudiante *</label>
            <select name="estudiante_id" class="form-select" required>
                <option value="">Seleccionar estudiante...</option>
                @foreach($estudiantes as $e)<option value="{{ $e->id }}" {{ old('estudiante_id')==$e->id?'selected':'' }}>{{ $e->user->name }} — {{ $e->documento }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Curso *</label>
            <select name="curso_id" class="form-select" required>
                <option value="">Seleccionar curso...</option>
                @foreach($cursos as $c)<option value="{{ $c->id }}" {{ old('curso_id')==$c->id?'selected':'' }}>{{ $c->nombre }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Año Lectivo *</label><input type="number" name="anio_lectivo" class="form-control" value="{{ old('anio_lectivo', date('Y')) }}" min="2020" max="2035" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Fecha de Matrícula *</label><input type="date" name="fecha_matricula" class="form-control" value="{{ old('fecha_matricula', date('Y-m-d')) }}" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Estado *</label>
            <select name="estado" class="form-select" required>
                <option value="activa" {{ old('estado','activa')==='activa'?'selected':'' }}>Activa</option>
                <option value="retirada" {{ old('estado')==='retirada'?'selected':'' }}>Retirada</option>
                <option value="finalizada" {{ old('estado')==='finalizada'?'selected':'' }}>Finalizada</option>
            </select>
        </div>
        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.matriculas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Registrar Matrícula</button>
        </div>
    </div>
</form>
</div></div>
@endsection
