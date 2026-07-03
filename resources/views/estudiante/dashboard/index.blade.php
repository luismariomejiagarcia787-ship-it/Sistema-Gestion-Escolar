@extends('layouts.app')
@section('title','Mi Dashboard')
@section('breadcrumb')<li class="breadcrumb-item active">Mi Portal</li>@endsection
@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-0">Bienvenido, {{ auth()->user()->name }}</h4>
    <p class="text-muted small">Portal estudiantil — {{ now()->format('d/m/Y') }}</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-primary-soft"><i class="bi bi-book-half"></i></div>
            <div><div class="fw-bold fs-4">{{ $estudiante->curso->materias->count() ?? 0 }}</div><div class="text-muted small">Materias</div></div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-success-soft"><i class="bi bi-graph-up-arrow"></i></div>
            <div><div class="fw-bold fs-4 {{ $promedio>=4?'nota-alta':($promedio>=3?'nota-media':'nota-baja') }}">{{ $promedio }}</div><div class="text-muted small">Mi Promedio</div></div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-teal-soft"><i class="bi bi-calendar-check-fill"></i></div>
            <div><div class="fw-bold fs-4">{{ $porcentajeAsist }}%</div><div class="text-muted small">% Asistencia</div></div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-warning-soft"><i class="bi bi-mortarboard-fill"></i></div>
            <div><div class="fw-bold fs-4 small">{{ $estudiante->curso->nombre ?? '—' }}</div><div class="text-muted small">Mi Curso</div></div>
        </div></div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-clipboard2-data text-primary me-2"></i>Mis Calificaciones</h6></div>
            <div class="card-body p-0"><div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead><tr><th>Materia</th><th>Período</th><th>Nota</th></tr></thead>
                    <tbody>
                        @forelse($calificaciones as $c)
                        <tr>
                            <td class="small fw-semibold">{{ $c->materia->nombre }}</td>
                            <td class="small">Período {{ $c->periodo }}</td>
                            <td><span class="{{ $c->nota_color }} fw-bold fs-6">{{ $c->nota }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">Sin calificaciones registradas</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div></div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-person-circle text-primary me-2"></i>Mi Información</h6></div>
            <div class="card-body small">
                <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Nombre</span><strong>{{ $estudiante->user->name }}</strong></div>
                <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Documento</span><strong>{{ $estudiante->documento }}</strong></div>
                <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Email</span><span class="text-truncate" style="max-width:150px">{{ $estudiante->user->email }}</span></div>
                <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Curso</span><strong>{{ $estudiante->curso->nombre ?? '—' }}</strong></div>
                <div class="d-flex justify-content-between py-1"><span class="text-muted">Estado</span><span class="badge bg-success">{{ ucfirst($estudiante->estado) }}</span></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-calendar text-primary me-2"></i>Asistencia Reciente</h6></div>
            <div class="card-body p-0"><div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead><tr><th>Fecha</th><th>Estado</th></tr></thead>
                    <tbody>
                        @forelse($asistencias->take(8) as $a)
                        <tr><td class="small">{{ $a->fecha->format('d/m/Y') }}</td><td>{!! $a->estado_badge !!}</td></tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-muted py-3">Sin registros</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div></div>
        </div>
    </div>
</div>
@endsection
