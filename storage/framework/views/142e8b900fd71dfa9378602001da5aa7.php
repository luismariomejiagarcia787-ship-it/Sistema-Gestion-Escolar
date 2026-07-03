<?php $__env->startSection('title', 'Dashboard Administrador'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Dashboard</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0">Panel de Administración</h4>
        <p class="text-muted small mb-0">Bienvenido, <?php echo e(auth()->user()->name); ?> — <?php echo e(now()->format('d/m/Y')); ?></p>
    </div>
</div>


<div class="row g-3 mb-4">
    <?php
    $cards = [
        ['label'=>'Estudiantes', 'value'=>$stats['estudiantes'], 'icon'=>'people-fill',         'color'=>'bg-primary-soft',  'route'=>'admin.estudiantes.index'],
        ['label'=>'Profesores',  'value'=>$stats['profesores'],  'icon'=>'person-badge-fill',    'color'=>'bg-success-soft',  'route'=>'admin.profesores.index'],
        ['label'=>'Cursos',      'value'=>$stats['cursos'],      'icon'=>'book-half',            'color'=>'bg-warning-soft',  'route'=>'admin.cursos.index'],
        ['label'=>'Materias',    'value'=>$stats['materias'],    'icon'=>'journal-text',         'color'=>'bg-danger-soft',   'route'=>'admin.materias.index'],
        ['label'=>'Matrículas',  'value'=>$stats['matriculas'],  'icon'=>'card-checklist',       'color'=>'bg-purple-soft',   'route'=>'admin.matriculas.index'],
        ['label'=>'Asistencias hoy','value'=>$stats['asistencias'],'icon'=>'calendar-check-fill','color'=>'bg-teal-soft',    'route'=>'admin.asistencia.index'],
        ['label'=>'Promedio General','value'=>$stats['promedio'],'icon'=>'graph-up-arrow',       'color'=>'bg-primary-soft',  'route'=>'admin.calificaciones.index'],
    ];
    ?>
    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-6 col-md-4 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box <?php echo e($card['color']); ?>">
                    <i class="bi bi-<?php echo e($card['icon']); ?>"></i>
                </div>
                <div>
                    <div class="fw-bold fs-4 lh-1"><?php echo e($card['value']); ?></div>
                    <div class="text-muted small"><?php echo e($card['label']); ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


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
                <a href="<?php echo e(route('admin.estudiantes.index')); ?>" class="btn btn-sm btn-outline-primary">Ver todos</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Nombre</th><th>Documento</th><th>Curso</th><th>Estado</th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $ultimosEstudiantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                            style="width:32px;height:32px;background:#dbeafe;color:#1e40af;font-size:.8rem;font-weight:700">
                                            <?php echo e(strtoupper(substr($est->user->name, 0, 2))); ?>

                                        </div>
                                        <span class="fw-semibold small"><?php echo e($est->user->name); ?></span>
                                    </div>
                                </td>
                                <td class="small text-muted"><?php echo e($est->documento); ?></td>
                                <td class="small"><?php echo e($est->curso->nombre ?? '—'); ?></td>
                                <td><span class="badge <?php echo e($est->estado === 'activo' ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e(ucfirst($est->estado)); ?></span></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">Sin registros</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const asistData = <?php echo json_encode($asistenciaStats, 15, 512) ?>;
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

const periodos = <?php echo json_encode($notasPorPeriodo, 15, 512) ?>;
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

const cursos = <?php echo json_encode($estudiantesPorCurso, 15, 512) ?>;
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>