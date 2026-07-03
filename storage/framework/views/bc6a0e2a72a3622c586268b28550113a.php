<?php $__env->startSection('title', 'Perfil Estudiante'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.estudiantes.index')); ?>">Estudiantes</a></li>
    <li class="breadcrumb-item active"><?php echo e($estudiante->user->name); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-3">
    
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <?php if($estudiante->foto): ?>
                    <img src="<?php echo e(asset('storage/'.$estudiante->foto)); ?>" class="avatar-xl rounded-circle border mb-3" style="object-fit:cover">
                <?php else: ?>
                    <div class="avatar-xl rounded-circle d-flex align-items-center justify-content-center bg-primary-soft mx-auto mb-3"
                        style="color:#1e40af;font-size:2.5rem;font-weight:700">
                        <?php echo e(strtoupper(substr($estudiante->user->name, 0, 2))); ?>

                    </div>
                <?php endif; ?>
                <h5 class="fw-bold mb-0"><?php echo e($estudiante->user->name); ?></h5>
                <p class="text-muted small mb-2"><?php echo e($estudiante->user->email); ?></p>
                <span class="badge <?php echo e($estudiante->estado === 'activo' ? 'bg-success' : 'bg-secondary'); ?> mb-3">
                    <?php echo e(ucfirst($estudiante->estado)); ?>

                </span>
                <div class="text-start">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted small">Documento</span>
                        <span class="small fw-semibold"><?php echo e($estudiante->documento); ?></span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted small">Teléfono</span>
                        <span class="small fw-semibold"><?php echo e($estudiante->telefono ?? '—'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted small">Género</span>
                        <span class="small fw-semibold"><?php echo e(ucfirst($estudiante->genero)); ?></span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted small">Nacimiento</span>
                        <span class="small fw-semibold"><?php echo e($estudiante->fecha_nacimiento?->format('d/m/Y') ?? '—'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted small">Curso</span>
                        <span class="small fw-semibold"><?php echo e($estudiante->curso->nombre ?? '—'); ?></span>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <a href="<?php echo e(route('admin.estudiantes.edit', $estudiante)); ?>" class="btn btn-warning btn-sm flex-fill">
                        <i class="bi bi-pencil me-1"></i> Editar
                    </a>
                </div>
            </div>
        </div>

        
        <div class="card mt-3">
            <div class="card-body text-center">
                <div class="fs-1 fw-bold <?php echo e($estudiante->promedio >= 4 ? 'nota-alta' : ($estudiante->promedio >= 3 ? 'nota-media' : 'nota-baja')); ?>">
                    <?php echo e($estudiante->promedio); ?>

                </div>
                <div class="text-muted small">Promedio General</div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        
        <div class="card mb-3">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-clipboard2-data me-2 text-primary"></i>Calificaciones</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Materia</th><th>Período</th><th>Nota</th><th>Observación</th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $estudiante->calificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="small fw-semibold"><?php echo e($cal->materia->nombre); ?></td>
                                <td class="small">Período <?php echo e($cal->periodo); ?></td>
                                <td><span class="<?php echo e($cal->nota_color); ?> fs-6"><?php echo e($cal->nota); ?></span></td>
                                <td class="small text-muted"><?php echo e($cal->observacion ?? '—'); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">Sin calificaciones</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <div class="card">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Asistencia Reciente</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead><tr><th>Fecha</th><th>Curso</th><th>Estado</th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $estudiante->asistencias->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="small"><?php echo e($ast->fecha->format('d/m/Y')); ?></td>
                                <td class="small"><?php echo e($ast->curso->nombre ?? '—'); ?></td>
                                <td><?php echo $ast->estado_badge; ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">Sin registros</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/admin/estudiantes/show.blade.php ENDPATH**/ ?>