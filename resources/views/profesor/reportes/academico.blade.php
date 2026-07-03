@extends('layouts.app')
@section('title','Reporte Académico')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('profesor.reportes.index') }}">Reportes</a></li><li class="breadcrumb-item active">Académico</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-graph-up text-primary me-2"></i>Reporte Académico</h4>
    <a href="{{ route('profesor.reportes.pdf.calificaciones', request()->query()) }}" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a>
</div>
<div class="card mb-4"><div class="card-body">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3"><label class="form-label fw-semibold small">Curso *</label>
            <select name="curso_id" class="form-select" required>
                <option value="">Seleccionar...</option>
                @foreach($cursos as $c)<option value="{{ $c->id }}" {{ request('curso_id')==$c->id?'selected':'' }}>{{ $c->nombre }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Materia</label>
            <select name="materia_id" class="form-select">
                <option value="">Todas</option>
                @foreach($materias as $m)<option value="{{ $m->id }}" {{ request('materia_id')==$m->id?'selected':'' }}>{{ $m->nombre }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2"><label class="form-label fw-semibold small">Período</label>
            <select name="periodo" class="form-select">
                <option value="">Todos</option>
                @foreach(['1','2','3','4'] as $p)<option value="{{ $p }}" {{ request('periodo')===$p?'selected':'' }}>Período {{ $p }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100 mt-auto"><i class="bi bi-search me-1"></i>Consultar</button></div>
    </form>
</div></div>

@if($cursos->isEmpty())
<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>Aún no tiene cursos asignados.</div>
@elseif($calificaciones->count())
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card text-center"><div class="card-body"><div class="fs-2 fw-bold text-primary">{{ $calificaciones->count() }}</div><div class="text-muted small">Total Notas</div></div></div></div>
    <div class="col-md-4"><div class="card text-center"><div class="card-body"><div class="fs-2 fw-bold nota-alta">{{ round($calificaciones->avg('nota'),2) }}</div><div class="text-muted small">Promedio General</div></div></div></div>
    <div class="col-md-4"><div class="card text-center"><div class="card-body"><div class="fs-2 fw-bold text-info">{{ $promedios->count() }}</div><div class="text-muted small">Estudiantes</div></div></div></div>
</div>
<div class="card"><div class="card-header"><h6 class="fw-bold mb-0">Promedios por Estudiante</h6></div>
<div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>Estudiante</th><th>Promedio</th><th># Notas</th><th>Calificación</th></tr></thead>
        <tbody>
            @foreach($promedios as $id => $item)
            <tr>
                <td class="fw-semibold small">{{ $item['nombre'] }}</td>
                <td><span class="{{ $item['promedio']>=4?'nota-alta':($item['promedio']>=3?'nota-media':'nota-baja') }} fw-bold fs-6">{{ $item['promedio'] }}</span></td>
                <td class="small text-muted">{{ $item['count'] }}</td>
                <td>
                    <div class="progress" style="height:8px">
                        <div class="progress-bar {{ $item['promedio']>=4?'bg-success':($item['promedio']>=3?'bg-warning':'bg-danger') }}" style="width:{{ $item['promedio']*20 }}%"></div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div></div></div>
@elseif(request()->filled('curso_id'))
<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>No se encontraron calificaciones para los filtros seleccionados.</div>
@endif
@endsection
