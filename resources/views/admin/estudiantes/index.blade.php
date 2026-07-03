@extends('layouts.app')
@section('title', 'Estudiantes')

@section('breadcrumb')
    <li class="breadcrumb-item active">Estudiantes</li>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-people-fill text-primary me-2"></i>Estudiantes</h4>
        <p class="text-muted small mb-0">Gestión de estudiantes registrados</p>
    </div>
    <a href="{{ route('admin.estudiantes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nuevo Estudiante
    </a>
</div>

{{-- FILTROS --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, email, documento..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="curso" class="form-select form-select-sm">
                    <option value="">Todos los cursos</option>
                    @foreach($cursos as $c)
                        <option value="{{ $c->id }}" {{ request('curso') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="estado" class="form-select form-select-sm">
                    <option value="">Todos los estados</option>
                    <option value="activo"   {{ request('estado') === 'activo'   ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    <option value="retirado" {{ request('estado') === 'retirado' ? 'selected' : '' }}>Retirado</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button>
                <a href="{{ route('admin.estudiantes.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th>#</th><th>Estudiante</th><th>Documento</th><th>Teléfono</th>
                        <th>Curso</th><th>Estado</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($estudiantes as $est)
                    <tr>
                        <td class="text-muted small">{{ $est->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($est->foto)
                                    <img src="{{ asset('storage/'.$est->foto) }}" class="avatar" alt="">
                                @else
                                    <div class="avatar d-flex align-items-center justify-content-center bg-primary-soft fw-bold"
                                        style="color:#1e40af;font-size:.75rem">
                                        {{ strtoupper(substr($est->user->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold small">{{ $est->user->name }}</div>
                                    <div class="text-muted" style="font-size:.75rem">{{ $est->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="small">{{ $est->documento }}</td>
                        <td class="small text-muted">{{ $est->telefono ?? '—' }}</td>
                        <td class="small">{{ $est->curso->nombre ?? '—' }}</td>
                        <td>
                            @if($est->estado === 'activo')
                                <span class="badge bg-success">Activo</span>
                            @elseif($est->estado === 'inactivo')
                                <span class="badge bg-secondary">Inactivo</span>
                            @else
                                <span class="badge bg-danger">Retirado</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.estudiantes.show', $est) }}" class="btn btn-sm btn-outline-info" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.estudiantes.edit', $est) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.estudiantes.destroy', $est) }}" method="POST" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2"></i>
                            No se encontraron estudiantes
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($estudiantes->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">Mostrando {{ $estudiantes->firstItem() }}-{{ $estudiantes->lastItem() }} de {{ $estudiantes->total() }}</small>
        {{ $estudiantes->links() }}
    </div>
    @endif
</div>
@endsection
