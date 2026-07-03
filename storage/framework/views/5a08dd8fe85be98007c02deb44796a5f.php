<?php $__env->startSection('title','Notas por Estudiante'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item"><a href="<?php echo e(route('admin.calificaciones.index')); ?>">Calificaciones</a></li><li class="breadcrumb-item active">Por Estudiante</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-person-lines-fill text-primary me-2"></i>Notas por Estudiante</h4>
    <a href="<?php echo e(route('admin.calificaciones.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card mb-3"><div class="card-body">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-4"><label class="form-label fw-semibold small">Curso</label>
            <select name="curso_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Seleccionar curso...</option>
                <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php echo e(request('curso_id')==$c->id?'selected':''); ?>><?php echo e($c->nombre); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <?php if($estudiantes->count()): ?>
        <div class="col-md-4"><label class="form-label fw-semibold small">Estudiante</label>
            <select name="estudiante_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Seleccionar estudiante...</option>
                <?php $__currentLoopData = $estudiantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($e->id); ?>" <?php echo e(request('estudiante_id')==$e->id?'selected':''); ?>><?php echo e($e->user->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <?php endif; ?>
    </form>
</div></div>

<?php if($estudiante): ?>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6 class="fw-bold mb-0"><i class="bi bi-person-circle me-2 text-primary"></i><?php echo e($estudiante->user->name); ?></h6>
        <?php if($calificaciones->count()): ?>
        <span class="badge bg-primary">Promedio: <?php echo e(round($calificaciones->avg('nota'),2)); ?></span>
        <?php endif; ?>
    </div>
    <div class="card-body p-0"><div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead><tr><th>Materia</th><th>Período</th><th>Nota</th><th>Profesor</th><th>Observación</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $calificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="small fw-semibold"><?php echo e($c->materia->nombre); ?></td>
                    <td class="small">Período <?php echo e($c->periodo); ?></td>
                    <td><span class="<?php echo e($c->nota_color); ?> fw-bold fs-6"><?php echo e($c->nota); ?></span></td>
                    <td class="small text-muted"><?php echo e($c->profesor->user->name ?? '—'); ?></td>
                    <td class="small text-muted"><?php echo e($c->observacion ?? '—'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center text-muted py-3">Sin calificaciones</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div></div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/calificaciones/por-estudiante.blade.php ENDPATH**/ ?>