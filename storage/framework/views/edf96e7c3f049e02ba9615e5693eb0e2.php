<?php $__env->startSection('title', 'Editar Estudiante'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.estudiantes.index')); ?>">Estudiantes</a></li>
    <li class="breadcrumb-item active">Editar</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Estudiante</h4>
    <a href="<?php echo e(route('admin.estudiantes.index')); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Volver
    </a>
</div>

<form action="<?php echo e(route('admin.estudiantes.update', $estudiante)); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div class="row g-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h6 class="fw-bold mb-0">Información Personal</h6></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $estudiante->user->name)); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Documento <span class="text-danger">*</span></label>
                            <input type="text" name="documento" class="form-control" value="<?php echo e(old('documento', $estudiante->documento)); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $estudiante->user->email)); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nueva Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para no cambiar">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="<?php echo e(old('telefono', $estudiante->telefono)); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" value="<?php echo e(old('fecha_nacimiento', $estudiante->fecha_nacimiento?->format('Y-m-d'))); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Género <span class="text-danger">*</span></label>
                            <select name="genero" class="form-select" required>
                                <option value="masculino" <?php echo e(old('genero', $estudiante->genero) === 'masculino' ? 'selected' : ''); ?>>Masculino</option>
                                <option value="femenino"  <?php echo e(old('genero', $estudiante->genero) === 'femenino'  ? 'selected' : ''); ?>>Femenino</option>
                                <option value="otro"      <?php echo e(old('genero', $estudiante->genero) === 'otro'      ? 'selected' : ''); ?>>Otro</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Curso</label>
                            <select name="curso_id" class="form-select">
                                <option value="">Sin asignar</option>
                                <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c->id); ?>" <?php echo e(old('curso_id', $estudiante->curso_id) == $c->id ? 'selected' : ''); ?>><?php echo e($c->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                            <select name="estado" class="form-select" required>
                                <option value="activo"   <?php echo e(old('estado', $estudiante->estado) === 'activo'   ? 'selected' : ''); ?>>Activo</option>
                                <option value="inactivo" <?php echo e(old('estado', $estudiante->estado) === 'inactivo' ? 'selected' : ''); ?>>Inactivo</option>
                                <option value="retirado" <?php echo e(old('estado', $estudiante->estado) === 'retirado' ? 'selected' : ''); ?>>Retirado</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Dirección</label>
                            <input type="text" name="direccion" class="form-control" value="<?php echo e(old('direccion', $estudiante->direccion)); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h6 class="fw-bold mb-0">Foto del Estudiante</h6></div>
                <div class="card-body text-center">
                    <img id="foto-preview"
                        src="<?php echo e($estudiante->foto ? asset('storage/'.$estudiante->foto) : asset('assets/img/default-avatar.svg')); ?>"
                        class="avatar-xl rounded-circle mb-3 border" style="object-fit:cover">
                    <div>
                        <input type="file" name="foto" id="foto" class="form-control form-control-sm" accept="image/jpg,image/jpeg,image/png">
                        <small class="text-muted">JPG, PNG. Máx 2MB</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex gap-2 justify-content-end">
        <a href="<?php echo e(route('admin.estudiantes.index')); ?>" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Actualizar Estudiante
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/estudiantes/edit.blade.php ENDPATH**/ ?>