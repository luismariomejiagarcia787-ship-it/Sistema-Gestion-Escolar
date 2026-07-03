@extends('layouts.app')
@section('title','Detalle Curso')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.cursos.index') }}">Cursos</a></li><li class="breadcrumb-item active">{{ $curso->nombre }}</li>@endsection
@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card mb-3"><div class="card-body">
            <h5 class="fw-bold">{{ $curso->nombre }}</h5>
            <p class="text-muted small mb-3">Código: <strong>{{ $curso->codigo }}</strong></p>
            <div class="list-group list-group-flush small">
                <div class="list-group-item d-flex justify-content-between px-0"><span>Jornada</span><strong>{{ $curso->jornada_label }}</strong></div>
                <div class="list-group-item d-flex justify-content-between px-0"><span>Año Lectivo</span><strong>{{ $curso->anio_lectivo }}</strong></div>
                <div class="list-group-item d-flex justify-content-between px-0"><span>Director</span><strong>{{ $curso->profesor->user->name ?? '—' }}</strong></div>
                <div class="list-group-item d-flex justify-content-between px-0"><span>Estudiantes</span><strong>{{ $curso->estudiantes->count() }}</strong></div>
            </div>
            <a href="{{ route('admin.cursos.edit', $curso) }}" class="btn btn-warning btn-sm w-100 mt-3"><i class="bi bi-pencil me-1"></i>Editar</a>
        </div></div>
        <div class="card"><div class="card-header"><h6 class="fw-bold mb-0">Asignar Materias</h6></div><div class="card-body">
            <form action="{{ route('admin.cursos.materias', $curso) }}" method="POST">
                @csrf
                @foreach($curso->materias as $m)
                <div class="form-check"><input class="form-check-input" type="checkbox" name="materias[]" value="{{ $m->id }}" checked id="m{{ $m->id }}"><label class="form-check-label small" for="m{{ $m->id }}">{{ $m->nombre }}</label></div>
                @endforeach
                <button type="submit" class="btn btn-sm btn-primary mt-2 w-100">Guardar</button>
            </form>
        </div></div>
    </div>
    <div class="col-md-8">
        <div class="card"><div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-people text-primary me-2"></i>Estudiantes ({{ $curso->estudiantes->count() }})</h6></div>
        <div class="card-body p-0"><div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead><tr><th>Nombre</th><th>Documento</th><th>Estado</th></tr></thead>
                <tbody>
                    @forelse($curso->estudiantes as $e)
                    <tr>
                        <td class="small fw-semibold">{{ $e->user->name }}</td>
                        <td class="small text-muted">{{ $e->documento }}</td>
                        <td><span class="badge {{ $e->estado==='activo'?'bg-success':'bg-secondary' }}">{{ ucfirst($e->estado) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Sin estudiantes</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div></div></div>
    </div>
</div>
@endsection
