@extends('layouts.app')
@section('title','Matrículas')
@section('breadcrumb')<li class="breadcrumb-item active">Matrículas</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div><h4 class="fw-bold mb-0"><i class="bi bi-card-checklist text-primary me-2"></i>Matrículas</h4><p class="text-muted small mb-0">Gestión de matrículas estudiantiles</p></div>
    <a href="{{ route('admin.matriculas.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nueva Matrícula</a>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" name="search" class="form-control" placeholder="Buscar estudiante..." value="{{ request('search') }}"></div></div>
        <div class="col-md-3"><select name="curso_id" class="form-select form-select-sm"><option value="">Todos los cursos</option>@foreach($cursos as $c)<option value="{{ $c->id }}" {{ request('curso_id')==$c->id?'selected':'' }}>{{ $c->nombre }}</option>@endforeach</select></div>
        <div class="col-md-2"><select name="estado" class="form-select form-select-sm"><option value="">Todos</option><option value="activa" {{ request('estado')==='activa'?'selected':'' }}>Activa</option><option value="retirada" {{ request('estado')==='retirada'?'selected':'' }}>Retirada</option><option value="finalizada" {{ request('estado')==='finalizada'?'selected':'' }}>Finalizada</option></select></div>
        <div class="col-md-3 d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button><a href="{{ route('admin.matriculas.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Estudiante</th><th>Curso</th><th>Año</th><th>Fecha Matrícula</th><th>Estado</th><th>Acciones</th></tr></thead>
        <tbody>
            @forelse($matriculas as $m)
            <tr>
                <td class="text-muted small">{{ $m->id }}</td>
                <td class="small fw-semibold">{{ $m->estudiante->user->name }}</td>
                <td class="small">{{ $m->curso->nombre }}</td>
                <td class="small">{{ $m->anio_lectivo }}</td>
                <td class="small text-muted">{{ $m->fecha_matricula->format('d/m/Y') }}</td>
                <td>{!! $m->estado_badge !!}</td>
                <td><div class="d-flex gap-1">
                    <a href="{{ route('admin.matriculas.edit', $m) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.matriculas.destroy', $m) }}" method="POST" class="delete-form">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                </div></td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-5 text-muted"><i class="bi bi-card-checklist fs-1 d-block mb-2"></i>Sin matrículas registradas</td></tr>
            @endforelse
        </tbody>
    </table>
</div></div>
@if($matriculas->hasPages())<div class="card-footer d-flex align-items-center justify-content-between"><small class="text-muted">{{ $matriculas->total() }} registros</small>{{ $matriculas->links() }}</div>@endif
</div>
@endsection
