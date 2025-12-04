<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CartController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        if (auth()->user()->is_admin) {
            return '/admin';
        }
        
        return '/';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Migrar carrito de sesión al usuario autenticado
        $this->migrateSessionCart();
        
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Migrate session cart to database when user logs in
     */
    private function migrateSessionCart()
    {
        $sessionCart = Session::get('cart', []);
        
        if (!empty($sessionCart)) {
            $cartController = new CartController();
            $cartController->migrateSessionCart();
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
