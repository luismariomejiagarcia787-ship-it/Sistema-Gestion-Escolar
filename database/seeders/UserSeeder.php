<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@colegio.com'], [
            'name'     => 'Administrador Principal',
            'password' => Hash::make('12345678'),
            'role'     => 'admin',
        ]);

        User::firstOrCreate(['email' => 'profesor@colegio.com'], [
            'name'     => 'Carlos Rodríguez',
            'password' => Hash::make('12345678'),
            'role'     => 'profesor',
        ]);

        User::firstOrCreate(['email' => 'estudiante@colegio.com'], [
            'name'     => 'María García',
            'password' => Hash::make('12345678'),
            'role'     => 'estudiante',
        ]);
    }
}
