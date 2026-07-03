@extends('layouts.app')
@section('title','Perfil Profesor')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.profesores.index') }}">Profesores</a></li>
    <li class="breadcrumb-item active">{{ $profesor->user->name }}</li>
@endsection
@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                @if($profesor->foto)
                    <img src="{{ asset('storage/'.$profesor->foto) }}" class="avatar-xl rounded-circle border mb-3" style="object-fit:cover">
                @else
                    <div class="avatar-xl rounded-circle d-flex align-items-center justify-content-center bg-success-soft mx-auto mb-3" style="color:#166534;font-size:2.5rem;font-weight:700">{{ strtoupper(substr($profesor->user->name,0,2)) }}</div>
                @endif
                <h5 class="fw-bold mb-0">{{ $profesor->user->name }}</h5>
                <p class="text-muted small">{{ $profesor->especialidad ?? 'Docente' }}</p>
                <span class="badge {{ $profesor->estado === 'activo' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($profesor->estado) }}</span>
                <div class="text-start mt-3">
                    <div class="d-flex justify-content-between border-bottom py-2"><span class="text-muted small">Email</span><span class="small fw-semibold">{{ $profesor->user->email }}</span></div>
                    <div class="d-flex justify-content-between border-bottom py-2"><span class="text-muted small">Documento</span><span class="small fw-semibold">{{ $profesor->documento }}</span></div>
                    <div class="d-flex justify-content-between border-bottom py-2"><span class="text-muted small">Teléfono</span><span class="small fw-semibold">{{ $profesor->telefono ?? '—' }}</span></div>
                    <div class="d-flex justify-content-between py-2"><span class="text-muted small">Ingreso</span><span class="small fw-semibold">{{ $profesor->fecha_ingreso?->format('d/m/Y') ?? '—' }}</span></div>
                </div>
                <a href="{{ route('admin.profesores.edit', $profesor) }}" class="btn btn-warning btn-sm w-100 mt-3"><i class="bi bi-pencil me-1"></i>Editar</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-book text-primary me-2"></i>Cursos Asignados ({{ $profesor->cursos->count() }})</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Curso</th><th>Código</th><th>Jornada</th><th>Año</th></tr></thead>
                        <tbody>
                            @forelse($profesor->cursos as $c)
                            <tr>
                                <td class="fw-semibold small">{{ $c->nombre }}</td>
                                <td class="small">{{ $c->codigo }}</td>
                                <td class="small">{{ $c->jornada_label }}</td>
                                <td class="small">{{ $c->anio_lectivo }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Sin cursos asignados</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-journal text-primary me-2"></i>Materias a Cargo ({{ $profesor->materias->count() }})</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Materia</th><th>Código</th><th>Horas</th></tr></thead>
                        <tbody>
                            @forelse($profesor->materias as $m)
                            <tr>
                                <td class="fw-semibold small">{{ $m->nombre }}</td>
                                <td class="small">{{ $m->codigo }}</td>
                                <td class="small">{{ $m->intensidad_horaria }} h/sem</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Sin materias asignadas</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
