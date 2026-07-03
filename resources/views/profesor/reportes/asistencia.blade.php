@extends('layouts.app')
@section('title','Reporte de Asistencia')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('profesor.reportes.index') }}">Reportes</a></li><li class="breadcrumb-item active">Asistencia</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Reporte de Asistencia</h4>
    <a href="{{ route('profesor.reportes.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card mb-4"><div class="card-body">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-4"><label class="form-label fw-semibold small">Curso *</label>
            <select name="curso_id" class="form-select" required>
                <option value="">Seleccionar curso...</option>
                @foreach($cursos as $c)<option value="{{ $c->id }}" {{ request('curso_id')==$c->id?'selected':'' }}>{{ $c->nombre }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Desde</label><input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}"></div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Hasta</label><input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Consultar</button></div>
    </form>
</div></div>

@if($cursos->isEmpty())
<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>Aún no tiene cursos asignados.</div>
@elseif($data->count())
<div class="card"><div class="card-header"><h6 class="fw-bold mb-0">Resultados del período</h6></div>
<div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>Estudiante</th><th class="text-success">Presente</th><th class="text-danger">Ausente</th><th class="text-warning">Excusado</th><th class="text-info">Tardanza</th><th>Total</th><th>% Asistencia</th></tr></thead>
        <tbody>
            @foreach($data as $estId => $registros)
            @php
                $nombre   = $registros->first()->estudiante->user->name;
                $presente = $registros->where('estado','presente')->count();
                $ausente  = $registros->where('estado','ausente')->count();
                $excusado = $registros->where('estado','excusado')->count();
                $tardanza = $registros->where('estado','tardanza')->count();
                $total    = $registros->count();
                $pct      = $total > 0 ? round($presente/$total*100,1) : 0;
            @endphp
            <tr>
                <td class="fw-semibold small">{{ $nombre }}</td>
                <td class="text-success fw-bold">{{ $presente }}</td>
                <td class="text-danger fw-bold">{{ $ausente }}</td>
                <td class="text-warning fw-bold">{{ $excusado }}</td>
                <td class="text-info fw-bold">{{ $tardanza }}</td>
                <td class="small">{{ $total }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="progress flex-grow-1" style="height:8px">
                            <div class="progress-bar {{ $pct>=80?'bg-success':($pct>=60?'bg-warning':'bg-danger') }}" style="width:{{ $pct }}%"></div>
                        </div>
                        <span class="small fw-bold">{{ $pct }}%</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div></div></div>
@elseif(request()->hasAny(['curso_id','fecha_inicio']))
<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>No se encontraron registros para los filtros seleccionados.</div>
@endif
@endsection
