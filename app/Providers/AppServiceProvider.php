<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                // Usuario autenticado - obtener cantidad del carrito de la BD
                $cartCount = Cart::where('user_id', Auth::id())
                    ->sum('quantity');
            } else {
                // Usuario no autenticado - obtener cantidad del carrito de la sesión
                $sessionCart = Session::get('cart', []);
                $cartCount = array_sum($sessionCart);
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
