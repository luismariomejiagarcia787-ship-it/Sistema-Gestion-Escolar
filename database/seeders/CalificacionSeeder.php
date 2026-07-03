<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use App\Models\Estudiante;
use App\Models\Materia;
use App\Models\Profesor;
use Illuminate\Database\Seeder;

class CalificacionSeeder extends Seeder
{
    public function run(): void
    {
        $estudiantes = Estudiante::all();
        $materias    = Materia::all();
        $profesores  = Profesor::all();

        if ($estudiantes->isEmpty() || $materias->isEmpty()) return;

        $count = 0;
        foreach ($estudiantes->take(10) as $est) {
            foreach ($materias->take(5) as $mat) {
                for ($periodo = 1; $periodo <= 2; $periodo++) {
                    $prof_id = $mat->profesor_id ?? ($profesores->count() > 0 ? $profesores->random()->id : null);

                    Calificacion::firstOrCreate(
                        ['estudiante_id' => $est->id, 'materia_id' => $mat->id, 'periodo' => $periodo],
                        [
                            'profesor_id' => $prof_id,
                            'nota'        => round(rand(25, 50) / 10, 1),
                            'observacion' => null,
                        ]
                    );
                    $count++;
                    if ($count >= 100) return;
                }
            }
        }
    }
}
