<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Materia;
use App\Models\Profesor;
use Illuminate\Database\Seeder;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        $profesores = Profesor::all();

        $materias = [
            ['nombre' => 'Matemáticas',         'codigo' => 'MAT', 'intensidad_horaria' => 5],
            ['nombre' => 'Español y Literatura', 'codigo' => 'ESP', 'intensidad_horaria' => 4],
            ['nombre' => 'Ciencias Naturales',   'codigo' => 'CN',  'intensidad_horaria' => 3],
            ['nombre' => 'Historia y Geografía', 'codigo' => 'HIS', 'intensidad_horaria' => 3],
            ['nombre' => 'Educación Física',     'codigo' => 'EDF', 'intensidad_horaria' => 2],
            ['nombre' => 'Inglés',               'codigo' => 'ING', 'intensidad_horaria' => 4],
            ['nombre' => 'Informática',          'codigo' => 'INF', 'intensidad_horaria' => 2],
            ['nombre' => 'Arte y Cultura',       'codigo' => 'ART', 'intensidad_horaria' => 2],
            ['nombre' => 'Física',               'codigo' => 'FIS', 'intensidad_horaria' => 3],
            ['nombre' => 'Química',              'codigo' => 'QUI', 'intensidad_horaria' => 3],
        ];

        $createdMaterias = [];
        foreach ($materias as $i => $m) {
            $profesor_id = $profesores->count() > 0 ? $profesores[$i % $profesores->count()]->id : null;
            $mat = Materia::firstOrCreate(['codigo' => $m['codigo']], array_merge($m, ['profesor_id' => $profesor_id]));
            $createdMaterias[] = $mat->id;
        }

        // Assign all materias to all cursos
        $cursos = Curso::all();
        foreach ($cursos as $curso) {
            $curso->materias()->sync($createdMaterias);
        }
    }
}
