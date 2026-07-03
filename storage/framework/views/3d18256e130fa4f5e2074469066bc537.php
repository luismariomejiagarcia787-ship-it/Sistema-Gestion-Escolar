<?php $__env->startSection('title','Editar Nota'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item"><a href="<?php echo e(route('profesor.calificaciones.index')); ?>">Calificaciones</a></li><li class="breadcrumb-item active">Editar</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Nota</h4>
    <a href="<?php echo e(route('profesor.calificaciones.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:650px"><div class="card-body">
<form action="<?php echo e(route('profesor.calificaciones.update', $calificacion)); ?>" method="POST">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div class="row g-3">
        <div class="col-12"><label class="form-label fw-semibold">Estudiante</label>
            <select name="estudiante_id" class="form-select" required>
                <?php $__currentLoopData = $estudiantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($e->id); ?>" <?php echo e(old('estudiante_id',$calificacion->estudiante_id)==$e->id?'selected':''); ?>><?php echo e($e->user->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Materia</label>
            <select name="materia_id" class="form-select" required>
                <?php $__currentLoopData = $materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($m->id); ?>" <?php echo e(old('materia_id',$calificacion->materia_id)==$m->id?'selected':''); ?>><?php echo e($m->nombre); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Nota *</label><input type="number" name="nota" class="form-control" value="<?php echo e(old('nota',$calificacion->nota)); ?>" min="0" max="5" step="0.1" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Período *</label>
            <select name="periodo" class="form-select" required>
                <?php $__currentLoopData = ['1','2','3','4']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p); ?>" <?php echo e(old('periodo',$calificacion->periodo)===$p?'selected':''); ?>>Período <?php echo e($p); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-12"><label class="form-label fw-semibold">Observación</label><textarea name="observacion" class="form-control" rows="2"><?php echo e(old('observacion',$calificacion->observacion)); ?></textarea></div>
        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="<?php echo e(route('profesor.calificaciones.index')); ?>" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Actualizar</button>
        </div>
    </div>
</form>
</div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/profesor/calificaciones/edit.blade.php ENDPATH**/ ?>