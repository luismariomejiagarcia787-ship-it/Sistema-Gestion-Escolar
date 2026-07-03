@extends('layouts.app')
@section('title','Notas por Estudiante')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.calificaciones.index') }}">Calificaciones</a></li><li class="breadcrumb-item active">Por Estudiante</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-person-lines-fill text-primary me-2"></i>Notas por Estudiante</h4>
    <a href="{{ route('admin.calificaciones.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card mb-3"><div class="card-body">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-4"><label class="form-label fw-semibold small">Curso</label>
            <select name="curso_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Seleccionar curso...</option>
                @foreach($cursos as $c)<option value="{{ $c->id }}" {{ request('curso_id')==$c->id?'selected':'' }}>{{ $c->nombre }}</option>@endforeach
            </select>
        </div>
        @if($estudiantes->count())
        <div class="col-md-4"><label class="form-label fw-semibold small">Estudiante</label>
            <select name="estudiante_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Seleccionar estudiante...</option>
                @foreach($estudiantes as $e)<option value="{{ $e->id }}" {{ request('estudiante_id')==$e->id?'selected':'' }}>{{ $e->user->name }}</option>@endforeach
            </select>
        </div>
        @endif
    </form>
</div></div>

@if($estudiante)
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6 class="fw-bold mb-0"><i class="bi bi-person-circle me-2 text-primary"></i>{{ $estudiante->user->name }}</h6>
        @if($calificaciones->count())
        <span class="badge bg-primary">Promedio: {{ round($calificaciones->avg('nota'),2) }}</span>
        @endif
    </div>
    <div class="card-body p-0"><div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead><tr><th>Materia</th><th>Período</th><th>Nota</th><th>Profesor</th><th>Observación</th></tr></thead>
            <tbody>
                @forelse($calificaciones as $c)
                <tr>
                    <td class="small fw-semibold">{{ $c->materia->nombre }}</td>
                    <td class="small">Período {{ $c->periodo }}</td>
                    <td><span class="{{ $c->nota_color }} fw-bold fs-6">{{ $c->nota }}</span></td>
                    <td class="small text-muted">{{ $c->profesor->user->name ?? '—' }}</td>
                    <td class="small text-muted">{{ $c->observacion ?? '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Sin calificaciones</td></tr>
                @endforelse
            </tbody>
        </table>
    </div></div>
</div>
@endif
@endsection
