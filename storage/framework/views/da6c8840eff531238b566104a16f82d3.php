<?php $__env->startSection('title','Asistencia'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item active">Asistencia</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div><h4 class="fw-bold mb-0"><i class="bi bi-calendar-check-fill text-primary me-2"></i>Asistencia</h4></div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('profesor.asistencia.reporte')); ?>" class="btn btn-outline-primary"><i class="bi bi-bar-chart me-1"></i>Reporte</a>
        <a href="<?php echo e(route('profesor.asistencia.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Registrar Asistencia</a>
    </div>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3"><select name="curso_id" class="form-select form-select-sm"><option value="">Todos los cursos</option><?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php echo e(request('curso_id')==$c->id?'selected':''); ?>><?php echo e($c->nombre); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="col-md-3"><input type="date" name="fecha" class="form-control form-control-sm" value="<?php echo e(request('fecha')); ?>"></div>
        <div class="col-md-2"><select name="estado" class="form-select form-select-sm"><option value="">Todos</option><option value="presente">Presente</option><option value="ausente">Ausente</option><option value="excusado">Excusado</option><option value="tardanza">Tardanza</option></select></div>
        <div class="col-md-2 d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button><a href="<?php echo e(route('profesor.asistencia.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Estudiante</th><th>Curso</th><th>Fecha</th><th>Estado</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $asistencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="small text-muted"><?php echo e($a->id); ?></td>
                <td class="small fw-semibold"><?php echo e($a->estudiante->user->name); ?></td>
                <td class="small"><?php echo e($a->curso->nombre); ?></td>
                <td class="small text-muted"><?php echo e($a->fecha->format('d/m/Y')); ?></td>
                <td><?php echo $a->estado_badge; ?></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?php echo e(route('profesor.asistencia.edit', $a)); ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('profesor.asistencia.destroy', $a)); ?>" method="POST" class="delete-form">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" class="text-center py-5 text-muted"><i class="bi bi-calendar-x fs-1 d-block mb-2"></i>Sin registros de asistencia</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div></div>
<?php if($asistencias->hasPages()): ?><div class="card-footer"><?php echo e($asistencias->links()); ?></div><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/profesor/asistencia/index.blade.php ENDPATH**/ ?>