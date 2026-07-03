<?php $__env->startSection('title','Mis Calificaciones'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item active">Calificaciones</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div><h4 class="fw-bold mb-0"><i class="bi bi-clipboard2-data-fill text-primary me-2"></i>Calificaciones</h4></div>
    <a href="<?php echo e(route('profesor.calificaciones.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nueva Nota</a>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" name="search" class="form-control" placeholder="Buscar estudiante..." value="<?php echo e(request('search')); ?>"></div></div>
        <div class="col-md-3"><select name="periodo" class="form-select form-select-sm"><option value="">Todos los períodos</option><?php $__currentLoopData = ['1','2','3','4']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p); ?>" <?php echo e(request('periodo')===$p?'selected':''); ?>>Período <?php echo e($p); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="col-md-2 d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button><a href="<?php echo e(route('profesor.calificaciones.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Estudiante</th><th>Materia</th><th>Período</th><th>Nota</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $calificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="small text-muted"><?php echo e($c->id); ?></td>
                <td class="small fw-semibold"><?php echo e($c->estudiante->user->name); ?></td>
                <td class="small"><?php echo e($c->materia->nombre); ?></td>
                <td class="small">Período <?php echo e($c->periodo); ?></td>
                <td><span class="<?php echo e($c->nota_color); ?> fw-bold fs-6"><?php echo e($c->nota); ?></span></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?php echo e(route('profesor.calificaciones.edit', $c)); ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('profesor.calificaciones.destroy', $c)); ?>" method="POST" class="delete-form">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" class="text-center py-5 text-muted"><i class="bi bi-clipboard2 fs-1 d-block mb-2"></i>Sin calificaciones</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div></div>
<?php if($calificaciones->hasPages()): ?><div class="card-footer"><?php echo e($calificaciones->links()); ?></div><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/profesor/calificaciones/index.blade.php ENDPATH**/ ?>