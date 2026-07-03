<?php $__env->startSection('title','Editar Curso'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item"><a href="<?php echo e(route('admin.cursos.index')); ?>">Cursos</a></li><li class="breadcrumb-item active">Editar</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Curso</h4>
    <a href="<?php echo e(route('admin.cursos.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:700px"><div class="card-body">
<form action="<?php echo e(route('admin.cursos.update', $curso)); ?>" method="POST">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold">Nombre *</label><input type="text" name="nombre" class="form-control" value="<?php echo e(old('nombre', $curso->nombre)); ?>" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Código *</label><input type="text" name="codigo" class="form-control" value="<?php echo e(old('codigo', $curso->codigo)); ?>" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Jornada *</label>
            <select name="jornada" class="form-select" required>
                <option value="manana"   <?php echo e(old('jornada',$curso->jornada)==='manana'   ?'selected':''); ?>>Mañana</option>
                <option value="tarde"    <?php echo e(old('jornada',$curso->jornada)==='tarde'    ?'selected':''); ?>>Tarde</option>
                <option value="noche"    <?php echo e(old('jornada',$curso->jornada)==='noche'    ?'selected':''); ?>>Noche</option>
                <option value="completa" <?php echo e(old('jornada',$curso->jornada)==='completa' ?'selected':''); ?>>Completa</option>
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Año Lectivo *</label><input type="number" name="anio_lectivo" class="form-control" value="<?php echo e(old('anio_lectivo', $curso->anio_lectivo)); ?>" required></div>
        <div class="col-12"><label class="form-label fw-semibold">Director de Grupo</label>
            <select name="profesor_id" class="form-select">
                <option value="">Sin asignar</option>
                <?php $__currentLoopData = $profesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>" <?php echo e(old('profesor_id',$curso->profesor_id)==$p->id?'selected':''); ?>><?php echo e($p->user->name); ?> - <?php echo e($p->especialidad); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="<?php echo e(route('admin.cursos.index')); ?>" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Actualizar</button>
        </div>
    </div>
</form>
</div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/cursos/edit.blade.php ENDPATH**/ ?>