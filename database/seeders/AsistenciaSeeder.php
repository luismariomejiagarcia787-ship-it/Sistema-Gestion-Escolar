<?php

namespace Database\Seeders;

use App\Models\Asistencia;
use App\Models\Estudiante;
use Illuminate\Database\Seeder;

class AsistenciaSeeder extends Seeder
{
    public function run(): void
    {
        $estudiantes = Estudiante::whereNotNull('curso_id')->take(10)->get();
        $estados     = ['presente', 'presente', 'presente', 'ausente', 'excusado', 'tardanza'];
        $count       = 0;

        $fechas = [];
        for ($d = 10; $d >= 1; $d--) {
            $fechas[] = now()->subDays($d)->format('Y-m-d');
        }

        foreach ($estudiantes as $est) {
            foreach ($fechas as $fecha) {
                Asistencia::firstOrCreate(
                    ['estudiante_id' => $est->id, 'curso_id' => $est->curso_id, 'fecha' => $fecha],
                    ['estado' => $estados[array_rand($estados)]]
                );
                $count++;
                if ($count >= 100) return;
            }
        }
    }
}
