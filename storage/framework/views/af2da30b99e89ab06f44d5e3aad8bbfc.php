<?php $__env->startSection('title','Cursos'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item active">Cursos</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div><h4 class="fw-bold mb-0"><i class="bi bi-book-half text-primary me-2"></i>Cursos</h4><p class="text-muted small mb-0">Gestión de cursos académicos</p></div>
    <a href="<?php echo e(route('admin.cursos.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nuevo Curso</a>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" name="search" class="form-control" placeholder="Buscar..." value="<?php echo e(request('search')); ?>"></div></div>
        <div class="col-md-3"><select name="jornada" class="form-select form-select-sm"><option value="">Todas las jornadas</option><option value="manana" <?php echo e(request('jornada')==='manana'?'selected':''); ?>>Mañana</option><option value="tarde" <?php echo e(request('jornada')==='tarde'?'selected':''); ?>>Tarde</option><option value="noche" <?php echo e(request('jornada')==='noche'?'selected':''); ?>>Noche</option><option value="completa" <?php echo e(request('jornada')==='completa'?'selected':''); ?>>Completa</option></select></div>
        <div class="col-md-2 d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button><a href="<?php echo e(route('admin.cursos.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Nombre</th><th>Código</th><th>Jornada</th><th>Año</th><th>Director Grupo</th><th>Estudiantes</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="text-muted small"><?php echo e($c->id); ?></td>
                <td class="fw-semibold small"><?php echo e($c->nombre); ?></td>
                <td><span class="badge bg-primary-soft text-primary"><?php echo e($c->codigo); ?></span></td>
                <td class="small"><?php echo e($c->jornada_label); ?></td>
                <td class="small"><?php echo e($c->anio_lectivo); ?></td>
                <td class="small"><?php echo e($c->profesor->user->name ?? '—'); ?></td>
                <td><span class="badge bg-info-subtle text-info"><?php echo e($c->estudiantes_count); ?></span></td>
                <td><div class="d-flex gap-1">
                    <a href="<?php echo e(route('admin.cursos.show', $c)); ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                    <a href="<?php echo e(route('admin.cursos.edit', $c)); ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="<?php echo e(route('admin.cursos.destroy', $c)); ?>" method="POST" class="delete-form"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                </div></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" class="text-center py-5 text-muted"><i class="bi bi-book fs-1 d-block mb-2"></i>Sin cursos registrados</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div></div>
<?php if($cursos->hasPages()): ?><div class="card-footer"><?php echo e($cursos->links()); ?></div><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/cursos/index.blade.php ENDPATH**/ ?>