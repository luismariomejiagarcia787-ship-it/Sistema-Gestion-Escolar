<?php $__env->startSection('title','Nueva Matrícula'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item"><a href="<?php echo e(route('admin.matriculas.index')); ?>">Matrículas</a></li><li class="breadcrumb-item active">Nueva</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-card-checklist text-primary me-2"></i>Nueva Matrícula</h4>
    <a href="<?php echo e(route('admin.matriculas.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:650px"><div class="card-body">
<form action="<?php echo e(route('admin.matriculas.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="row g-3">
        <div class="col-12"><label class="form-label fw-semibold">Estudiante *</label>
            <select name="estudiante_id" class="form-select" required>
                <option value="">Seleccionar estudiante...</option>
                <?php $__currentLoopData = $estudiantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($e->id); ?>" <?php echo e(old('estudiante_id')==$e->id?'selected':''); ?>><?php echo e($e->user->name); ?> — <?php echo e($e->documento); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Curso *</label>
            <select name="curso_id" class="form-select" required>
                <option value="">Seleccionar curso...</option>
                <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php echo e(old('curso_id')==$c->id?'selected':''); ?>><?php echo e($c->nombre); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Año Lectivo *</label><input type="number" name="anio_lectivo" class="form-control" value="<?php echo e(old('anio_lectivo', date('Y'))); ?>" min="2020" max="2035" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Fecha de Matrícula *</label><input type="date" name="fecha_matricula" class="form-control" value="<?php echo e(old('fecha_matricula', date('Y-m-d'))); ?>" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Estado *</label>
            <select name="estado" class="form-select" required>
                <option value="activa" <?php echo e(old('estado','activa')==='activa'?'selected':''); ?>>Activa</option>
                <option value="retirada" <?php echo e(old('estado')==='retirada'?'selected':''); ?>>Retirada</option>
                <option value="finalizada" <?php echo e(old('estado')==='finalizada'?'selected':''); ?>>Finalizada</option>
            </select>
        </div>
        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="<?php echo e(route('admin.matriculas.index')); ?>" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Registrar Matrícula</button>
        </div>
    </div>
</form>
</div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/matriculas/create.blade.php ENDPATH**/ ?>