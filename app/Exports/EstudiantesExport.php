<?php

namespace App\Exports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EstudiantesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Estudiante::with(['user', 'curso'])->get();
    }

    public function headings(): array
    {
        return ['ID','Nombre','Email','Documento','Teléfono','Género','Curso','Estado','Fecha Registro'];
    }

    public function map($e): array
    {
        return [
            $e->id,
            $e->user->name,
            $e->user->email,
            $e->documento,
            $e->telefono,
            ucfirst($e->genero),
            $e->curso->nombre ?? 'Sin asignar',
            ucfirst($e->estado),
            $e->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1a4a8a']], 'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true]],
        ];
    }
}
