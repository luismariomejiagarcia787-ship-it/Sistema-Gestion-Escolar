<?php $__env->startSection('title','Materias'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item active">Materias</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div><h4 class="fw-bold mb-0"><i class="bi bi-journal-text text-primary me-2"></i>Materias</h4><p class="text-muted small mb-0">Gestión de materias académicas</p></div>
    <a href="<?php echo e(route('admin.materias.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nueva Materia</a>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-7"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" name="search" class="form-control" placeholder="Buscar por nombre o código..." value="<?php echo e(request('search')); ?>"></div></div>
        <div class="col-md-3 d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button><a href="<?php echo e(route('admin.materias.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Materia</th><th>Código</th><th>Horas/Semana</th><th>Profesor</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="text-muted small"><?php echo e($m->id); ?></td>
                <td class="fw-semibold small"><?php echo e($m->nombre); ?></td>
                <td><span class="badge bg-primary-soft text-primary"><?php echo e($m->codigo); ?></span></td>
                <td class="small"><?php echo e($m->intensidad_horaria); ?> h</td>
                <td class="small"><?php echo e($m->profesor->user->name ?? '—'); ?></td>
                <td><div class="d-flex gap-1">
                    <a href="<?php echo e(route('admin.materias.edit', $m)); ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="<?php echo e(route('admin.materias.destroy', $m)); ?>" method="POST" class="delete-form"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                </div></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" class="text-center py-5 text-muted"><i class="bi bi-journal fs-1 d-block mb-2"></i>Sin materias registradas</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div></div>
<?php if($materias->hasPages()): ?><div class="card-footer"><?php echo e($materias->links()); ?></div><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/materias/index.blade.php ENDPATH**/ ?>