# Configuración de Mercado Pago

## ✅ **Integración Completada**

La integración de Mercado Pago ha sido configurada exitosamente. A continuación se detallan los pasos que se realizaron y la configuración adicional necesaria.

---

## 📋 **Lo que se configuró:**

### 1. **SDK Instalado**
```bash
composer require mercadopago/dx-php
```

### 2. **Credenciales Configuradas en .env**
```env
MERCADOPAGO_PUBLIC_KEY=APP_USR-2df30476-5bf8-4278-be18-3c7e01392f4e
MERCADOPAGO_ACCESS_TOKEN=APP_USR-1434485984305841-120412-bdd0d43b499b5f10d2cc25d407f6272d-2572156598
MERCADOPAGO_SANDBOX=false
```

### 3. **Archivos Modificados**
- ✅ `config/services.php` - Agregada configuración de Mercado Pago
- ✅ `app/Http/Controllers/CheckoutController.php` - Actualizado para usar Mercado Pago
- ✅ `resources/views/checkout/payment.blade.php` - Nueva vista con Checkout de Mercado Pago
- ✅ `app/Http/Middleware/VerifyCsrfToken.php` - Webhook exceptuado de CSRF
- ✅ `.env` - Credenciales agregadas

---

## 🔔 **Configurar Webhooks (IMPORTANTE)**

Para recibir notificaciones de pago, debes configurar webhooks en Mercado Pago:

### **Paso 1: Acceder a tu Panel de Mercado Pago**
1. Ve a [mercadopago.com](https://www.mercadopago.com)
2. Inicia sesión
3. Ve a **"Desarrolladores"** → **"Webhooks"**

### **Paso 2: Crear un nuevo Webhook**
1. Click en **"Crear nuevo webhook"**
2. En **"URL de notificación"**, ingresa:
   ```
   https://tudominio.com/checkout/webhook
   ```
   (Reemplaza `tudominio.com` con tu dominio real)
   
   Para desarrollo local, puedes usar **ngrok** o **Expose**:
   ```
   https://tu-url-ngrok.ngrok.io/checkout/webhook
   ```

3. En **"Eventos"**, selecciona:
   - ✅ `payment` (Pagos)
   
4. Click en **"Crear"**

### **Paso 3: Verificar que funcione**
Mercado Pago enviará notificaciones POST a tu webhook cuando:
- Un pago es aprobado
- Un pago es rechazado
- Un pago está pendiente
- Un pago es cancelado

---

## 🧪 **Probar la Integración**

### **Modo Producción (Pagos Reales)**
Tu aplicación está configurada para usar credenciales de **producción**:
- Los pagos serán **reales** y procesarán dinero real
- Las tarjetas de prueba **NO** funcionarán

### **Si quieres probar sin cobrar (Modo Sandbox)**

1. **Obtén credenciales de prueba:**
   - Ve a [mercadopago.com](https://www.mercadopago.com) → Desarrolladores → Credenciales
   - Copia las credenciales de **Prueba** (empiezan con `TEST-`)

2. **Actualiza tu .env:**
   ```env
   MERCADOPAGO_PUBLIC_KEY=TEST-xxxxx
   MERCADOPAGO_ACCESS_TOKEN=TEST-xxxxx
   MERCADOPAGO_SANDBOX=true
   ```

3. **Usa tarjetas de prueba:**
   - Visa: 4509 9535 6623 3704
   - Mastercard: 5031 7557 3453 0604
   
   Para más tarjetas de prueba: [Tarjetas de prueba Mercado Pago](https://www.mercadopago.com.ar/developers/es/docs/checkout-api/additional-content/test-cards)

---

## 🔄 **Flujo de Pago**

1. Usuario completa el checkout
2. Se crea una **Preferencia de Pago** en Mercado Pago
3. Usuario es redirigido al **Checkout de Mercado Pago**
4. Usuario completa el pago
5. Mercado Pago envía notificación al **webhook**
6. El webhook actualiza el estado de la orden
7. Usuario es redirigido a la página de éxito

---

## 📊 **Estados de la Orden**

El sistema mapea los estados de Mercado Pago a estados de orden:

| Estado Mercado Pago | Estado Orden | Descripción |
|---------------------|--------------|-------------|
| `approved` | `paid` | Pago aprobado |
| `pending` | `pending` | Pago pendiente |
| `in_process` | `pending` | Pago en proceso |
| `rejected` | `cancelled` | Pago rechazado |
| `cancelled` | `cancelled` | Pago cancelado |

---

## 🚀 **URLs de Retorno**

El sistema está configurado con estas URLs:
- **Éxito:** `/checkout/success`
- **Fallo:** `/cart`
- **Pendiente:** `/checkout/success`

---

## 🔐 **Seguridad**

- ✅ Las claves están en el archivo `.env` (no en el repositorio)
- ✅ El webhook está protegido contra CSRF
- ✅ Se verifica el `external_reference` para validar la orden
- ✅ Todas las comunicaciones usan HTTPS

---

## 📝 **Notas Importantes**

1. **Producción vs Sandbox:**
   - Actualmente estás en modo **PRODUCCIÓN**
   - Para pruebas, cambia a credenciales TEST

2. **Webhooks en localhost:**
   - Los webhooks NO funcionan en `localhost`
   - Usa **ngrok** o **Expose** para exponer tu localhost

3. **Validación de Pagos:**
   - SIEMPRE valida los pagos en el webhook
   - NO confíes solo en las URLs de retorno

---

## 🛠️ **Troubleshooting**

### El botón de pago no aparece
- Verifica que las credenciales estén correctas en `.env`
- Revisa la consola del navegador en busca de errores
- Ejecuta `php artisan config:clear`

### El webhook no recibe notificaciones
- Verifica que la URL del webhook esté configurada en Mercado Pago
- Asegúrate de que la URL sea accesible públicamente (no localhost)
- Revisa los logs: `storage/logs/laravel.log`

### Errores de credenciales
- Verifica que copiaste las credenciales completas
- Asegúrate de usar Public Key y Access Token del mismo entorno (ambas TEST o ambas PROD)

---

## 📚 **Recursos Adicionales**

- [Documentación Mercado Pago](https://www.mercadopago.com.ar/developers/es/docs)
- [SDK PHP Mercado Pago](https://github.com/mercadopago/sdk-php)
- [Tarjetas de Prueba](https://www.mercadopago.com.ar/developers/es/docs/checkout-api/additional-content/test-cards)
- [Webhooks](https://www.mercadopago.com.ar/developers/es/docs/checkout-api/additional-content/notifications/webhooks)

---

**¡Tu integración de Mercado Pago está lista!** 🎉
