<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 – Sin permiso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height:100vh">
<div class="text-center">
    <div style="font-size:6rem;color:#1a4a8a"><i class="bi bi-shield-lock-fill"></i></div>
    <h1 class="display-1 fw-bold text-danger">403</h1>
    <h4 class="text-muted mb-4">Acceso denegado</h4>
    <p class="text-muted mb-4">No tienes permiso para acceder a esta sección.</p>
    <a href="javascript:history.back()" class="btn btn-primary me-2"><i class="bi bi-arrow-left me-1"></i>Volver</a>
    <a href="{{ route('login') }}" class="btn btn-outline-secondary">Inicio de sesión</a>
</div>
</body>
</html>
