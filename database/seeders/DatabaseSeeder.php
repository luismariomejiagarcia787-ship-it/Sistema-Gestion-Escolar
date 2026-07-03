<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CursoSeeder::class,
            ProfesorSeeder::class,
            EstudianteSeeder::class,
            MateriaSeeder::class,
            MatriculaSeeder::class,
            CalificacionSeeder::class,
            AsistenciaSeeder::class,
        ]);
    }
}
