<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use App\Models\Product;
use Carbon\Carbon;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener algunos productos para crear ofertas
        $products = Product::take(4)->get();

        if ($products->count() > 0) {
            foreach ($products as $index => $product) {
                $discountPercentage = [15, 20, 25, 30][$index] ?? 20;
                $finalPrice = $product->price * (1 - ($discountPercentage / 100));

                Offer::create([
                    'product_id' => $product->id,
                    'discount_percentage' => $discountPercentage,
                    'final_price' => $finalPrice,
                    'start_date' => Carbon::now()->subDays(1),
                    'end_date' => Carbon::now()->addDays(30),
                    'description' => "Oferta especial del {$discountPercentage}% de descuento en {$product->name}",
                    'active' => true
                ]);
            }
        }
    }
}
