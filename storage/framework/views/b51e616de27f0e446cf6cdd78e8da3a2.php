<?php $__env->startSection('title','Matrículas'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item active">Matrículas</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div><h4 class="fw-bold mb-0"><i class="bi bi-card-checklist text-primary me-2"></i>Matrículas</h4><p class="text-muted small mb-0">Gestión de matrículas estudiantiles</p></div>
    <a href="<?php echo e(route('admin.matriculas.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nueva Matrícula</a>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4"><div class="input-group input-group-sm"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" name="search" class="form-control" placeholder="Buscar estudiante..." value="<?php echo e(request('search')); ?>"></div></div>
        <div class="col-md-3"><select name="curso_id" class="form-select form-select-sm"><option value="">Todos los cursos</option><?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php echo e(request('curso_id')==$c->id?'selected':''); ?>><?php echo e($c->nombre); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="col-md-2"><select name="estado" class="form-select form-select-sm"><option value="">Todos</option><option value="activa" <?php echo e(request('estado')==='activa'?'selected':''); ?>>Activa</option><option value="retirada" <?php echo e(request('estado')==='retirada'?'selected':''); ?>>Retirada</option><option value="finalizada" <?php echo e(request('estado')==='finalizada'?'selected':''); ?>>Finalizada</option></select></div>
        <div class="col-md-3 d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button><a href="<?php echo e(route('admin.matriculas.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div></div>
<div class="card"><div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Estudiante</th><th>Curso</th><th>Año</th><th>Fecha Matrícula</th><th>Estado</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $matriculas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="text-muted small"><?php echo e($m->id); ?></td>
                <td class="small fw-semibold"><?php echo e($m->estudiante->user->name); ?></td>
                <td class="small"><?php echo e($m->curso->nombre); ?></td>
                <td class="small"><?php echo e($m->anio_lectivo); ?></td>
                <td class="small text-muted"><?php echo e($m->fecha_matricula->format('d/m/Y')); ?></td>
                <td><?php echo $m->estado_badge; ?></td>
                <td><div class="d-flex gap-1">
                    <a href="<?php echo e(route('admin.matriculas.edit', $m)); ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form action="<?php echo e(route('admin.matriculas.destroy', $m)); ?>" method="POST" class="delete-form"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                </div></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7" class="text-center py-5 text-muted"><i class="bi bi-card-checklist fs-1 d-block mb-2"></i>Sin matrículas registradas</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div></div>
<?php if($matriculas->hasPages()): ?><div class="card-footer d-flex align-items-center justify-content-between"><small class="text-muted"><?php echo e($matriculas->total()); ?> registros</small><?php echo e($matriculas->links()); ?></div><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/matriculas/index.blade.php ENDPATH**/ ?>