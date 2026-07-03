<?php $__env->startSection('title','Detalle Curso'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item"><a href="<?php echo e(route('admin.cursos.index')); ?>">Cursos</a></li><li class="breadcrumb-item active"><?php echo e($curso->nombre); ?></li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card mb-3"><div class="card-body">
            <h5 class="fw-bold"><?php echo e($curso->nombre); ?></h5>
            <p class="text-muted small mb-3">Código: <strong><?php echo e($curso->codigo); ?></strong></p>
            <div class="list-group list-group-flush small">
                <div class="list-group-item d-flex justify-content-between px-0"><span>Jornada</span><strong><?php echo e($curso->jornada_label); ?></strong></div>
                <div class="list-group-item d-flex justify-content-between px-0"><span>Año Lectivo</span><strong><?php echo e($curso->anio_lectivo); ?></strong></div>
                <div class="list-group-item d-flex justify-content-between px-0"><span>Director</span><strong><?php echo e($curso->profesor->user->name ?? '—'); ?></strong></div>
                <div class="list-group-item d-flex justify-content-between px-0"><span>Estudiantes</span><strong><?php echo e($curso->estudiantes->count()); ?></strong></div>
            </div>
            <a href="<?php echo e(route('admin.cursos.edit', $curso)); ?>" class="btn btn-warning btn-sm w-100 mt-3"><i class="bi bi-pencil me-1"></i>Editar</a>
        </div></div>
        <div class="card"><div class="card-header"><h6 class="fw-bold mb-0">Asignar Materias</h6></div><div class="card-body">
            <form action="<?php echo e(route('admin.cursos.materias', $curso)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php $__currentLoopData = $curso->materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="form-check"><input class="form-check-input" type="checkbox" name="materias[]" value="<?php echo e($m->id); ?>" checked id="m<?php echo e($m->id); ?>"><label class="form-check-label small" for="m<?php echo e($m->id); ?>"><?php echo e($m->nombre); ?></label></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <button type="submit" class="btn btn-sm btn-primary mt-2 w-100">Guardar</button>
            </form>
        </div></div>
    </div>
    <div class="col-md-8">
        <div class="card"><div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-people text-primary me-2"></i>Estudiantes (<?php echo e($curso->estudiantes->count()); ?>)</h6></div>
        <div class="card-body p-0"><div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead><tr><th>Nombre</th><th>Documento</th><th>Estado</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $curso->estudiantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="small fw-semibold"><?php echo e($e->user->name); ?></td>
                        <td class="small text-muted"><?php echo e($e->documento); ?></td>
                        <td><span class="badge <?php echo e($e->estado==='activo'?'bg-success':'bg-secondary'); ?>"><?php echo e(ucfirst($e->estado)); ?></span></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="3" class="text-center text-muted py-3">Sin estudiantes</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div></div></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/cursos/show.blade.php ENDPATH**/ ?>