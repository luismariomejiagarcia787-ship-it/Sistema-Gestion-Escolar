@extends('layouts.app')
@section('title','Reporte General')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.reportes.index') }}">Reportes</a></li><li class="breadcrumb-item active">General</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-file-earmark-text text-primary me-2"></i>Reporte: {{ ucfirst($tipo) }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reportes.pdf.estudiantes') }}" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a>
        <a href="{{ route('admin.reportes.excel.estudiantes') }}" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel me-1"></i>Excel</a>
        <a href="{{ route('admin.reportes.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
    </div>
</div>
<div class="mb-3 d-flex gap-2">
    @foreach(['estudiantes','profesores','cursos','materias'] as $t)
    <a href="{{ route('admin.reportes.general', ['tipo'=>$t]) }}" class="btn btn-sm {{ $tipo===$t?'btn-primary':'btn-outline-secondary' }}">{{ ucfirst($t) }}</a>
    @endforeach
</div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    @if($tipo==='estudiantes')
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Nombre</th><th>Documento</th><th>Email</th><th>Curso</th><th>Estado</th><th>Registro</th></tr></thead>
        <tbody>
            @forelse($data as $e)
            <tr><td class="small text-muted">{{ $e->id }}</td><td class="small fw-semibold">{{ $e->user->name }}</td><td class="small">{{ $e->documento }}</td><td class="small text-muted">{{ $e->user->email }}</td><td class="small">{{ $e->curso->nombre ?? '—' }}</td><td><span class="badge {{ $e->estado==='activo'?'bg-success':'bg-secondary' }}">{{ ucfirst($e->estado) }}</span></td><td class="small text-muted">{{ $e->created_at->format('d/m/Y') }}</td></tr>
            @empty<tr><td colspan="7" class="text-center py-4 text-muted">Sin datos</td></tr>@endforelse
        </tbody>
    </table>
    @elseif($tipo==='profesores')
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Nombre</th><th>Documento</th><th>Especialidad</th><th>Teléfono</th><th>Estado</th></tr></thead>
        <tbody>
            @forelse($data as $p)
            <tr><td class="small text-muted">{{ $p->id }}</td><td class="small fw-semibold">{{ $p->user->name }}</td><td class="small">{{ $p->documento }}</td><td class="small">{{ $p->especialidad ?? '—' }}</td><td class="small">{{ $p->telefono ?? '—' }}</td><td><span class="badge {{ $p->estado==='activo'?'bg-success':'bg-secondary' }}">{{ ucfirst($p->estado) }}</span></td></tr>
            @empty<tr><td colspan="6" class="text-center py-4 text-muted">Sin datos</td></tr>@endforelse
        </tbody>
    </table>
    @elseif($tipo==='cursos')
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Nombre</th><th>Código</th><th>Jornada</th><th>Año</th><th>Director</th><th>Estudiantes</th></tr></thead>
        <tbody>
            @forelse($data as $c)
            <tr><td class="small text-muted">{{ $c->id }}</td><td class="small fw-semibold">{{ $c->nombre }}</td><td class="small">{{ $c->codigo }}</td><td class="small">{{ $c->jornada_label }}</td><td class="small">{{ $c->anio_lectivo }}</td><td class="small">{{ $c->profesor->user->name ?? '—' }}</td><td><span class="badge bg-info-subtle text-info">{{ $c->estudiantes_count }}</span></td></tr>
            @empty<tr><td colspan="7" class="text-center py-4 text-muted">Sin datos</td></tr>@endforelse
        </tbody>
    </table>
    @elseif($tipo==='materias')
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Nombre</th><th>Código</th><th>Horas</th><th>Profesor</th></tr></thead>
        <tbody>
            @forelse($data as $m)
            <tr><td class="small text-muted">{{ $m->id }}</td><td class="small fw-semibold">{{ $m->nombre }}</td><td class="small">{{ $m->codigo }}</td><td class="small">{{ $m->intensidad_horaria }} h</td><td class="small">{{ $m->profesor->user->name ?? '—' }}</td></tr>
            @empty<tr><td colspan="5" class="text-center py-4 text-muted">Sin datos</td></tr>@endforelse
        </tbody>
    </table>
    @endif
</div></div></div>
@endsection
