@extends('layouts.auth')
@section('title', 'Iniciar Sesión')

@section('content')
<div class="auth-card">
    <div class="auth-logo"><i class="bi bi-mortarboard-fill"></i></div>
    <h4 class="text-center fw-bold mb-1" style="color: var(--primary)">Sistema Gestión Escolar</h4>
    <p class="text-center text-muted mb-4" style="font-size:.85rem">Ingrese sus credenciales para continuar</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            {{ $errors->first() }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Correo Electrónico</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="correo@ejemplo.com" required autofocus>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
        </div>
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Recordarme</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
        </button>
    </form>

    <hr class="my-3">
    <p class="text-center text-muted small mb-0">
        ¿No tiene cuenta?
        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Registrarse</a>
    </p>

    <div class="mt-3 p-2 rounded" style="background:#f8f9fa; font-size:.75rem">
        <strong>Demo:</strong><br>
        Admin: admin@colegio.com / 12345678<br>
        Profesor: profesor@colegio.com / 12345678<br>
        Estudiante: estudiante@colegio.com / 12345678
    </div>
</div>
@endsection
