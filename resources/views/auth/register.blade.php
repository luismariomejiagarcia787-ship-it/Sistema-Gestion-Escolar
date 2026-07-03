@extends('layouts.auth')
@section('title', 'Registro')

@section('content')
<div class="auth-card" style="max-width:480px">
    <div class="auth-logo"><i class="bi bi-mortarboard-fill"></i></div>
    <h4 class="text-center fw-bold mb-1" style="color: var(--primary)">Crear Cuenta</h4>
    <p class="text-center text-muted mb-4" style="font-size:.85rem">Complete el formulario de registro</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Nombre Completo</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Tu nombre completo">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Correo Electrónico</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="correo@ejemplo.com">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" required placeholder="Mínimo 8 caracteres">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Confirmar Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Repita la contraseña">
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Tipo de Usuario</label>
            <select name="role" class="form-select" required>
                <option value="">Seleccione...</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="profesor" {{ old('role') === 'profesor' ? 'selected' : '' }}>Profesor</option>
                <option value="estudiante" {{ old('role') === 'estudiante' ? 'selected' : '' }}>Estudiante</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="bi bi-person-plus me-2"></i>Crear Cuenta
        </button>
    </form>

    <hr class="my-3">
    <p class="text-center text-muted small mb-0">
        ¿Ya tiene cuenta? <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Iniciar Sesión</a>
    </p>
</div>
@endsection
