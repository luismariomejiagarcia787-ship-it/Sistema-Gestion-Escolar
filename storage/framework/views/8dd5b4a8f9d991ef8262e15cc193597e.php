<?php $__env->startSection('title','Mi Dashboard'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item active">Mi Portal</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0">Bienvenido, <?php echo e(auth()->user()->name); ?></h4>
    <p class="text-muted small">Portal estudiantil — <?php echo e(now()->format('d/m/Y')); ?></p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-primary-soft"><i class="bi bi-book-half"></i></div>
            <div><div class="fw-bold fs-4"><?php echo e($estudiante->curso->materias->count() ?? 0); ?></div><div class="text-muted small">Materias</div></div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-success-soft"><i class="bi bi-graph-up-arrow"></i></div>
            <div><div class="fw-bold fs-4 <?php echo e($promedio>=4?'nota-alta':($promedio>=3?'nota-media':'nota-baja')); ?>"><?php echo e($promedio); ?></div><div class="text-muted small">Mi Promedio</div></div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-teal-soft"><i class="bi bi-calendar-check-fill"></i></div>
            <div><div class="fw-bold fs-4"><?php echo e($porcentajeAsist); ?>%</div><div class="text-muted small">% Asistencia</div></div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-warning-soft"><i class="bi bi-mortarboard-fill"></i></div>
            <div><div class="fw-bold fs-4 small"><?php echo e($estudiante->curso->nombre ?? '—'); ?></div><div class="text-muted small">Mi Curso</div></div>
        </div></div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-clipboard2-data text-primary me-2"></i>Mis Calificaciones</h6></div>
            <div class="card-body p-0"><div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead><tr><th>Materia</th><th>Período</th><th>Nota</th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $calificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="small fw-semibold"><?php echo e($c->materia->nombre); ?></td>
                            <td class="small">Período <?php echo e($c->periodo); ?></td>
                            <td><span class="<?php echo e($c->nota_color); ?> fw-bold fs-6"><?php echo e($c->nota); ?></span></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="3" class="text-center text-muted py-4">Sin calificaciones registradas</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div></div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-person-circle text-primary me-2"></i>Mi Información</h6></div>
            <div class="card-body small">
                <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Nombre</span><strong><?php echo e($estudiante->user->name); ?></strong></div>
                <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Documento</span><strong><?php echo e($estudiante->documento); ?></strong></div>
                <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Email</span><span class="text-truncate" style="max-width:150px"><?php echo e($estudiante->user->email); ?></span></div>
                <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Curso</span><strong><?php echo e($estudiante->curso->nombre ?? '—'); ?></strong></div>
                <div class="d-flex justify-content-between py-1"><span class="text-muted">Estado</span><span class="badge bg-success"><?php echo e(ucfirst($estudiante->estado)); ?></span></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-calendar text-primary me-2"></i>Asistencia Reciente</h6></div>
            <div class="card-body p-0"><div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead><tr><th>Fecha</th><th>Estado</th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $asistencias->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr><td class="small"><?php echo e($a->fecha->format('d/m/Y')); ?></td><td><?php echo $a->estado_badge; ?></td></tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="2" class="text-center text-muted py-3">Sin registros</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/estudiante/dashboard/index.blade.php ENDPATH**/ ?>