@extends('layouts.app')
@section('title','Calificaciones')
@section('breadcrumb')<li class="breadcrumb-item active">Calificaciones</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div><h4 class="fw-bold mb-0"><i class="bi bi-clipboard2-data-fill text-primary me-2"></i>Calificaciones</h4><p class="text-muted small mb-0">Gestión de notas académicas</p></div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.calificaciones.por-estudiante') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-person-lines-fill me-1"></i>Por Estudiante</a>
        <a href="{{ route('admin.calificaciones.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nueva Nota</a>
    </div>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" name="search" class="form-control" placeholder="Buscar estudiante..." value="{{ request('search') }}"></div></div>
        <div class="col-md-3"><select name="materia_id" class="form-select form-select-sm"><option value="">Todas las materias</option>@foreach($materias as $m)<option value="{{ $m->id }}" {{ request('materia_id')==$m->id?'selected':'' }}>{{ $m->nombre }}</option>@endforeach</select></div>
        <div class="col-md-2"><select name="periodo" class="form-select form-select-sm"><option value="">Todos los períodos</option><option value="1" {{ request('periodo')==='1'?'selected':'' }}>Período 1</option><option value="2" {{ request('periodo')==='2'?'selected':'' }}>Período 2</option><option value="3" {{ request('periodo')==='3'?'selected':'' }}>Período 3</option><option value="4" {{ request('periodo')==='4'?'selected':'' }}>Período 4</option></select></div>
        <div class="col-md-3 d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button><a href="{{ route('admin.calificaciones.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Estudiante</th><th>Materia</th><th>Período</th><th>Nota</th><th>Profesor</th><th>Acciones</th></tr></thead>
        <tbody>
            @forelse($calificaciones as $c)
            <tr>
                <td class="text-muted small">{{ $c->id }}</td>
                <td class="small fw-semibold">{{ $c->estudiante->user->name }}</td>
                <td class="small">{{ $c->materia->nombre }}</td>
                <td class="small">Período {{ $c->periodo }}</td>
                <td><span class="{{ $c->nota_color }} fs-6 fw-bold">{{ $c->nota }}</span></td>
                <td class="small text-muted">{{ $c->profesor->user->name ?? '—' }}</td>
                <td><div class="d-flex gap-1">
                    <a href="{{ route('admin.calificaciones.edit', $c) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.calificaciones.destroy', $c) }}" method="POST" class="delete-form">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                </div></td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-5 text-muted"><i class="bi bi-clipboard2 fs-1 d-block mb-2"></i>Sin calificaciones registradas</td></tr>
            @endforelse
        </tbody>
    </table>
</div></div>
@if($calificaciones->hasPages())<div class="card-footer d-flex align-items-center justify-content-between"><small class="text-muted">{{ $calificaciones->total() }} registros</small>{{ $calificaciones->links() }}</div>@endif
</div>
@endsection
