<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1a1a1a; }
h2 { color: #1a4a8a; border-bottom: 2px solid #1a4a8a; padding-bottom: 5px; }
.meta { color: #666; font-size: 10px; margin-bottom: 15px; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
thead { background: #1a4a8a; color: #fff; }
th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
tbody tr:nth-child(even) { background: #f5f8ff; }
.badge { padding: 2px 6px; border-radius: 3px; font-size: 9px; }
.activo { background: #d1fae5; color: #065f46; }
.inactivo { background: #e5e7eb; color: #374151; }
</style>
</head>
<body>
<h2>📋 Reporte de Estudiantes</h2>
<p class="meta">Generado: {{ now()->format('d/m/Y H:i') }} &nbsp;|&nbsp; Total: {{ $estudiantes->count() }} estudiantes</p>
<table>
<thead><tr><th>#</th><th>Nombre</th><th>Documento</th><th>Email</th><th>Curso</th><th>Género</th><th>Estado</th></tr></thead>
<tbody>
@foreach($estudiantes as $e)
<tr>
    <td>{{ $e->id }}</td>
    <td>{{ $e->user->name }}</td>
    <td>{{ $e->documento }}</td>
    <td>{{ $e->user->email }}</td>
    <td>{{ $e->curso->nombre ?? '—' }}</td>
    <td>{{ ucfirst($e->genero) }}</td>
    <td><span class="badge {{ $e->estado }}">{{ ucfirst($e->estado) }}</span></td>
</tr>
@endforeach
</tbody>
</table>
</body>
</html>
