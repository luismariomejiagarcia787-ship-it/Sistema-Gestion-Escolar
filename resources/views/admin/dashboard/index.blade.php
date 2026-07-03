@extends('layouts.app')
@section('title', 'Dashboard Administrador')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0">Panel de Administración</h4>
        <p class="text-muted small mb-0">Bienvenido, {{ auth()->user()->name }} — {{ now()->format('d/m/Y') }}</p>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $cards = [
        ['label'=>'Estudiantes', 'value'=>$stats['estudiantes'], 'icon'=>'people-fill',         'color'=>'bg-primary-soft',  'route'=>'admin.estudiantes.index'],
        ['label'=>'Profesores',  'value'=>$stats['profesores'],  'icon'=>'person-badge-fill',    'color'=>'bg-success-soft',  'route'=>'admin.profesores.index'],
        ['label'=>'Cursos',      'value'=>$stats['cursos'],      'icon'=>'book-half',            'color'=>'bg-warning-soft',  'route'=>'admin.cursos.index'],
        ['label'=>'Materias',    'value'=>$stats['materias'],    'icon'=>'journal-text',         'color'=>'bg-danger-soft',   'route'=>'admin.materias.index'],
        ['label'=>'Matrículas',  'value'=>$stats['matriculas'],  'icon'=>'card-checklist',       'color'=>'bg-purple-soft',   'route'=>'admin.matriculas.index'],
        ['label'=>'Asistencias hoy','value'=>$stats['asistencias'],'icon'=>'calendar-check-fill','color'=>'bg-teal-soft',    'route'=>'admin.asistencia.index'],
        ['label'=>'Promedio General','value'=>$stats['promedio'],'icon'=>'graph-up-arrow',       'color'=>'bg-primary-soft',  'route'=>'admin.calificaciones.index'],
    ];
    @endphp
    @foreach($cards as $card)
    <div class="col-6 col-md-4 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box {{ $card['color'] }}">
                    <i class="bi bi-{{ $card['icon'] }}"></i>
                </div>
                <div>
                    <div class="fw-bold fs-4 lh-1">{{ $card['value'] }}</div>
                    <div class="text-muted small">{{ $card['label'] }}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- CHARTS ROW --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Asistencia General</h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" style="height:260px">
                <canvas id="chartAsistencia"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="fw-bold mb-0"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Promedio por Período</h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" style="height:260px">
                <canvas id="chartPeriodos"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- STUDENTS PER COURSE + RECENT --}}
<div class="row g-3">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-bold mb-0"><i class="bi bi-bar-chart-steps text-primary me-2"></i>Estudiantes por Curso</h6>
            </div>
            <div class="card-body" style="height:260px">
                <canvas id="chartCursos"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0"><i class="bi bi-clock-history text-primary me-2"></i>Últimos Estudiantes</h6>
                <a href="{{ route('admin.estudiantes.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Nombre</th><th>Documento</th><th>Curso</th><th>Estado</th></tr></thead>
                        <tbody>
                            @forelse($ultimosEstudiantes as $est)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                            style="width:32px;height:32px;background:#dbeafe;color:#1e40af;font-size:.8rem;font-weight:700">
                                            {{ strtoupper(substr($est->user->name, 0, 2)) }}
                                        </div>
                                        <span class="fw-semibold small">{{ $est->user->name }}</span>
                                    </div>
                                </td>
                                <td class="small text-muted">{{ $est->documento }}</td>
                                <td class="small">{{ $est->curso->nombre ?? '—' }}</td>
                                <td><span class="badge {{ $est->estado === 'activo' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($est->estado) }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">Sin registros</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const asistData = @json($asistenciaStats);
new Chart(document.getElementById('chartAsistencia'), {
    type: 'doughnut',
    data: {
        labels: ['Presente','Ausente','Excusado','Tardanza'],
        datasets: [{
            data: [asistData.presente, asistData.ausente, asistData.excusado, asistData.tardanza],
            backgroundColor: ['#16a34a','#dc2626','#d97706','#2563c7'],
            borderWidth: 2
        }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
});

const periodos = @json($notasPorPeriodo);
new Chart(document.getElementById('chartPeriodos'), {
    type: 'bar',
    data: {
        labels: periodos.map(p => 'Período ' + p.periodo),
        datasets: [{
            label: 'Promedio',
            data: periodos.map(p => parseFloat(p.promedio).toFixed(2)),
            backgroundColor: '#2563c7',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        scales: { y: { beginAtZero: true, max: 5 } },
        plugins: { legend: { display: false } }
    }
});

const cursos = @json($estudiantesPorCurso);
new Chart(document.getElementById('chartCursos'), {
    type: 'horizontalBar',
    type: 'bar',
    data: {
        labels: cursos.map(c => c.nombre),
        datasets: [{
            label: 'Estudiantes',
            data: cursos.map(c => c.estudiantes_count),
            backgroundColor: ['#1a4a8a','#2563c7','#16a34a','#d97706','#dc2626'],
            borderRadius: 6,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush
