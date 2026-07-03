<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Matricula;
use Illuminate\Database\Seeder;

class MatriculaSeeder extends Seeder
{
    public function run(): void
    {
        $estudiantes = Estudiante::with('curso')->get();

        foreach ($estudiantes as $est) {
            if ($est->curso_id) {
                Matricula::firstOrCreate(
                    ['estudiante_id' => $est->id, 'anio_lectivo' => 2024],
                    [
                        'curso_id'       => $est->curso_id,
                        'fecha_matricula'=> '2024-02-01',
                        'estado'         => 'activa',
                    ]
                );
            }
        }
    }
}
