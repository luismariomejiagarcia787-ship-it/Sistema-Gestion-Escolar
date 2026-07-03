@extends('layouts.app')
@section('title','Dashboard Profesor')
@section('breadcrumb')<li class="breadcrumb-item active">Dashboard</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0">Bienvenido, {{ auth()->user()->name }}</h4>
        <p class="text-muted small mb-0">Panel del Profesor — {{ now()->format('d/m/Y') }}</p>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-primary-soft"><i class="bi bi-book-half"></i></div>
            <div><div class="fw-bold fs-4">{{ $cursos->count() }}</div><div class="text-muted small">Mis Cursos</div></div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-success-soft"><i class="bi bi-people-fill"></i></div>
            <div><div class="fw-bold fs-4">{{ $cursos->sum('estudiantes_count') }}</div><div class="text-muted small">Mis Estudiantes</div></div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-warning-soft"><i class="bi bi-clipboard2-data-fill"></i></div>
            <div><div class="fw-bold fs-4">{{ $totalNotas }}</div><div class="text-muted small">Notas Registradas</div></div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-teal-soft"><i class="bi bi-calendar-check-fill"></i></div>
            <div><div class="fw-bold fs-4">{{ $totalAsist }}</div><div class="text-muted small">Asistencias Hoy</div></div>
        </div></div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card h-100"><div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-book text-primary me-2"></i>Mis Cursos</h6></div>
        <div class="card-body p-0"><div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead><tr><th>Curso</th><th>Jornada</th><th>Estudiantes</th><th></th></tr></thead>
                <tbody>
                    @forelse($cursos as $c)
                    <tr>
                        <td class="fw-semibold small">{{ $c->nombre }}</td>
                        <td class="small">{{ $c->jornada_label }}</td>
                        <td><span class="badge bg-primary">{{ $c->estudiantes_count }}</span></td>
                        <td><a href="{{ route('profesor.asistencia.create') }}" class="btn btn-xs btn-outline-primary btn-sm py-0 px-2">Asistencia</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Sin cursos asignados</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div></div></div>
    </div>
    <div class="col-md-7">
        <div class="card h-100"><div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0"><i class="bi bi-clipboard2 text-primary me-2"></i>Últimas Notas Ingresadas</h6>
            <a href="{{ route('profesor.calificaciones.create') }}" class="btn btn-sm btn-primary">+ Nueva Nota</a>
        </div>
        <div class="card-body p-0"><div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead><tr><th>Estudiante</th><th>Materia</th><th>Período</th><th>Nota</th></tr></thead>
                <tbody>
                    @forelse($ultimasNotas as $n)
                    <tr>
                        <td class="small fw-semibold">{{ $n->estudiante->user->name }}</td>
                        <td class="small text-muted">{{ $n->materia->nombre }}</td>
                        <td class="small">P{{ $n->periodo }}</td>
                        <td><span class="{{ $n->nota_color }} fw-bold">{{ $n->nota }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Sin notas registradas</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div></div></div>
    </div>
</div>
@endsection
