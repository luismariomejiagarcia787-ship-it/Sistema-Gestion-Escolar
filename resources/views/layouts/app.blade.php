<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema Gestión Escolar')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

<div class="d-flex">
    <!-- SIDEBAR -->
    <nav class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <h5>Sistema Gestión<br>Escolar</h5>
        </div>

        <div class="mt-2">
            @if(auth()->user()->role === 'admin')
                <div class="sidebar-heading">Principal</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <div class="sidebar-heading">Gestión</div>
                <a href="{{ route('admin.estudiantes.index') }}" class="nav-link {{ request()->routeIs('admin.estudiantes.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Estudiantes
                </a>
                <a href="{{ route('admin.profesores.index') }}" class="nav-link {{ request()->routeIs('admin.profesores.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill"></i> Profesores
                </a>
                <a href="{{ route('admin.cursos.index') }}" class="nav-link {{ request()->routeIs('admin.cursos.*') ? 'active' : '' }}">
                    <i class="bi bi-book-half"></i> Cursos
                </a>
                <a href="{{ route('admin.materias.index') }}" class="nav-link {{ request()->routeIs('admin.materias.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i> Materias
                </a>
                <a href="{{ route('admin.matriculas.index') }}" class="nav-link {{ request()->routeIs('admin.matriculas.*') ? 'active' : '' }}">
                    <i class="bi bi-card-checklist"></i> Matrículas
                </a>

                <div class="sidebar-heading">Académico</div>
                <a href="{{ route('admin.calificaciones.index') }}" class="nav-link {{ request()->routeIs('admin.calificaciones.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-data-fill"></i> Calificaciones
                </a>
                <a href="{{ route('admin.asistencia.index') }}" class="nav-link {{ request()->routeIs('admin.asistencia.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check-fill"></i> Asistencia
                </a>
                <a href="{{ route('admin.reportes.index') }}" class="nav-link {{ request()->routeIs('admin.reportes.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill"></i> Reportes
                </a>

                <div class="sidebar-heading">Sistema</div>
                <a href="{{ route('admin.usuarios.index') }}" class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock-fill"></i> Usuarios
                </a>

            @elseif(auth()->user()->role === 'profesor')
                <div class="sidebar-heading">Principal</div>
                <a href="{{ route('profesor.dashboard') }}" class="nav-link {{ request()->routeIs('profesor.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <div class="sidebar-heading">Académico</div>
                <a href="{{ route('profesor.calificaciones.index') }}" class="nav-link {{ request()->routeIs('profesor.calificaciones.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-data-fill"></i> Calificaciones
                </a>
                <a href="{{ route('profesor.asistencia.index') }}" class="nav-link {{ request()->routeIs('profesor.asistencia.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check-fill"></i> Asistencia
                </a>
                <a href="{{ route('profesor.reportes.index') }}" class="nav-link {{ request()->routeIs('profesor.reportes.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill"></i> Reportes
                </a>

            @elseif(auth()->user()->role === 'estudiante')
                <div class="sidebar-heading">Mi Portal</div>
                <a href="{{ route('estudiante.dashboard') }}" class="nav-link {{ request()->routeIs('estudiante.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door-fill"></i> Mi Dashboard
                </a>
            @endif
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="main-content w-100">
        <!-- TOP NAVBAR -->
        <nav class="top-navbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-light d-md-none" id="sidebarToggle">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-custom mb-0">
                        <li class="breadcrumb-item"><a href="#"><i class="bi bi-house"></i></a></li>
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary-soft text-primary">
                    <i class="bi bi-person-circle me-1"></i>
                    {{ auth()->user()->name }}
                </span>
                <span class="badge bg-secondary">{{ ucfirst(auth()->user()->role) }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Cerrar sesión">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </nav>

        <!-- PAGE CONTENT -->
        <div class="page-content">
            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Errores:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>

        <!-- FOOTER -->
        <footer class="footer text-center">
            © {{ date('Y') }} Sistema de Gestión Escolar &nbsp;|&nbsp; Todos los derechos estan reservados L M M G.
        </footer>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<!-- Custom JS -->
<script src="{{ asset('assets/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
