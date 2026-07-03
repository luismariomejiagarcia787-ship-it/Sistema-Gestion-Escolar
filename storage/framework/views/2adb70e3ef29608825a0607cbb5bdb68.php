<?php $__env->startSection('title','Reportes'); ?>
<?php $__env->startSection('breadcrumb'); ?><li class="breadcrumb-item active">Reportes</li><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Mis Reportes</h4>
    <p class="text-muted small">Consulta y exporta reportes de tus cursos y materias</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card text-center"><div class="card-body">
            <div class="fs-2 fw-bold text-primary"><?php echo e($cursos->count()); ?></div>
            <div class="text-muted small">Cursos a cargo</div>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card text-center"><div class="card-body">
            <div class="fs-2 fw-bold text-info"><?php echo e($materias->count()); ?></div>
            <div class="text-muted small">Materias a cargo</div>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card text-center"><div class="card-body">
            <div class="fs-2 fw-bold nota-alta"><?php echo e($cursos->sum('estudiantes_count')); ?></div>
            <div class="text-muted small">Estudiantes en mis cursos</div>
        </div></div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-clipboard2-data text-primary me-2"></i>Reporte Académico</h6></div>
            <div class="card-body">
                <p class="text-muted small mb-3">Consulta notas y promedios de tus cursos por materia y período.</p>
                <a href="<?php echo e(route('profesor.reportes.academico')); ?>" class="btn btn-outline-primary btn-sm mb-3"><i class="bi bi-graph-up me-1"></i>Ver Reporte Académico</a>
                <hr>
                <p class="text-muted small mb-2">Exportar:</p>
                <a href="<?php echo e(route('profesor.reportes.pdf.calificaciones')); ?>" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>PDF Mis Calificaciones</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-calendar-check text-primary me-2"></i>Reporte de Asistencia</h6></div>
            <div class="card-body">
                <p class="text-muted small mb-3">Consulta el histórico de asistencia de tus cursos por rango de fechas.</p>
                <a href="<?php echo e(route('profesor.reportes.asistencia')); ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-bar-chart me-1"></i>Ver Reporte de Asistencia</a>
            </div>
        </div>
    </div>
</div>

<?php if($cursos->isEmpty()): ?>
<div class="alert alert-info mt-4"><i class="bi bi-info-circle me-2"></i>Aún no tiene cursos asignados. Contacte al administrador para que le asigne uno.</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/profesor/reportes/index.blade.php ENDPATH**/ ?>