<?php $__env->startSection('title','Editar Asistencia'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item"><a href="<?php echo e(route('admin.asistencia.index')); ?>">Asistencia</a></li><li class="breadcrumb-item active">Editar</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Asistencia</h4>
    <a href="<?php echo e(route('admin.asistencia.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:500px"><div class="card-body">
    <strong>Estudiante:</strong>
<?php echo e($asistencia->estudiante?->user?->name ?? 'Sin estudiante asignado'); ?>

        <strong>Curso:</strong> <?php echo e($asistencia->curso?->nombre ?? 'Sin curso asignado'); ?>

    </div>
   <form action="<?php echo e(route('admin.asistencia.update', $asistencia)); ?>" method="POST">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="mb-3"><label class="form-label fw-semibold">Fecha *</label><input type="date" name="fecha" class="form-control" value="<?php echo e(old('fecha',$asistencia->fecha->format('Y-m-d'))); ?>" required></div>
        <div class="mb-4"><label class="form-label fw-semibold">Estado *</label>
            <div class="d-flex gap-3 flex-wrap">
                <?php $__currentLoopData = ['presente','ausente','excusado','tardanza']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="form-check"><input class="form-check-input" type="radio" name="estado" value="<?php echo e($s); ?>" id="s_<?php echo e($s); ?>" <?php echo e(old('estado',$asistencia->estado)===$s?'checked':''); ?> required><label class="form-check-label text-capitalize" for="s_<?php echo e($s); ?>"><?php echo e(ucfirst($s)); ?></label></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <a href="<?php echo e(route('admin.asistencia.index')); ?>" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Actualizar</button>
        </div>
    </form>
</div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/asistencia/edit.blade.php ENDPATH**/ ?>