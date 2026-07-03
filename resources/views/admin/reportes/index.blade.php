@extends('layouts.app')
@section('title','Reportes')
@section('breadcrumb')<li class="breadcrumb-item active">Reportes</li>@endsection
@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Centro de Reportes</h4>
    <p class="text-muted small">Genera y exporta reportes del sistema</p>
</div>
<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-people text-primary me-2"></i>Reporte General</h6></div>
            <div class="card-body">
                <p class="text-muted small mb-3">Exporta listados completos de estudiantes, profesores, cursos y materias.</p>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ route('admin.reportes.general', ['tipo'=>'estudiantes']) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-people me-1"></i>Estudiantes</a>
                    <a href="{{ route('admin.reportes.general', ['tipo'=>'profesores']) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-person-badge me-1"></i>Profesores</a>
                    <a href="{{ route('admin.reportes.general', ['tipo'=>'cursos']) }}" class="btn btn-outline-warning btn-sm"><i class="bi bi-book me-1"></i>Cursos</a>
                    <a href="{{ route('admin.reportes.general', ['tipo'=>'materias']) }}" class="btn btn-outline-info btn-sm"><i class="bi bi-journal me-1"></i>Materias</a>
                </div>
                <hr>
                <p class="text-muted small mb-2">Exportar:</p>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.reportes.pdf.estudiantes') }}" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>PDF Estudiantes</a>
                    <a href="{{ route('admin.reportes.excel.estudiantes') }}" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel me-1"></i>Excel Estudiantes</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h6 class="fw-bold mb-0"><i class="bi bi-clipboard2-data text-primary me-2"></i>Reporte Académico</h6></div>
            <div class="card-body">
                <p class="text-muted small mb-3">Consulta notas, promedios y asistencia por curso y período.</p>
                <a href="{{ route('admin.reportes.academico') }}" class="btn btn-outline-primary btn-sm mb-3"><i class="bi bi-graph-up me-1"></i>Ver Reporte Académico</a>
                <hr>
                <p class="text-muted small mb-2">Exportar:</p>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.reportes.pdf.calificaciones') }}" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>PDF Calificaciones</a>
                    <a href="{{ route('admin.reportes.excel.calificaciones') }}" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel me-1"></i>Excel Calificaciones</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
