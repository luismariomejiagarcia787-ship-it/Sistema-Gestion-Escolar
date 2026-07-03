@extends('layouts.app')
@section('title','Editar Curso')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.cursos.index') }}">Cursos</a></li><li class="breadcrumb-item active">Editar</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Curso</h4>
    <a href="{{ route('admin.cursos.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:700px"><div class="card-body">
<form action="{{ route('admin.cursos.update', $curso) }}" method="POST">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold">Nombre *</label><input type="text" name="nombre" class="form-control" value="{{ old('nombre', $curso->nombre) }}" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Código *</label><input type="text" name="codigo" class="form-control" value="{{ old('codigo', $curso->codigo) }}" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Jornada *</label>
            <select name="jornada" class="form-select" required>
                <option value="manana"   {{ old('jornada',$curso->jornada)==='manana'   ?'selected':'' }}>Mañana</option>
                <option value="tarde"    {{ old('jornada',$curso->jornada)==='tarde'    ?'selected':'' }}>Tarde</option>
                <option value="noche"    {{ old('jornada',$curso->jornada)==='noche'    ?'selected':'' }}>Noche</option>
                <option value="completa" {{ old('jornada',$curso->jornada)==='completa' ?'selected':'' }}>Completa</option>
            </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Año Lectivo *</label><input type="number" name="anio_lectivo" class="form-control" value="{{ old('anio_lectivo', $curso->anio_lectivo) }}" required></div>
        <div class="col-12"><label class="form-label fw-semibold">Director de Grupo</label>
            <select name="profesor_id" class="form-select">
                <option value="">Sin asignar</option>
                @foreach($profesores as $p)<option value="{{ $p->id }}" {{ old('profesor_id',$curso->profesor_id)==$p->id?'selected':'' }}>{{ $p->user->name }} - {{ $p->especialidad }}</option>@endforeach
            </select>
        </div>
        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.cursos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Actualizar</button>
        </div>
    </div>
</form>
</div></div>
@endsection
