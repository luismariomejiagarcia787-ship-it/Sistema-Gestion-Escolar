@extends('layouts.app')
@section('title','Mis Calificaciones')
@section('breadcrumb')<li class="breadcrumb-item active">Calificaciones</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div><h4 class="fw-bold mb-0"><i class="bi bi-clipboard2-data-fill text-primary me-2"></i>Calificaciones</h4></div>
    <a href="{{ route('profesor.calificaciones.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nueva Nota</a>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" name="search" class="form-control" placeholder="Buscar estudiante..." value="{{ request('search') }}"></div></div>
        <div class="col-md-3"><select name="periodo" class="form-select form-select-sm"><option value="">Todos los períodos</option>@foreach(['1','2','3','4'] as $p)<option value="{{ $p }}" {{ request('periodo')===$p?'selected':'' }}>Período {{ $p }}</option>@endforeach</select></div>
        <div class="col-md-2 d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button><a href="{{ route('profesor.calificaciones.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Estudiante</th><th>Materia</th><th>Período</th><th>Nota</th><th>Acciones</th></tr></thead>
        <tbody>
            @forelse($calificaciones as $c)
            <tr>
                <td class="small text-muted">{{ $c->id }}</td>
                <td class="small fw-semibold">{{ $c->estudiante->user->name }}</td>
                <td class="small">{{ $c->materia->nombre }}</td>
                <td class="small">Período {{ $c->periodo }}</td>
                <td><span class="{{ $c->nota_color }} fw-bold fs-6">{{ $c->nota }}</span></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('profesor.calificaciones.edit', $c) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('profesor.calificaciones.destroy', $c) }}" method="POST" class="delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-5 text-muted"><i class="bi bi-clipboard2 fs-1 d-block mb-2"></i>Sin calificaciones</td></tr>
            @endforelse
        </tbody>
    </table>
</div></div>
@if($calificaciones->hasPages())<div class="card-footer">{{ $calificaciones->links() }}</div>@endif
</div>
@endsection
