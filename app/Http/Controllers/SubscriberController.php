<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Mail\VerificationEmail;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    /**
     * Suscribirse al newsletter
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $email = $request->email;

        try {
            // Verificar si ya existe el suscriptor
            $existingSubscriber = Subscriber::where('email', $email)->first();

            if ($existingSubscriber) {
                if ($existingSubscriber->is_active) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Este correo ya está suscrito a nuestras ofertas.'
                    ], 409);
                }

                // Si existe pero no está activo, no ha sido verificado, reenviar correo de verificación
                $existingSubscriber->update([
                    'verification_token' => Subscriber::generateVerificationToken(), // Generar nuevo token
                ]);

                $subscriber = $existingSubscriber;
                $this->sendVerificationEmail($subscriber);

                return response()->json([
                    'success' => true,
                    'message' => 'Te hemos reenviado un correo para que verifiques tu suscripción.'
                ]);
            } else {
                // Crear nuevo suscriptor
                $subscriber = Subscriber::create([
                    'email' => $email,
                    'is_active' => false, // Se activará al verificar
                    'verification_token' => Subscriber::generateVerificationToken(),
                ]);

                // Enviar correo de verificación
                $this->sendVerificationEmail($subscriber);
            }

            Log::info('Nueva suscripción al newsletter', [
                'email' => $email,
                'subscriber_id' => $subscriber->id
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Gracias por suscribirte! Revisa tu correo para verificar tu suscripción.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al suscribir al newsletter', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la suscripción. Por favor, inténtalo de nuevo.'
            ], 500);
        }
    }

    /**
     * Verificar suscripción
     */
    public function verify(Request $request, $token)
    {
        try {
            $subscriber = Subscriber::where('verification_token', $token)->first();

            if (!$subscriber) {
                return redirect()->route('home')->with('error', 'Token de verificación inválido.');
            }

            if ($subscriber->isVerified()) {
                return redirect()->route('home')->with('info', 'Tu suscripción ya está verificada.');
            }

            $subscriber->markAsVerified();

            // Enviar correo de bienvenida después de la verificación
            $this->sendWelcomeEmail($subscriber);

            Log::info('Suscripción verificada', [
                'email' => $subscriber->email,
                'subscriber_id' => $subscriber->id
            ]);

            return redirect()->route('home')->with('success', '¡Suscripción verificada exitosamente! Te hemos enviado un correo de bienvenida.');

        } catch (\Exception $e) {
            Log::error('Error al verificar suscripción', [
                'token' => $token,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('home')->with('error', 'Error al verificar la suscripción.');
        }
    }

    /**
     * Desuscribirse
     */
    public function unsubscribe(Request $request, $email)
    {
        try {
            $subscriber = Subscriber::where('email', $email)->first();

            if (!$subscriber) {
                return redirect()->route('home')->with('error', 'Suscripción no encontrada.');
            }

            $subscriber->update(['is_active' => false]);

            Log::info('Usuario se desuscribió', [
                'email' => $email,
                'subscriber_id' => $subscriber->id
            ]);

            return redirect()->route('home')->with('success', 'Te has desuscrito exitosamente de nuestras ofertas.');

        } catch (\Exception $e) {
            Log::error('Error al desuscribir', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('home')->with('error', 'Error al procesar la desuscripción.');
        }
    }

    /**
     * Enviar correo de verificación
     */
    private function sendVerificationEmail(Subscriber $subscriber)
    {
        try {
            $verificationUrl = route('newsletter.verify', $subscriber->verification_token);

            // Enviar correo de verificación
            Mail::to($subscriber->email)->send(new VerificationEmail($subscriber, $verificationUrl));

            Log::info('Correo de verificación enviado', [
                'email' => $subscriber->email,
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar correo de bienvenida', [
                'email' => $subscriber->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Re-lanzar la excepción para que sea manejada por el método principal
            throw $e;
        }
    }

    /**
     * Enviar correo de bienvenida
     */
    private function sendWelcomeEmail(Subscriber $subscriber)
    {
        try {
            $unsubscribeUrl = route('newsletter.unsubscribe', $subscriber->email);

            // Enviar correo de bienvenida
            Mail::to($subscriber->email)->send(new WelcomeEmail($subscriber, $unsubscribeUrl));

            Log::info('Correo de bienvenida enviado', [
                'email' => $subscriber->email,
                'unsubscribe_url' => $unsubscribeUrl
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar correo de bienvenida', [
                'email' => $subscriber->email,
                'error' => $e->getMessage(),
            ]);
            // No relanzamos la excepción para no afectar el flujo del usuario si solo falla el email de bienvenida.
        }
    }
}
