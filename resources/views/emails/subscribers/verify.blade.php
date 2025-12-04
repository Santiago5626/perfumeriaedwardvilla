@component('mail::message')
# ¡Bienvenido a Edward Villa Perfumería!

Hola,

Gracias por suscribirte a nuestro newsletter. Para completar tu suscripción y comenzar a recibir nuestras ofertas exclusivas, por favor verifica tu correo electrónico.

@component('mail::button', ['url' => $verificationUrl])
Verificar mi suscripción
@endcomponent

## ¿Qué recibirás?
- Ofertas exclusivas en fragancias de lujo
- Descuentos especiales para suscriptores
- Acceso anticipado a promociones

Si no te suscribiste a nuestro newsletter, puedes ignorar este correo.

@component('mail::subcopy')
Si tienes problemas para hacer clic en el botón "Verificar mi suscripción", copia y pega la siguiente URL en tu navegador web:
{{ $verificationUrl }}

Para desuscribirte en cualquier momento, haz clic [aquí]({{ $unsubscribeUrl }}).
@endcomponent

Saludos, Edward Villa Perfumeria<br>
@endcomponent
