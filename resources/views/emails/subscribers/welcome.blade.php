@component('mail::message')
# ¡Bienvenido a Edward Villa Perfumería!

<div style="text-align: center; margin: 20px 0;">
</div>

Hola,

¡Gracias por suscribirte! Estamos emocionados de tenerte como parte de nuestra familia de amantes de las fragancias.

## ¿Qué puedes esperar?

**Ofertas exclusivas** en perfumes de lujo  
**Descuentos especiales** solo para suscriptores  
**Acceso anticipado** a promociones

## Nuestras Marcas Destacadas

Trabajamos con las mejores marcas de perfumería internacional para ofrecerte fragancias únicas y de la más alta calidad.

@component('mail::button', ['url' => route('home')])
Explorar Catálogo
@endcomponent

Mantente atento a tu bandeja de entrada para no perderte nuestras increíbles ofertas.

---

**Edward Villa Perfumería**  
*Esencia y apariencia*

@component('mail::subcopy')
Si no deseas recibir más correos, puedes [desuscribirte aquí]({{ $unsubscribeUrl }}).
@endcomponent

@endcomponent

<style>
/* Ocultar el logo de Laravel en el correo */
.header a {
    background-image: none !important;
}
.header {
    background-image: none !important;
}
</style>
