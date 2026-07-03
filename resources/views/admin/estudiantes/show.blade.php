@extends('layouts.app')
@section('title', 'Perfil Estudiante')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.estudiantes.index') }}">Estudiantes</a></li>
    <li class="breadcrumb-item active">{{ $estudiante->user->name }}</li>
@endsection

@section('content')
<div class="row g-3">
    {{-- Profile Card --}}
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                @if($estudiante->foto)
                    <img src="{{ asset('storage/'.$estudiante->foto) }}" class="avatar-xl rounded-circle border mb-3" style="object-fit:cover">
                @else
                    <div class="avatar-xl rounded-circle d-flex align-items-center justify-content-center bg-primary-soft mx-auto mb-3"
                        style="color:#1e40af;font-size:2.5rem;font-weight:700">
                        {{ strtoupper(substr($estudiante->user->name, 0, 2)) }}
                    </div>
                @endif
                <h5 class="fw-bold mb-0">{{ $estudiante->user->name }}</h5>
                <p class="text-muted small mb-2">{{ $estudiante->user->email }}</p>
                <span class="badge {{ $estudiante->estado === 'activo' ? 'bg-success' : 'bg-secondary' }} mb-3">
                    {{ ucfirst($estudiante->estado) }}
                </span>
                <div class="text-start">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted small">Documento</span>
                        <span class="small fw-semibold">{{ $estudiante->documento }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted small">Teléfono</span>
                        <span class="small fw-semibold">{{ $estudiante->telefono ?? '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted small">Género</span>
                        <span class="small fw-semibold">{{ ucfirst($estudiante->genero) }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted small">Nacimiento</span>
                        <span class="small fw-semibold">{{ $estudiante->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted small">Curso</span>
                        <span class="small fw-semibold">{{ $estudiante->curso->nombre ?? '—' }}</span>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.estudiantes.edit', $estudiante) }}" class="btn btn-warning btn-sm flex-fill">
                        <i class="bi bi-pencil me-1"></i> Editar
                    </a>
                </div>
            </div>
        </div>

        {{-- Promedio Card --}}
        <div class="card mt-3">
            <div class="card-body text-center">
                <div class="fs-1 fw-bold {{ $estudiante->promedio >= 4 ? 'nota-alta' : ($estudiante->promedio >= 3 ? 'nota-media' : 'nota-baja') }}">
                    {{ $estudiante->promedio }}
                </div>
                <div class="text-muted small">Promedio General</div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        {{-- Calificaciones --}}
        <div class="card mb-3">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-clipboard2-data me-2 text-primary"></i>Calificaciones</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Materia</th><th>Período</th><th>Nota</th><th>Observación</th></tr></thead>
                        <tbody>
                            @forelse($estudiante->calificaciones as $cal)
                            <tr>
                                <td class="small fw-semibold">{{ $cal->materia->nombre }}</td>
                                <td class="small">Período {{ $cal->periodo }}</td>
                                <td><span class="{{ $cal->nota_color }} fs-6">{{ $cal->nota }}</span></td>
                                <td class="small text-muted">{{ $cal->observacion ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Sin calificaciones</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Asistencias recientes --}}
        <div class="card">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Asistencia Reciente</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Fecha</th><th>Curso</th><th>Estado</th></tr></thead>
                        <tbody>
                            @forelse($estudiante->asistencias->take(10) as $ast)
                            <tr>
                                <td class="small">{{ $ast->fecha->format('d/m/Y') }}</td>
                                <td class="small">{{ $ast->curso->nombre ?? '—' }}</td>
                                <td>{!! $ast->estado_badge !!}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Sin registros</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
