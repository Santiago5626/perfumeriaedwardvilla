# Configuración de Wompi para Edward Villa Perfumería

## Variables de Entorno Requeridas

Agrega las siguientes variables a tu archivo `.env`:

```env
# Configuración de Wompi
WOMPI_PUBLIC_KEY=pub_test_tu_clave_publica_aqui
WOMPI_PRIVATE_KEY=prv_test_tu_clave_privada_aqui
WOMPI_EVENTS_KEY=tu_clave_de_eventos_aqui
WOMPI_REDIRECT_URL=http://localhost:8000/checkout/exito
WOMPI_SANDBOX=true
```

## Configuración en Wompi

1. **Crear cuenta en Wompi**
   - Ve a [https://wompi.co](https://wompi.co)
   - Regístrate y verifica tu cuenta

2. **Obtener las claves**
   - En el dashboard de Wompi, ve a "Configuración" > "Claves API"
   - Copia la clave pública y privada de prueba (test)
   - Para producción, usa las claves de producción

3. **Configurar webhooks**
   - En el dashboard, ve a "Configuración" > "Webhooks"
   - Agrega la URL: `https://tu-dominio.com/checkout/webhook`
   - Selecciona los eventos: `transaction.updated`

## Flujo de Checkout Implementado

### 1. Carrito → Información de Envío
- El botón "Siguiente" en el carrito redirige a `/checkout/envio`
- Se captura información personal y de envío
- Se validan todos los campos requeridos

### 2. Información de Envío → Pago
- Se crea la orden en la base de datos con estado "pending"
- Se redirige a `/checkout/pago` con el widget de Wompi
- Se configura automáticamente con los datos de la orden

### 3. Pago → Confirmación
- Wompi procesa el pago
- En caso de éxito, redirige a `/checkout/exito`
- Se limpia el carrito y se muestra confirmación

## Rutas Implementadas

```php
// Rutas del checkout (requieren autenticación)
Route::middleware(['auth'])->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/envio', [CheckoutController::class, 'shipping'])->name('shipping');
    Route::post('/procesar', [CheckoutController::class, 'process'])->name('process');
    Route::get('/pago', [CheckoutController::class, 'payment'])->name('payment');
    Route::get('/exito', [CheckoutController::class, 'success'])->name('success');
    Route::post('/webhook', [CheckoutController::class, 'webhook'])->name('webhook');
});
```

## Archivos Creados/Modificados

### Nuevos Archivos:
- `app/Http/Controllers/CheckoutController.php` - Controlador principal del checkout
- `resources/views/checkout/shipping.blade.php` - Formulario de información de envío
- `resources/views/checkout/payment.blade.php` - Página de pago con Wompi
- `resources/views/checkout/success.blade.php` - Página de confirmación

### Archivos Modificados:
- `resources/views/cart/index.blade.php` - Cambio del botón "Proceder al Checkout" por "Siguiente"
- `routes/web.php` - Agregadas las rutas del checkout
- `config/services.php` - Configuración de Wompi

## Funcionalidades Implementadas

### ✅ Formulario de Información de Envío
- Información personal (nombre, apellido, email, teléfono)
- Dirección completa de envío
- Notas adicionales para entrega
- Validación completa de campos
- Diseño responsive

### ✅ Integración con Wompi
- Widget oficial de Wompi
- Configuración automática de montos y datos
- Manejo de respuestas de pago
- Webhook para actualizaciones de estado

### ✅ Página de Confirmación
- Detalles completos de la orden
- Información de envío
- Próximos pasos del proceso
- Enlaces a seguimiento y soporte

### ✅ Progreso Visual
- Indicador de pasos (Carrito → Envío → Pago)
- Estados visuales claros
- Navegación intuitiva

## Próximos Pasos (Opcionales)

1. **Configurar emails de confirmación**
   - Crear Mailable para confirmación de orden
   - Enviar email al completar pago

2. **Actualización de inventario**
   - Reducir stock al confirmar pago
   - Manejar productos sin stock

3. **Seguimiento de envíos**
   - Integración con transportadoras
   - Notificaciones de estado

4. **Configuración de producción**
   - Cambiar a claves de producción
   - Configurar dominio real para webhooks
   - Configurar SSL

## Pruebas

Para probar el sistema:

1. Agrega productos al carrito
2. Haz clic en "Siguiente"
3. Completa el formulario de envío
4. Usa las tarjetas de prueba de Wompi:
   - **Visa exitosa**: 4242424242424242
   - **Mastercard exitosa**: 5555555555554444
   - **Tarjeta rechazada**: 4000000000000002

## Soporte

Para dudas sobre la integración:
- Documentación de Wompi: [https://docs.wompi.co](https://docs.wompi.co)
- Soporte técnico: soporte@wompi.co
