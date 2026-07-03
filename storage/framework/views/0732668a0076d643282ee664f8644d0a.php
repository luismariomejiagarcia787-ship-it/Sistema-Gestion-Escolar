<?php $__env->startSection('title', 'Profesores'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Profesores</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-person-badge-fill text-primary me-2"></i>Profesores</h4>
        <p class="text-muted small mb-0">Gestión del cuerpo docente</p>
    </div>
    <a href="<?php echo e(route('admin.profesores.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nuevo Profesor
    </a>
</div>
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, documento..." value="<?php echo e(request('search')); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select name="estado" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    <option value="activo"   <?php echo e(request('estado') === 'activo'   ? 'selected' : ''); ?>>Activo</option>
                    <option value="inactivo" <?php echo e(request('estado') === 'inactivo' ? 'selected' : ''); ?>>Inactivo</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm flex-fill">Filtrar</button>
                <a href="<?php echo e(route('admin.profesores.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead><tr><th>#</th><th>Profesor</th><th>Documento</th><th>Especialidad</th><th>Teléfono</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $profesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($p->id); ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <?php if($p->foto): ?>
                                    <img src="<?php echo e(asset('storage/'.$p->foto)); ?>" class="avatar" alt="">
                                <?php else: ?>
                                    <div class="avatar d-flex align-items-center justify-content-center bg-success-soft fw-bold" style="color:#166534;font-size:.75rem">
                                        <?php echo e(strtoupper(substr($p->user->name,0,2))); ?>

                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="fw-semibold small"><?php echo e($p->user->name); ?></div>
                                    <div class="text-muted" style="font-size:.75rem"><?php echo e($p->user->email); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="small"><?php echo e($p->documento); ?></td>
                        <td class="small"><?php echo e($p->especialidad ?? '—'); ?></td>
                        <td class="small text-muted"><?php echo e($p->telefono ?? '—'); ?></td>
                        <td>
                            <span class="badge <?php echo e($p->estado === 'activo' ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e(ucfirst($p->estado)); ?></span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('admin.profesores.show', $p)); ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                <a href="<?php echo e(route('admin.profesores.edit', $p)); ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form action="<?php echo e(route('admin.profesores.destroy', $p)); ?>" method="POST" class="delete-form">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" class="text-center py-5 text-muted"><i class="bi bi-person-badge fs-1 d-block mb-2"></i>No se encontraron profesores</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($profesores->hasPages()): ?>
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted"><?php echo e($profesores->total()); ?> registros</small>
        <?php echo e($profesores->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/profesores/index.blade.php ENDPATH**/ ?>