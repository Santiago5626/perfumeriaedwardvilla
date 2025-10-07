<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,      // Primero crear usuarios (incluyendo admin)
            CategorySeeder::class,  // Luego crear categorías
            ProductSeeder::class,   // Crear productos
            OfferSeeder::class,    // Finalmente crear ofertas
        ]);
    }
}
