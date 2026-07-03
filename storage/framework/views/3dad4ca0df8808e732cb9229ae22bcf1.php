<?php $__env->startSection('title','Perfil Profesor'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.profesores.index')); ?>">Profesores</a></li>
    <li class="breadcrumb-item active"><?php echo e($profesor->user->name); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <?php if($profesor->foto): ?>
                    <img src="<?php echo e(asset('storage/'.$profesor->foto)); ?>" class="avatar-xl rounded-circle border mb-3" style="object-fit:cover">
                <?php else: ?>
                    <div class="avatar-xl rounded-circle d-flex align-items-center justify-content-center bg-success-soft mx-auto mb-3" style="color:#166534;font-size:2.5rem;font-weight:700"><?php echo e(strtoupper(substr($profesor->user->name,0,2))); ?></div>
                <?php endif; ?>
                <h5 class="fw-bold mb-0"><?php echo e($profesor->user->name); ?></h5>
                <p class="text-muted small"><?php echo e($profesor->especialidad ?? 'Docente'); ?></p>
                <span class="badge <?php echo e($profesor->estado === 'activo' ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e(ucfirst($profesor->estado)); ?></span>
                <div class="text-start mt-3">
                    <div class="d-flex justify-content-between border-bottom py-2"><span class="text-muted small">Email</span><span class="small fw-semibold"><?php echo e($profesor->user->email); ?></span></div>
                    <div class="d-flex justify-content-between border-bottom py-2"><span class="text-muted small">Documento</span><span class="small fw-semibold"><?php echo e($profesor->documento); ?></span></div>
                    <div class="d-flex justify-content-between border-bottom py-2"><span class="text-muted small">Teléfono</span><span class="small fw-semibold"><?php echo e($profesor->telefono ?? '—'); ?></span></div>
                    <div class="d-flex justify-content-between py-2"><span class="text-muted small">Ingreso</span><span class="small fw-semibold"><?php echo e($profesor->fecha_ingreso?->format('d/m/Y') ?? '—'); ?></span></div>
                </div>
                <a href="<?php echo e(route('admin.profesores.edit', $profesor)); ?>" class="btn btn-warning btn-sm w-100 mt-3"><i class="bi bi-pencil me-1"></i>Editar</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-book text-primary me-2"></i>Cursos Asignados (<?php echo e($profesor->cursos->count()); ?>)</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Curso</th><th>Código</th><th>Jornada</th><th>Año</th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $profesor->cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="fw-semibold small"><?php echo e($c->nombre); ?></td>
                                <td class="small"><?php echo e($c->codigo); ?></td>
                                <td class="small"><?php echo e($c->jornada_label); ?></td>
                                <td class="small"><?php echo e($c->anio_lectivo); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">Sin cursos asignados</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-journal text-primary me-2"></i>Materias a Cargo (<?php echo e($profesor->materias->count()); ?>)</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Materia</th><th>Código</th><th>Horas</th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $profesor->materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="fw-semibold small"><?php echo e($m->nombre); ?></td>
                                <td class="small"><?php echo e($m->codigo); ?></td>
                                <td class="small"><?php echo e($m->intensidad_horaria); ?> h/sem</td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">Sin materias asignadas</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/profesores/show.blade.php ENDPATH**/ ?>