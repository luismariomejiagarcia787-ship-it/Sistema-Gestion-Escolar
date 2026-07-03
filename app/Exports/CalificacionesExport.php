<?php

namespace App\Exports;

use App\Models\Calificacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CalificacionesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Calificacion::with(['estudiante.user','materia','profesor.user'])->get();
    }

    public function headings(): array
    {
        return ['ID','Estudiante','Materia','Profesor','Nota','Periodo','Observación','Fecha'];
    }

    public function map($c): array
    {
        return [
            $c->id,
            $c->estudiante->user->name,
            $c->materia->nombre,
            $c->profesor->user->name ?? 'N/A',
            $c->nota,
            'Periodo '.$c->periodo,
            $c->observacion ?? '',
            $c->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1a4a8a']]],
        ];
    }
}
