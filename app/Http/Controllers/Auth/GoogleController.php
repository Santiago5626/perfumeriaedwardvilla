<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CartController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    /**
     * Verificar configuración de Google OAuth
     */
    private function validateGoogleConfig()
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUrl = config('services.google.redirect');

        if (empty($clientId) || empty($clientSecret) || empty($redirectUrl)) {
            Log::error('Configuración de Google OAuth incompleta', [
                'client_id_set' => !empty($clientId),
                'client_secret_set' => !empty($clientSecret),
                'redirect_url_set' => !empty($redirectUrl)
            ]);
            return false;
        }

        return true;
    }

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle(Request $request)
    {
        try {
            // Verificar configuración
            if (!$this->validateGoogleConfig()) {
                return redirect()->route('login')->with('error', 'La autenticación con Google no está configurada correctamente. Contacta al administrador.');
            }

            // Limpiar sesión anterior de Google OAuth si existe
            Session::forget('google_oauth_state');
            
            // Regenerar el token de sesión para mayor seguridad
            $request->session()->regenerateToken();

            // Crear el driver de Google con configuración explícita
            $driver = Socialite::driver('google')
                ->scopes(['openid', 'profile', 'email'])
                ->with(['access_type' => 'online']);

            // Guardar estado en sesión para validación posterior
            $state = Str::random(40);
            Session::put('google_oauth_state', $state);
            
            Log::info('Iniciando redirección a Google OAuth', [
                'user_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'state' => $state
            ]);

            return $driver->redirect();

        } catch (\Exception $e) {
            Log::error('Error en redirectToGoogle', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_ip' => $request->ip()
            ]);
            
            return redirect()->route('login')->with('error', 'Error al conectar con Google. Por favor, inténtalo de nuevo.');
        }
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            // Verificar configuración
            if (!$this->validateGoogleConfig()) {
                return redirect()->route('login')->with('error', 'La autenticación con Google no está configurada correctamente. Contacta al administrador.');
            }

            // Verificar que no hay errores en la respuesta de Google
            if ($request->has('error')) {
                $error = $request->get('error');
                $errorDescription = $request->get('error_description', 'Error desconocido');
                
                Log::warning('Error en callback de Google OAuth', [
                    'error' => $error,
                    'description' => $errorDescription,
                    'user_ip' => $request->ip()
                ]);

                if ($error === 'access_denied') {
                    return redirect()->route('login')->with('error', 'Acceso denegado. Debes autorizar la aplicación para continuar.');
                }

                return redirect()->route('login')->with('error', 'Error de autorización: ' . $errorDescription);
            }

            // Verificar que tenemos los parámetros necesarios
            if (!$request->has('code')) {
                Log::error('Callback de Google OAuth sin código de autorización', [
                    'query_params' => $request->query(),
                    'user_ip' => $request->ip()
                ]);
                return redirect()->route('login')->with('error', 'Respuesta inválida de Google. Por favor, inténtalo de nuevo.');
            }

            // Obtener información del usuario de Google
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            if (!$googleUser || !$googleUser->getEmail()) {
                Log::error('No se pudo obtener información del usuario de Google');
                return redirect()->route('login')->with('error', 'No se pudo obtener tu información de Google. Por favor, inténtalo de nuevo.');
            }

            Log::info('Usuario autenticado con Google', [
                'google_id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName()
            ]);

            // Buscar usuario existente
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // Usuario existente - actualizar google_id si no está configurado
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                    Log::info('Google ID actualizado para usuario existente', ['user_id' => $user->id]);
                }
                
                // Verificar si el usuario está activo (si tienes este campo)
                // if (isset($user->is_active) && !$user->is_active) {
                //     return redirect()->route('login')->with('error', 'Tu cuenta está desactivada. Contacta al administrador.');
                // }
                
                Auth::login($user, true); // true para "remember me"
                Log::info('Usuario existente autenticado', ['user_id' => $user->id]);
                
            } else {
                // Crear nuevo usuario
                $userData = [
                    'name' => $googleUser->getName() ?: 'Usuario de Google',
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(32)), // Contraseña aleatoria
                    'email_verified_at' => now(),
                    'google_id' => $googleUser->getId(),
                ];

                $user = User::create($userData);
                
                Auth::login($user, true); // true para "remember me"
                Log::info('Nuevo usuario creado y autenticado', ['user_id' => $user->id]);
            }

            // Migrar carrito de sesión al usuario autenticado
            $this->migrateSessionCart();

            // Limpiar estado de OAuth de la sesión
            Session::forget('google_oauth_state');
            
            // Regenerar ID de sesión por seguridad
            $request->session()->regenerate();
            
            // Redireccionar según el tipo de usuario
            if ($user->is_admin ?? false) {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('home');
            
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::error('Error de estado inválido en Google OAuth', [
                'error' => $e->getMessage(),
                'user_ip' => $request->ip(),
                'session_id' => $request->session()->getId()
            ]);
            
            // Limpiar sesión y redirigir
            Session::flush();
            return redirect()->route('login')->with('error', 'Sesión expirada o inválida. Por favor, inicia sesión nuevamente.');
            
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error('Error de cliente HTTP en Google OAuth', [
                'error' => $e->getMessage(),
                'response' => $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response',
                'user_ip' => $request->ip()
            ]);
            
            return redirect()->route('login')->with('error', 'Error de comunicación con Google. Verifica tu conexión e inténtalo de nuevo.');
            
        } catch (\Exception $e) {
            Log::error('Error general en handleGoogleCallback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_ip' => $request->ip(),
                'session_id' => $request->session()->getId()
            ]);
            
            return redirect()->route('login')->with('error', 'Error inesperado al iniciar sesión con Google. Por favor, inténtalo de nuevo o usa el login tradicional.');
        }
    }

    /**
     * Desconectar cuenta de Google (opcional)
     */
    public function disconnectGoogle(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user || !$user->google_id) {
                return redirect()->back()->with('error', 'No tienes una cuenta de Google conectada.');
            }

            // Verificar que el usuario tenga una contraseña configurada
            if (!$user->password || Hash::check('', $user->password)) {
                return redirect()->back()->with('error', 'Debes configurar una contraseña antes de desconectar Google.');
            }

            $user->update(['google_id' => null]);
            
            Log::info('Usuario desconectó su cuenta de Google', ['user_id' => $user->id]);
            
            return redirect()->back()->with('success', 'Cuenta de Google desconectada exitosamente.');
            
        } catch (\Exception $e) {
            Log::error('Error al desconectar cuenta de Google', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);
            
            return redirect()->back()->with('error', 'Error al desconectar la cuenta de Google.');
        }
    }

    /**
     * Migrate session cart to database when user authenticates with Google
     */
    private function migrateSessionCart()
    {
        $sessionCart = Session::get('cart', []);
        
        if (!empty($sessionCart)) {
            // Usar app() para resolver el controlador con sus dependencias
            app(CartController::class)->migrateSessionCart();
        }
    }
}
