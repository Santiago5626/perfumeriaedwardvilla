<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Edward Villa Admin',
            'email' => 'edwardvillaperfumeria@gmail.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        // Crear algunos usuarios de prueba
        User::create([
            'name' => 'Usuario Prueba',
            'email' => 'usuario@test.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@test.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
        ]);
    }
}
