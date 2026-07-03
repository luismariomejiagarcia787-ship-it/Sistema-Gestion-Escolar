<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            ['nombre' => 'Sexto A',   'codigo' => '6A', 'jornada' => 'manana',   'anio_lectivo' => 2024],
            ['nombre' => 'Séptimo B', 'codigo' => '7B', 'jornada' => 'manana',   'anio_lectivo' => 2024],
            ['nombre' => 'Octavo A',  'codigo' => '8A', 'jornada' => 'tarde',    'anio_lectivo' => 2024],
            ['nombre' => 'Noveno B',  'codigo' => '9B', 'jornada' => 'tarde',    'anio_lectivo' => 2024],
            ['nombre' => 'Décimo A',  'codigo' => '10A','jornada' => 'completa', 'anio_lectivo' => 2024],
        ];

        foreach ($cursos as $curso) {
            Curso::firstOrCreate(['codigo' => $curso['codigo']], $curso);
        }
    }
}
