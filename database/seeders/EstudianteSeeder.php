<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EstudianteSeeder extends Seeder
{
    public function run(): void
    {
        $nombres = [
            'María García','Juan Pérez','Sofía Rodríguez','Carlos López','Valentina Martínez',
            'Andrés Gómez','Isabella Torres','Diego Herrera','Camila Castro','Sebastián Vargas',
            'Lucía Jiménez','Miguel Ángel Moreno','Natalia Ruiz','Felipe Díaz','Ana María Sánchez',
            'Nicolás Ramírez','Daniela Cruz','Santiago Rojas','Gabriela Flores','Alejandro Reyes',
        ];

        $cursos = Curso::all();

        // Make sure the default estudiante user is linked
        $defaultUser = User::where('email','estudiante@colegio.com')->first();

        foreach ($nombres as $i => $nombre) {
            $email = strtolower(str_replace([' ','Á','É','Í','Ó','Ú','Ñ','á','é','í','ó','ú','ñ'],
                ['.','a','e','i','o','u','n','a','e','i','o','u','n'], $nombre)).'@estudiante.com';

            $isDefault = ($nombre === 'María García');
            $userEmail = $isDefault ? 'estudiante@colegio.com' : $email;

            $user = $isDefault
                ? $defaultUser
                : User::firstOrCreate(['email' => $userEmail], [
                    'name'     => $nombre,
                    'password' => Hash::make('12345678'),
                    'role'     => 'estudiante',
                ]);

            if (!$user) continue;

            $cursoId = $cursos->count() > 0 ? $cursos[$i % $cursos->count()]->id : null;

            Estudiante::firstOrCreate(['documento' => '2000'.str_pad($i + 1, 4, '0', STR_PAD_LEFT)], [
                'user_id'          => $user->id,
                'telefono'         => '315'.str_pad($i + 1, 7, '0', STR_PAD_LEFT),
                'direccion'        => 'Calle '.($i + 1).' # '.($i + 10).'-'.($i + 5),
                'fecha_nacimiento' => '200'.($i % 10 > 5 ? '7' : '8').'-'.str_pad(($i % 12) + 1, 2, '0', STR_PAD_LEFT).'-15',
                'genero'           => $i % 2 === 0 ? 'femenino' : 'masculino',
                'curso_id'         => $cursoId,
                'estado'           => 'activo',
            ]);
        }
    }
}
