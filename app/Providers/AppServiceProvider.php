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
}
