@extends('layouts.app')
@section('title','Editar Asistencia')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('profesor.asistencia.index') }}">Asistencia</a></li><li class="breadcrumb-item active">Editar</li>@endsection
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Asistencia</h4>
    <a href="{{ route('profesor.asistencia.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
</div>
<div class="card" style="max-width:500px"><div class="card-body">
    <div class="mb-3 p-3 rounded bg-light">
        <strong>Estudiante:</strong> {{ $asistencia->estudiante->user->name }}<br>
        <strong>Curso:</strong> {{ $asistencia->curso->nombre }}
    </div>
    <form action="{{ route('profesor.asistencia.update', $asistencia) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label fw-semibold">Fecha *</label><input type="date" name="fecha" class="form-control" value="{{ old('fecha',$asistencia->fecha->format('Y-m-d')) }}" required></div>
        <div class="mb-4"><label class="form-label fw-semibold">Estado *</label>
            <div class="d-flex gap-3 flex-wrap">
                @foreach(['presente','ausente','excusado','tardanza'] as $s)
                <div class="form-check"><input class="form-check-input" type="radio" name="estado" value="{{ $s }}" id="s_{{ $s }}" {{ old('estado',$asistencia->estado)===$s?'checked':'' }} required><label class="form-check-label text-capitalize" for="s_{{ $s }}">{{ ucfirst($s) }}</label></div>
                @endforeach
            </div>
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('profesor.asistencia.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Actualizar</button>
        </div>
    </form>
</div></div>
@endsection
