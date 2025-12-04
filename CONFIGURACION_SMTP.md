# Configuración SMTP para Envío de Correos

## 📧 Opciones de Proveedores SMTP

### 1. **Gmail (Recomendado para desarrollo)**

#### Paso 1: Habilitar autenticación de 2 factores
1. Ve a tu cuenta de Google
2. Seguridad → Verificación en 2 pasos → Activar

#### Paso 2: Generar contraseña de aplicación
1. Ve a Seguridad → Verificación en 2 pasos
2. Busca "Contraseñas de aplicaciones"
3. Selecciona "Correo" y "Otro (nombre personalizado)"
4. Escribe "Edward Villa Perfumería"
5. Copia la contraseña generada (16 caracteres)

#### Paso 3: Configurar en .env
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=la_contraseña_de_aplicacion_generada
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="Edward Villa Perfumería"
```

### 2. **Outlook/Hotmail**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@outlook.com
MAIL_PASSWORD=tu_contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@outlook.com
MAIL_FROM_NAME="Edward Villa Perfumería"
```

### 3. **Mailtrap (Para desarrollo/testing)**

1. Regístrate en [mailtrap.io](https://mailtrap.io)
2. Crea un inbox
3. Copia las credenciales SMTP

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_username_mailtrap
MAIL_PASSWORD=tu_password_mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@edwardvillaperfumeria.com
MAIL_FROM_NAME="Edward Villa Perfumería"
```

### 4. **SendGrid (Para producción)**

1. Regístrate en [sendgrid.com](https://sendgrid.com)
2. Crea una API Key
3. Verifica tu dominio

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=tu_api_key_de_sendgrid
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tudominio.com
MAIL_FROM_NAME="Edward Villa Perfumería"
```

## 🛠️ Pasos para Configurar

### 1. Editar archivo .env
Abre tu archivo `.env` y busca las líneas que empiecen con `MAIL_`. Reemplázalas con la configuración de tu proveedor elegido.

### 2. Limpiar caché de configuración
```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Probar la configuración
```bash
php artisan tinker
```

Luego ejecuta:
```php
Mail::raw('Correo de prueba', function ($message) {
    $message->to('tu_email@gmail.com')
            ->subject('Prueba SMTP Edward Villa Perfumería');
});
```

## 🔧 Ejemplo Completo para Gmail

Si tu email es `edwardvilla@gmail.com`:

1. **Genera contraseña de aplicación** siguiendo los pasos arriba
2. **Edita tu .env**:
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

3. **Ejecuta los comandos**:
```bash
php artisan config:clear
php artisan cache:clear
```

## ⚠️ Solución de Problemas

### Error: "Authentication failed"
- Verifica que la contraseña de aplicación esté correcta
- Asegúrate de que la verificación en 2 pasos esté activada

### Error: "Connection timeout"
- Verifica el HOST y PORT
- Revisa tu firewall/antivirus

### Error: "TLS/SSL connection failed"
- Cambia `MAIL_ENCRYPTION=tls` por `MAIL_ENCRYPTION=ssl`
- O cambia el puerto a 465

### Los correos no llegan
- Revisa la carpeta de spam
- Verifica que `MAIL_FROM_ADDRESS` sea válido
- Usa Mailtrap para testing

## 🧪 Probar el Sistema Completo

1. **Configura SMTP** siguiendo los pasos arriba
2. **Reinicia el servidor**:
```bash
php artisan serve
```

3. **Prueba la suscripción**:
   - Ve a `http://localhost:8000`
   - Suscríbete con tu email
   - Revisa tu correo para el enlace de verificación

4. **Prueba notificación de oferta**:
   - Ve al panel admin
   - Crea una nueva oferta
   - Verifica que llegue el correo de la oferta

## 📊 Monitoreo

Para ver si los correos se están enviando:
```bash
tail -f storage/logs/laravel.log | grep "Correo"
```

## 🎯 Recomendaciones

- **Desarrollo**: Usa Mailtrap o Gmail
- **Producción**: Usa SendGrid, Mailgun o Amazon SES
- **Siempre**: Configura un dominio propio para mejor deliverability

¡Una vez configurado, el sistema de suscripciones enviará correos automáticamente cuando crees nuevas ofertas!
