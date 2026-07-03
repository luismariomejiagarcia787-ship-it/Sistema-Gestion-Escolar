@extends('layouts.app')
@section('title','Editar Matrícula')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.matriculas.index') }}">Matrículas</a></li><li class="breadcrumb-item active">Editar</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Matrícula</h4>
    <a href="{{ route('admin.matriculas.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:650px"><div class="card-body">
<form action="{{ route('admin.matriculas.update', $matricula) }}" method="POST">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-12"><label class="form-label fw-semibold">Estudiante *</label>
            <select name="estudiante_id" class="form-select" required>
                @foreach($estudiantes as $e)<option value="{{ $e->id }}" {{ old('estudiante_id',$matricula->estudiante_id)==$e->id?'selected':'' }}>{{ $e->user->name }} — {{ $e->documento }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Curso *</label>
            <select name="curso_id" class="form-select" required>
                @foreach($cursos as $c)<option value="{{ $c->id }}" {{ old('curso_id',$matricula->curso_id)==$c->id?'selected':'' }}>{{ $c->nombre }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Año Lectivo *</label><input type="number" name="anio_lectivo" class="form-control" value="{{ old('anio_lectivo',$matricula->anio_lectivo) }}" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Fecha Matrícula *</label><input type="date" name="fecha_matricula" class="form-control" value="{{ old('fecha_matricula',$matricula->fecha_matricula->format('Y-m-d')) }}" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Estado *</label>
            <select name="estado" class="form-select" required>
                <option value="activa"     {{ old('estado',$matricula->estado)==='activa'    ?'selected':'' }}>Activa</option>
                <option value="retirada"   {{ old('estado',$matricula->estado)==='retirada'  ?'selected':'' }}>Retirada</option>
                <option value="finalizada" {{ old('estado',$matricula->estado)==='finalizada'?'selected':'' }}>Finalizada</option>
            </select>
        </div>
        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.matriculas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Actualizar</button>
        </div>
    </div>
</form>
</div></div>
@endsection
