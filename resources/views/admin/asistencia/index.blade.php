@extends('layouts.app')
@section('title','Asistencia')
@section('breadcrumb')<li class="breadcrumb-item active">Asistencia</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div><h4 class="fw-bold mb-0"><i class="bi bi-calendar-check-fill text-primary me-2"></i>Asistencia</h4><p class="text-muted small mb-0">Registro y control de asistencia</p></div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.asistencia.reporte') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-bar-chart me-1"></i>Reporte</a>
        <a href="{{ route('admin.asistencia.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Registrar Asistencia</a>
    </div>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3"><select name="curso_id" class="form-select form-select-sm"><option value="">Todos los cursos</option>@foreach($cursos as $c)<option value="{{ $c->id }}" {{ request('curso_id')==$c->id?'selected':'' }}>{{ $c->nombre }}</option>@endforeach</select></div>
        <div class="col-md-3"><input type="date" name="fecha" class="form-control form-control-sm" value="{{ request('fecha') }}"></div>
        <div class="col-md-2"><select name="estado" class="form-select form-select-sm"><option value="">Todos</option><option value="presente" {{ request('estado')==='presente'?'selected':'' }}>Presente</option><option value="ausente" {{ request('estado')==='ausente'?'selected':'' }}>Ausente</option><option value="excusado" {{ request('estado')==='excusado'?'selected':'' }}>Excusado</option><option value="tardanza" {{ request('estado')==='tardanza'?'selected':'' }}>Tardanza</option></select></div>
        <div class="col-md-2 d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button><a href="{{ route('admin.asistencia.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Estudiante</th><th>Curso</th><th>Fecha</th><th>Estado</th><th>Acciones</th></tr></thead>
        <tbody>
            @forelse($asistencias as $a)
            <tr>
                <td class="text-muted small">{{ $a->id }}</td>
                <td class="small fw-semibold">{{ $a->estudiante->user->name }}</td>
                <td class="small">{{ $a->curso->nombre }}</td>
                <td class="small text-muted">{{ $a->fecha->format('d/m/Y') }}</td>
                <td>{!! $a->estado_badge !!}</td>
                <td><div class="d-flex gap-1">
                    <a href="{{ route('admin.asistencia.edit', $a) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.asistencia.destroy', $a) }}" method="POST" class="delete-form">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                </div></td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-5 text-muted"><i class="bi bi-calendar-x fs-1 d-block mb-2"></i>Sin registros de asistencia</td></tr>
            @endforelse
        </tbody>
    </table>
</div></div>
@if($asistencias->hasPages())<div class="card-footer d-flex align-items-center justify-content-between"><small class="text-muted">{{ $asistencias->total() }} registros</small>{{ $asistencias->links() }}</div>@endif
</div>
@endsection
