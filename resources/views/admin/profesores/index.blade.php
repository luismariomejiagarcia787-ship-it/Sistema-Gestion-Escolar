@extends('layouts.app')
@section('title', 'Profesores')
@section('breadcrumb')
    <li class="breadcrumb-item active">Profesores</li>
@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-person-badge-fill text-primary me-2"></i>Profesores</h4>
        <p class="text-muted small mb-0">Gestión del cuerpo docente</p>
    </div>
    <a href="{{ route('admin.profesores.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nuevo Profesor
    </a>
</div>
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, documento..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="estado" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    <option value="activo"   {{ request('estado') === 'activo'   ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button>
                <a href="{{ route('admin.profesores.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead><tr><th>#</th><th>Profesor</th><th>Documento</th><th>Especialidad</th><th>Teléfono</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($profesores as $p)
                    <tr>
                        <td class="text-muted small">{{ $p->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($p->foto)
                                    <img src="{{ asset('storage/'.$p->foto) }}" class="avatar" alt="">
                                @else
                                    <div class="avatar d-flex align-items-center justify-content-center bg-success-soft fw-bold" style="color:#166534;font-size:.75rem">
                                        {{ strtoupper(substr($p->user->name,0,2)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold small">{{ $p->user->name }}</div>
                                    <div class="text-muted" style="font-size:.75rem">{{ $p->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="small">{{ $p->documento }}</td>
                        <td class="small">{{ $p->especialidad ?? '—' }}</td>
                        <td class="small text-muted">{{ $p->telefono ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $p->estado === 'activo' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($p->estado) }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.profesores.show', $p) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.profesores.edit', $p) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.profesores.destroy', $p) }}" method="POST" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-5 text-muted"><i class="bi bi-person-badge fs-1 d-block mb-2"></i>No se encontraron profesores</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($profesores->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">{{ $profesores->total() }} registros</small>
        {{ $profesores->links() }}
    </div>
    @endif
</div>
@endsection
