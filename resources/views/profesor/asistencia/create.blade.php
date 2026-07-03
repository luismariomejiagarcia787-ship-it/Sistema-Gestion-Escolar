@extends('layouts.app')
@section('title','Registrar Asistencia')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('profesor.asistencia.index') }}">Asistencia</a></li><li class="breadcrumb-item active">Registrar</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-calendar-plus text-primary me-2"></i>Registrar Asistencia</h4>
    <a href="{{ route('profesor.asistencia.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card"><div class="card-body">
<form action="{{ route('profesor.asistencia.store') }}" method="POST" id="asistenciaForm">
    @csrf
    <div class="row g-3 mb-4">
        <div class="col-md-4"><label class="form-label fw-semibold">Curso *</label>
            <select name="curso_id" class="form-select" id="curso_id" required>
                <option value="">Seleccionar curso...</option>
                @foreach($cursos as $c)<option value="{{ $c->id }}">{{ $c->nombre }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-4"><label class="form-label fw-semibold">Fecha *</label><input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required></div>
        <div class="col-md-4 d-flex align-items-end"><button type="button" id="cargarEstudiantes" class="btn btn-outline-primary w-100"><i class="bi bi-people me-1"></i>Cargar Estudiantes</button></div>
    </div>
    <div id="tablaAsistencia" class="d-none">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead><tr><th>Estudiante</th><th>Presente</th><th>Ausente</th><th>Excusado</th><th>Tardanza</th></tr></thead>
                <tbody id="estudiantesBody"></tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('profesor.asistencia.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Guardar Asistencia</button>
        </div>
    </div>
</form>
</div></div>
@endsection
@push('scripts')
<script>
document.getElementById('cargarEstudiantes').addEventListener('click', function(){
    const cursoId = document.getElementById('curso_id').value;
    if(!cursoId){ alert('Seleccione un curso'); return; }
    fetch('{{ route('profesor.asistencia.estudiantes') }}?curso_id=' + cursoId)
        .then(r => r.json())
        .then(data => {
            const tbody = document.getElementById('estudiantesBody');
            tbody.innerHTML = '';
            data.forEach((e, i) => {
                tbody.innerHTML += `<tr>
                    <td class="fw-semibold small">${e.nombre}</td>
                    ${['presente','ausente','excusado','tardanza'].map(s => `
                    <td><div class="form-check">
                        <input class="form-check-input" type="radio" name="asistencias[${i}][estado]" value="${s}" ${s==='presente'?'checked':''} required>
                        <input type="hidden" name="asistencias[${i}][estudiante_id]" value="${e.id}">
                    </div></td>`).join('')}
                </tr>`;
            });
            document.getElementById('tablaAsistencia').classList.remove('d-none');
        });
});
</script>
@endpush
