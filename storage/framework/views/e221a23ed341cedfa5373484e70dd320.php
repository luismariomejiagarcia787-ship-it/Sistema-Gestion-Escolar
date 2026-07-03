<?php $__env->startSection('title', 'Estudiantes'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Estudiantes</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-people-fill text-primary me-2"></i>Estudiantes</h4>
        <p class="text-muted small mb-0">Gestión de estudiantes registrados</p>
    </div>
    <a href="<?php echo e(route('admin.estudiantes.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nuevo Estudiante
    </a>
</div>


<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, email, documento..." value="<?php echo e(request('search')); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select name="curso" class="form-select form-select-sm">
                    <option value="">Todos los cursos</option>
                    <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($c->id); ?>" <?php echo e(request('curso') == $c->id ? 'selected' : ''); ?>><?php echo e($c->nombre); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="estado" class="form-select form-select-sm">
                    <option value="">Todos los estados</option>
                    <option value="activo"   <?php echo e(request('estado') === 'activo'   ? 'selected' : ''); ?>>Activo</option>
                    <option value="inactivo" <?php echo e(request('estado') === 'inactivo' ? 'selected' : ''); ?>>Inactivo</option>
                    <option value="retirado" <?php echo e(request('estado') === 'retirado' ? 'selected' : ''); ?>>Retirado</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button>
                <a href="<?php echo e(route('admin.estudiantes.index')); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th>#</th><th>Estudiante</th><th>Documento</th><th>Teléfono</th>
                        <th>Curso</th><th>Estado</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $estudiantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($est->id); ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <?php if($est->foto): ?>
                                    <img src="<?php echo e(asset('storage/'.$est->foto)); ?>" class="avatar" alt="">
                                <?php else: ?>
                                    <div class="avatar d-flex align-items-center justify-content-center bg-primary-soft fw-bold"
                                        style="color:#1e40af;font-size:.75rem">
                                        <?php echo e(strtoupper(substr($est->user->name, 0, 2))); ?>

                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="fw-semibold small"><?php echo e($est->user->name); ?></div>
                                    <div class="text-muted" style="font-size:.75rem"><?php echo e($est->user->email); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="small"><?php echo e($est->documento); ?></td>
                        <td class="small text-muted"><?php echo e($est->telefono ?? '—'); ?></td>
                        <td class="small"><?php echo e($est->curso->nombre ?? '—'); ?></td>
                        <td>
                            <?php if($est->estado === 'activo'): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php elseif($est->estado === 'inactivo'): ?>
                                <span class="badge bg-secondary">Inactivo</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Retirado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('admin.estudiantes.show', $est)); ?>" class="btn btn-sm btn-outline-info" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.estudiantes.edit', $est)); ?>" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('admin.estudiantes.destroy', $est)); ?>" method="POST" class="delete-form">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2"></i>
                            No se encontraron estudiantes
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($estudiantes->hasPages()): ?>
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">Mostrando <?php echo e($estudiantes->firstItem()); ?>-<?php echo e($estudiantes->lastItem()); ?> de <?php echo e($estudiantes->total()); ?></small>
        <?php echo e($estudiantes->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/estudiantes/index.blade.php ENDPATH**/ ?>