@extends('layouts.app')
@section('title','Cursos')
@section('breadcrumb')<li class="breadcrumb-item active">Cursos</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div><h4 class="fw-bold mb-0"><i class="bi bi-book-half text-primary me-2"></i>Cursos</h4><p class="text-muted small mb-0">Gestión de cursos académicos</p></div>
    <a href="{{ route('admin.cursos.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nuevo Curso</a>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}"></div></div>
        <div class="col-md-3"><select name="jornada" class="form-select form-select-sm"><option value="">Todas las jornadas</option><option value="manana" {{ request('jornada')==='manana'?'selected':'' }}>Mañana</option><option value="tarde" {{ request('jornada')==='tarde'?'selected':'' }}>Tarde</option><option value="noche" {{ request('jornada')==='noche'?'selected':'' }}>Noche</option><option value="completa" {{ request('jornada')==='completa'?'selected':'' }}>Completa</option></select></div>
        <div class="col-md-2 d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button><a href="{{ route('admin.cursos.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Nombre</th><th>Código</th><th>Jornada</th><th>Año</th><th>Director Grupo</th><th>Estudiantes</th><th>Acciones</th></tr></thead>
        <tbody>
            @forelse($cursos as $c)
            <tr>
                <td class="text-muted small">{{ $c->id }}</td>
                <td class="fw-semibold small">{{ $c->nombre }}</td>
                <td><span class="badge bg-primary-soft text-primary">{{ $c->codigo }}</span></td>
                <td class="small">{{ $c->jornada_label }}</td>
                <td class="small">{{ $c->anio_lectivo }}</td>
                <td class="small">{{ $c->profesor->user->name ?? '—' }}</td>
                <td><span class="badge bg-info-subtle text-info">{{ $c->estudiantes_count }}</span></td>
                <td><div class="d-flex gap-1">
                    <a href="{{ route('admin.cursos.show', $c) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.cursos.edit', $c) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.cursos.destroy', $c) }}" method="POST" class="delete-form">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                </div></td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center py-5 text-muted"><i class="bi bi-book fs-1 d-block mb-2"></i>Sin cursos registrados</td></tr>
            @endforelse
        </tbody>
    </table>
</div></div>
@if($cursos->hasPages())<div class="card-footer">{{ $cursos->links() }}</div>@endif
</div>
@endsection
