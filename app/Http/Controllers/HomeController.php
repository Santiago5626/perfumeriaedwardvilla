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
        // Versión temporal sin base de datos para demostración
        try {
            // Obtener ofertas activas
            $activeOffers = Offer::with('product')
                ->where('active', true)
                ->where('end_date', '>=', now())
                ->get();

            // Primero obtener productos con descuento
            $productsWithDiscount = Product::where('active', true)
                ->whereHas('offers', function($q) {
                    $q->where('active', true)
                      ->where('start_date', '<=', now())
                      ->where('end_date', '>=', now());
                })
                ->with(['category', 'offers' => function($q) {
                    $q->where('active', true)
                      ->where('start_date', '<=', now())
                      ->where('end_date', '>=', now());
                }])
                ->take(10)
                ->get();

            // Si hay menos de 10 productos con descuento, obtener productos normales
            if ($productsWithDiscount->count() < 10) {
                $remainingCount = 10 - $productsWithDiscount->count();
                
                $normalProducts = Product::where('active', true)
                    ->whereDoesntHave('offers', function($q) {
                        $q->where('active', true)
                          ->where('start_date', '<=', now())
                          ->where('end_date', '>=', now());
                    })
                    ->with('category')
                    ->inRandomOrder()
                    ->take($remainingCount)
                    ->get();

                $featuredProducts = $productsWithDiscount->concat($normalProducts);
            } else {
                $featuredProducts = $productsWithDiscount;
            }

            return view('home', compact('activeOffers', 'featuredProducts'));
        } catch (\Exception $e) {
            // Si hay error de base de datos, mostrar página con datos vacíos
            $activeOffers = collect();
            $featuredProducts = collect();
            return view('home', compact('activeOffers', 'featuredProducts'));
        }
    }
}
