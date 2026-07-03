<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Profesor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProfesorSeeder extends Seeder
{
    public function run(): void
    {
        $profesores = [
            ['name' => 'Carlos Rodríguez',  'email' => 'profesor@colegio.com',    'doc' => '10001001', 'esp' => 'Matemáticas'],
            ['name' => 'Ana Martínez',       'email' => 'ana.martinez@colegio.com','doc' => '10001002', 'esp' => 'Español'],
            ['name' => 'Jorge Pérez',        'email' => 'jorge.perez@colegio.com', 'doc' => '10001003', 'esp' => 'Ciencias Naturales'],
            ['name' => 'Laura Gómez',        'email' => 'laura.gomez@colegio.com', 'doc' => '10001004', 'esp' => 'Historia'],
            ['name' => 'Roberto Silva',      'email' => 'r.silva@colegio.com',     'doc' => '10001005', 'esp' => 'Educación Física'],
            ['name' => 'Patricia Torres',    'email' => 'p.torres@colegio.com',    'doc' => '10001006', 'esp' => 'Inglés'],
            ['name' => 'Manuel Herrera',     'email' => 'm.herrera@colegio.com',   'doc' => '10001007', 'esp' => 'Informática'],
            ['name' => 'Carmen López',       'email' => 'c.lopez@colegio.com',     'doc' => '10001008', 'esp' => 'Arte'],
            ['name' => 'Andrés Castro',      'email' => 'a.castro@colegio.com',    'doc' => '10001009', 'esp' => 'Física'],
            ['name' => 'Sofía Vargas',       'email' => 's.vargas@colegio.com',    'doc' => '10001010', 'esp' => 'Química'],
        ];

        foreach ($profesores as $i => $p) {
            $user = User::firstOrCreate(['email' => $p['email']], [
                'name'     => $p['name'],
                'password' => Hash::make('12345678'),
                'role'     => 'profesor',
            ]);

            $prof = Profesor::firstOrCreate(['documento' => $p['doc']], [
                'user_id'       => $user->id,
                'telefono'      => '310'.str_pad($i + 1, 7, '0', STR_PAD_LEFT),
                'especialidad'  => $p['esp'],
                'fecha_ingreso' => '2020-02-01',
                'estado'        => 'activo',
            ]);
        }

        // Assign director de grupo to cursos
        $allProfesores = Profesor::all();
        $cursos = Curso::all();
        foreach ($cursos as $idx => $curso) {
            if (isset($allProfesores[$idx])) {
                $curso->update(['profesor_id' => $allProfesores[$idx]->id]);
            }
        }
    }
}
