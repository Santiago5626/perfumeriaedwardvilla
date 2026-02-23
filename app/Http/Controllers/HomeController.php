<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Offer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            // Cachear el contenido de la home por 5 minutos para reducir queries a Supabase
            $datos = \Illuminate\Support\Facades\Cache::remember('home_datos', 300, function () {
                // Obtener ofertas activas con su producto relacionado
                $activeOffers = Offer::with('product')
                    ->where('active', true)
                    ->where('end_date', '>=', now())
                    ->get();

                // Primero obtener productos con descuento activo
                $productsWithDiscount = Product::where('active', true)
                    ->whereHas('offers', function ($q) {
                        $q->where('active', true)
                          ->where('start_date', '<=', now())
                          ->where('end_date', '>=', now());
                    })
                    ->with(['category', 'offers' => function ($q) {
                        $q->where('active', true)
                          ->where('start_date', '<=', now())
                          ->where('end_date', '>=', now());
                    }])
                    ->take(10)
                    ->get();

                // Si no hay suficientes con descuento, completar con productos recientes
                // Se usa latest('id') en vez de inRandomOrder() para aprovechar el índice
                if ($productsWithDiscount->count() < 10) {
                    $remainingCount = 10 - $productsWithDiscount->count();

                    $normalProducts = Product::where('active', true)
                        ->whereDoesntHave('offers', function ($q) {
                            $q->where('active', true)
                              ->where('start_date', '<=', now())
                              ->where('end_date', '>=', now());
                        })
                        ->with('category')
                        ->latest('id')
                        ->take($remainingCount)
                        ->get();

                    $featuredProducts = $productsWithDiscount->concat($normalProducts);
                } else {
                    $featuredProducts = $productsWithDiscount;
                }

                return compact('activeOffers', 'featuredProducts');
            });

            return view('home', $datos);
        } catch (\Exception $e) {
            // Si hay error de base de datos o caché, mostrar página con datos vacíos
            $activeOffers = collect();
            $featuredProducts = collect();
            return view('home', compact('activeOffers', 'featuredProducts'));
        }
    }
}
