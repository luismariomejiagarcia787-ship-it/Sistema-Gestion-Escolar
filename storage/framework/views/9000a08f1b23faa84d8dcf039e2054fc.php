<?php $__env->startSection('title','Dashboard Profesor'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item active">Dashboard</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0">Bienvenido, <?php echo e(auth()->user()->name); ?></h4>
        <p class="text-muted small mb-0">Panel del Profesor — <?php echo e(now()->format('d/m/Y')); ?></p>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-primary-soft"><i class="bi bi-book-half"></i></div>
            <div><div class="fw-bold fs-4"><?php echo e($cursos->count()); ?></div><div class="text-muted small">Mis Cursos</div></div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-success-soft"><i class="bi bi-people-fill"></i></div>
            <div><div class="fw-bold fs-4"><?php echo e($cursos->sum('estudiantes_count')); ?></div><div class="text-muted small">Mis Estudiantes</div></div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-warning-soft"><i class="bi bi-clipboard2-data-fill"></i></div>
            <div><div class="fw-bold fs-4"><?php echo e($totalNotas); ?></div><div class="text-muted small">Notas Registradas</div></div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card"><div class="card-body d-flex align-items-center gap-3">
            <div class="icon-box bg-teal-soft"><i class="bi bi-calendar-check-fill"></i></div>
            <div><div class="fw-bold fs-4"><?php echo e($totalAsist); ?></div><div class="text-muted small">Asistencias Hoy</div></div>
        </div></div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card h-100"><div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-book text-primary me-2"></i>Mis Cursos</h6></div>
        <div class="card-body p-0"><div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead><tr><th>Curso</th><th>Jornada</th><th>Estudiantes</th><th></th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-semibold small"><?php echo e($c->nombre); ?></td>
                        <td class="small"><?php echo e($c->jornada_label); ?></td>
                        <td><span class="badge bg-primary"><?php echo e($c->estudiantes_count); ?></span></td>
                        <td><a href="<?php echo e(route('profesor.asistencia.create')); ?>" class="btn btn-xs btn-outline-primary btn-sm py-0 px-2">Asistencia</a></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="text-center text-muted py-3">Sin cursos asignados</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div></div></div>
    </div>
    <div class="col-md-7">
        <div class="card h-100"><div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0"><i class="bi bi-clipboard2 text-primary me-2"></i>Últimas Notas Ingresadas</h6>
            <a href="<?php echo e(route('profesor.calificaciones.create')); ?>" class="btn btn-sm btn-primary">+ Nueva Nota</a>
        </div>
        <div class="card-body p-0"><div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead><tr><th>Estudiante</th><th>Materia</th><th>Período</th><th>Nota</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $ultimasNotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="small fw-semibold"><?php echo e($n->estudiante->user->name); ?></td>
                        <td class="small text-muted"><?php echo e($n->materia->nombre); ?></td>
                        <td class="small">P<?php echo e($n->periodo); ?></td>
                        <td><span class="<?php echo e($n->nota_color); ?> fw-bold"><?php echo e($n->nota); ?></span></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="text-center text-muted py-3">Sin notas registradas</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div></div></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/profesor/dashboard/index.blade.php ENDPATH**/ ?>