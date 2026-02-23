<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

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
            // Leer el conteo del carrito desde la sesión para evitar queries en cada vista.
            // Se actualiza vía AppServiceProvider::actualizarConteoCarrito() en CartController.
            $cartCount = Session::get('cart_count', 0);
            $view->with('cartCount', $cartCount);
        });

        if(config('app.env') !== 'local') {
            // Forzar esquema HTTPS para todas las URLs generadas
            \Illuminate\Support\Facades\URL::forceScheme('https');

            // Reemplazar APP_URL si viene con http:// para que asset() y url() generen HTTPS
            $appUrl = config('app.url');
            if ($appUrl && str_starts_with($appUrl, 'http://')) {
                $appUrlHttps = 'https://' . substr($appUrl, 7);
                \Illuminate\Support\Facades\URL::forceRootUrl($appUrlHttps);
            }
        }
    }

    /**
     * Recalcula el conteo total del carrito y lo guarda en sesión.
     * Debe llamarse desde CartController en cada operación que modifique el carrito.
     */
    public static function actualizarConteoCarrito(): void
    {
        if (Auth::check()) {
            $total = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $sessionCart = Session::get('cart', []);
            $total = array_sum(array_column($sessionCart, 'quantity') ?: $sessionCart);
        }

        Session::put('cart_count', (int) $total);
    }
}
