@extends('layouts.app')
@section('title','Materias')
@section('breadcrumb')<li class="breadcrumb-item active">Materias</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div><h4 class="fw-bold mb-0"><i class="bi bi-journal-text text-primary me-2"></i>Materias</h4><p class="text-muted small mb-0">Gestión de materias académicas</p></div>
    <a href="{{ route('admin.materias.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nueva Materia</a>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-7"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" name="search" class="form-control" placeholder="Buscar por nombre o código..." value="{{ request('search') }}"></div></div>
        <div class="col-md-3 d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button><a href="{{ route('admin.materias.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Materia</th><th>Código</th><th>Horas/Semana</th><th>Profesor</th><th>Acciones</th></tr></thead>
        <tbody>
            @forelse($materias as $m)
            <tr>
                <td class="text-muted small">{{ $m->id }}</td>
                <td class="fw-semibold small">{{ $m->nombre }}</td>
                <td><span class="badge bg-primary-soft text-primary">{{ $m->codigo }}</span></td>
                <td class="small">{{ $m->intensidad_horaria }} h</td>
                <td class="small">{{ $m->profesor->user->name ?? '—' }}</td>
                <td><div class="d-flex gap-1">
                    <a href="{{ route('admin.materias.edit', $m) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.materias.destroy', $m) }}" method="POST" class="delete-form">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                </div></td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-5 text-muted"><i class="bi bi-journal fs-1 d-block mb-2"></i>Sin materias registradas</td></tr>
            @endforelse
        </tbody>
    </table>
</div></div>
@if($materias->hasPages())<div class="card-footer">{{ $materias->links() }}</div>@endif
</div>
@endsection
