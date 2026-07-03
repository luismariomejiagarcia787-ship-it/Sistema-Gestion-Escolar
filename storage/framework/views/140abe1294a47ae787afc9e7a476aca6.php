<?php $__env->startSection('title','Editar Materia'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item"><a href="<?php echo e(route('admin.materias.index')); ?>">Materias</a></li><li class="breadcrumb-item active">Editar</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Materia</h4>
    <a href="<?php echo e(route('admin.materias.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:600px"><div class="card-body">
<form action="<?php echo e(route('admin.materias.update', $materia)); ?>" method="POST">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold">Nombre *</label><input type="text" name="nombre" class="form-control" value="<?php echo e(old('nombre', $materia->nombre)); ?>" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Código *</label><input type="text" name="codigo" class="form-control" value="<?php echo e(old('codigo', $materia->codigo)); ?>" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Intensidad Horaria *</label><input type="number" name="intensidad_horaria" class="form-control" value="<?php echo e(old('intensidad_horaria', $materia->intensidad_horaria)); ?>" min="1" max="40" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Profesor Asignado</label>
            <select name="profesor_id" class="form-select">
                <option value="">Sin asignar</option>
                <?php $__currentLoopData = $profesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>" <?php echo e(old('profesor_id',$materia->profesor_id)==$p->id?'selected':''); ?>><?php echo e($p->user->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="<?php echo e(route('admin.materias.index')); ?>" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Actualizar</button>
        </div>
    </div>
</form>
</div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/materias/edit.blade.php ENDPATH**/ ?>