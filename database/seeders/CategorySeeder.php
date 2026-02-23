<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Fragancias Masculinas',
            'Fragancias Femeninas',
            'Fragancias Unisex',
            'Perfumes de Lujo',
            'Eau de Toilette',
            'Eau de Parfum',
            'Colonias',
            'Perfumes Orientales',
            'Perfumes Frescos',
            'Perfumes Florales'
        ];

        foreach ($categories as $categoryName) {
            Category::updateOrCreate(
                ['slug' => Str::slug($categoryName)],
                [
                    'name' => $categoryName,
                    'active' => true,
                ]
            );
        }
    }
}
