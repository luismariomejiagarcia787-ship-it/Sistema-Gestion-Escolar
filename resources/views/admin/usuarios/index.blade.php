@extends('layouts.app')
@section('title','Usuarios')
@section('breadcrumb')<li class="breadcrumb-item active">Usuarios</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div><h4 class="fw-bold mb-0"><i class="bi bi-shield-lock-fill text-primary me-2"></i>Usuarios del Sistema</h4><p class="text-muted small mb-0">Gestión de cuentas y roles</p></div>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" name="search" class="form-control" placeholder="Buscar por nombre o email..." value="{{ request('search') }}"></div></div>
        <div class="col-md-3"><select name="role" class="form-select form-select-sm"><option value="">Todos los roles</option><option value="admin" {{ request('role')==='admin'?'selected':'' }}>Administrador</option><option value="profesor" {{ request('role')==='profesor'?'selected':'' }}>Profesor</option><option value="estudiante" {{ request('role')==='estudiante'?'selected':'' }}>Estudiante</option></select></div>
        <div class="col-md-2 d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button><a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Usuario</th><th>Email</th><th>Rol</th><th>Registro</th><th>Acciones</th></tr></thead>
        <tbody>
            @forelse($usuarios as $u)
            <tr>
                <td class="text-muted small">{{ $u->id }}</td>
                <td class="small fw-semibold">{{ $u->name }}</td>
                <td class="small text-muted">{{ $u->email }}</td>
                <td>
                    @php $roleColors=['admin'=>'bg-danger','profesor'=>'bg-warning text-dark','estudiante'=>'bg-primary']; @endphp
                    <span class="badge {{ $roleColors[$u->role] ?? 'bg-secondary' }}">{{ ucfirst($u->role) }}</span>
                </td>
                <td class="small text-muted">{{ $u->created_at->format('d/m/Y') }}</td>
                <td><div class="d-flex gap-1">
                    <a href="{{ route('admin.usuarios.edit', $u) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    @if($u->id !== auth()->id())
                    <form action="{{ route('admin.usuarios.destroy', $u) }}" method="POST" class="delete-form">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                    @endif
                </div></td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-5 text-muted">Sin usuarios</td></tr>
            @endforelse
        </tbody>
    </table>
</div></div>
@if($usuarios->hasPages())<div class="card-footer d-flex align-items-center justify-content-between"><small class="text-muted">{{ $usuarios->total() }} usuarios</small>{{ $usuarios->links() }}</div>@endif
</div>
@endsection
