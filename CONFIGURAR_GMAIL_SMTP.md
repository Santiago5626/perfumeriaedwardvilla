# Configuración Gmail SMTP - Paso a Paso

## 📧 Pasos para Configurar Gmail

### Paso 1: Habilitar Verificación en 2 Pasos
1. Ve a [myaccount.google.com](https://myaccount.google.com)
2. Haz clic en "Seguridad" en el menú izquierdo
3. Busca "Verificación en 2 pasos" y haz clic en ella
4. Sigue las instrucciones para habilitarla (necesitarás tu teléfono)

### Paso 2: Generar Contraseña de Aplicación
1. Una vez habilitada la verificación en 2 pasos, regresa a "Seguridad"
2. Busca "Contraseñas de aplicaciones" (aparece solo después del paso 1)
3. Haz clic en "Contraseñas de aplicaciones"
4. En "Seleccionar aplicación" elige "Correo"
5. En "Seleccionar dispositivo" elige "Otro (nombre personalizado)"
6. Escribe: "Edward Villa Perfumería"
7. Haz clic en "Generar"
8. **IMPORTANTE**: Copia la contraseña de 16 caracteres que aparece (ejemplo: `abcd efgh ijkl mnop`)

### Paso 3: Configurar tu archivo .env

Abre tu archivo `.env` y busca las líneas que empiecen con `MAIL_`. Reemplázalas con estas:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=la_contraseña_de_16_caracteres_generada
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="Edward Villa Perfumería"
```

**Ejemplo real** (reemplaza con tus datos):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=edwardvilla@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=edwardvilla@gmail.com
MAIL_FROM_NAME="Edward Villa Perfumería"
```

### Paso 4: Aplicar los Cambios
Ejecuta estos comandos en tu terminal:

```bash
php artisan config:clear
php artisan cache:clear
```

### Paso 5: Probar la Configuración
Ejecuta este comando para probar:

```bash
php artisan tinker
```

Luego ejecuta (reemplaza con tu email):
```php
Mail::raw('Correo de prueba desde Edward Villa Perfumería', function ($message) {
    $message->to('tu_email@gmail.com')
            ->subject('Prueba SMTP - Edward Villa Perfumería');
});
```

Si no hay errores, revisa tu bandeja de entrada.

## ⚠️ Problemas Comunes

### "Authentication failed"
- Verifica que hayas copiado correctamente la contraseña de aplicación
- Asegúrate de que la verificación en 2 pasos esté activada

### "Connection refused"
- Verifica que `MAIL_HOST=smtp.gmail.com`
- Verifica que `MAIL_PORT=587`

### Los correos van a spam
- Es normal al principio
- Revisa la carpeta de spam de tu email

## 🧪 Probar el Sistema Completo

1. **Reinicia el servidor**:
```bash
php artisan serve
```

2. **Prueba la suscripción**:
   - Ve a `http://localhost:8000`
   - Ingresa tu email en el formulario de suscripción
   - Deberías recibir un correo de verificación

3. **Verifica la suscripción**:
   - Haz clic en el enlace del correo (por ahora solo se registra en logs)
   - Puedes verificar manualmente en la base de datos

4. **Prueba notificación de oferta**:
   - Ve al panel admin: `http://localhost:8000/admin`
   - Crea una nueva oferta
   - Deberías recibir el correo de la nueva oferta

## 📊 Verificar que Funciona

Para ver los logs de correos:
```bash
tail -f storage/logs/laravel.log | grep -i mail
```

¡Una vez configurado, el sistema enviará correos automáticamente cuando crees ofertas!
