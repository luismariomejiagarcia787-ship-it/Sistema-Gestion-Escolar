<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1a1a1a; }
h2 { color: #1a4a8a; border-bottom: 2px solid #1a4a8a; padding-bottom: 5px; }
.meta { color: #666; font-size: 9px; margin-bottom: 15px; }
table { width: 100%; border-collapse: collapse; }
thead { background: #1a4a8a; color: #fff; }
th, td { border: 1px solid #ddd; padding: 5px 7px; text-align: left; }
tbody tr:nth-child(even) { background: #f5f8ff; }
.alta { color: #065f46; font-weight: bold; }
.media { color: #92400e; font-weight: bold; }
.baja { color: #991b1b; font-weight: bold; }
</style>
</head>
<body>
<h2>📊 Reporte de Calificaciones</h2>
<p class="meta">Generado: {{ now()->format('d/m/Y H:i') }} &nbsp;|&nbsp; Total: {{ $calificaciones->count() }} registros &nbsp;|&nbsp; Promedio: {{ round($calificaciones->avg('nota'),2) }}</p>
<table>
<thead><tr><th>#</th><th>Estudiante</th><th>Materia</th><th>Período</th><th>Nota</th><th>Profesor</th></tr></thead>
<tbody>
@foreach($calificaciones as $c)
<tr>
    <td>{{ $c->id }}</td>
    <td>{{ $c->estudiante->user->name }}</td>
    <td>{{ $c->materia->nombre }}</td>
    <td>Período {{ $c->periodo }}</td>
    <td class="{{ $c->nota>=4?'alta':($c->nota>=3?'media':'baja') }}">{{ $c->nota }}</td>
    <td>{{ $c->profesor->user->name ?? '—' }}</td>
</tr>
@endforeach
</tbody>
</table>
</body>
</html>
