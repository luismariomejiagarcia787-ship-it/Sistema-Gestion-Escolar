<?php $__env->startSection('title','Reporte Académico'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item"><a href="<?php echo e(route('profesor.reportes.index')); ?>">Reportes</a></li><li class="breadcrumb-item active">Académico</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-graph-up text-primary me-2"></i>Reporte Académico</h4>
    <a href="<?php echo e(route('profesor.reportes.pdf.calificaciones', request()->query())); ?>" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a>
</div>
<div class="card mb-4"><div class="card-body">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3"><label class="form-label fw-semibold small">Curso *</label>
            <select name="curso_id" class="form-select" required>
                <option value="">Seleccionar...</option>
                <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php echo e(request('curso_id')==$c->id?'selected':''); ?>><?php echo e($c->nombre); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-3"><label class="form-label fw-semibold small">Materia</label>
            <select name="materia_id" class="form-select">
                <option value="">Todas</option>
                <?php $__currentLoopData = $materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($m->id); ?>" <?php echo e(request('materia_id')==$m->id?'selected':''); ?>><?php echo e($m->nombre); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2"><label class="form-label fw-semibold small">Período</label>
            <select name="periodo" class="form-select">
                <option value="">Todos</option>
                <?php $__currentLoopData = ['1','2','3','4']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p); ?>" <?php echo e(request('periodo')===$p?'selected':''); ?>>Período <?php echo e($p); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100 mt-auto"><i class="bi bi-search me-1"></i>Consultar</button></div>
    </form>
</div></div>

<?php if($cursos->isEmpty()): ?>
<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>Aún no tiene cursos asignados.</div>
<?php elseif($calificaciones->count()): ?>
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card text-center"><div class="card-body"><div class="fs-2 fw-bold text-primary"><?php echo e($calificaciones->count()); ?></div><div class="text-muted small">Total Notas</div></div></div></div>
    <div class="col-md-4"><div class="card text-center"><div class="card-body"><div class="fs-2 fw-bold nota-alta"><?php echo e(round($calificaciones->avg('nota'),2)); ?></div><div class="text-muted small">Promedio General</div></div></div></div>
    <div class="col-md-4"><div class="card text-center"><div class="card-body"><div class="fs-2 fw-bold text-info"><?php echo e($promedios->count()); ?></div><div class="text-muted small">Estudiantes</div></div></div></div>
</div>
<div class="card"><div class="card-header"><h6 class="fw-bold mb-0">Promedios por Estudiante</h6></div>
<div class="card-body p-0"><div class="table-responsive">
    <table class="table table-custom mb-0">
        <thead><tr><th>Estudiante</th><th>Promedio</th><th># Notas</th><th>Calificación</th></tr></thead>
        <tbody>
            <?php $__currentLoopData = $promedios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="fw-semibold small"><?php echo e($item['nombre']); ?></td>
                <td><span class="<?php echo e($item['promedio']>=4?'nota-alta':($item['promedio']>=3?'nota-media':'nota-baja')); ?> fw-bold fs-6"><?php echo e($item['promedio']); ?></span></td>
                <td class="small text-muted"><?php echo e($item['count']); ?></td>
                <td>
                    <div class="progress" style="height:8px">
                        <div class="progress-bar <?php echo e($item['promedio']>=4?'bg-success':($item['promedio']>=3?'bg-warning':'bg-danger')); ?>" style="width:<?php echo e($item['promedio']*20); ?>%"></div>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div></div></div>
<?php elseif(request()->filled('curso_id')): ?>
<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>No se encontraron calificaciones para los filtros seleccionados.</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/profesor/reportes/academico.blade.php ENDPATH**/ ?>