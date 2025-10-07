# Configuración Completa de Google OAuth

## Paso 1: Crear proyecto en Google Cloud Console

### 1.1 Acceder a Google Cloud Console
1. Ve a [Google Cloud Console](https://console.cloud.google.com/)
2. Inicia sesión con tu cuenta de Google

### 1.2 Crear un nuevo proyecto
1. Haz clic en el selector de proyectos (parte superior izquierda)
2. Haz clic en "NUEVO PROYECTO"
3. Nombre del proyecto: `Edward Villa Perfumería OAuth`
4. Haz clic en "CREAR"
5. Selecciona el proyecto recién creado

## Paso 2: Habilitar APIs necesarias

### 2.1 Habilitar Identity Toolkit API (RECOMENDADO)
1. Ve al menú lateral → "APIs y servicios" → "Biblioteca"
2. Busca "Identity Toolkit API"
3. Haz clic en "Identity Toolkit API" y luego "HABILITAR"

### 2.2 Alternativa: Google+ API (Deprecado pero funcional)
1. En la biblioteca de APIs, busca "Google+ API"
2. Haz clic en "Google+ API" y luego "HABILITAR"

## Paso 3: Configurar pantalla de consentimiento OAuth

### 3.1 Configurar pantalla de consentimiento
1. Ve a "APIs y servicios" → "Pantalla de consentimiento de OAuth"
2. Selecciona "Externo" (para usuarios fuera de tu organización)
3. Haz clic en "CREAR"

### 3.2 Información de la aplicación
- **Nombre de la aplicación**: `Edward Villa Perfumería`
- **Correo electrónico de asistencia al usuario**: tu email
- **Logotipo de la aplicación**: (opcional)
- **Dominios autorizados**: `localhost` (para desarrollo)
- **Correo electrónico del desarrollador**: tu email
4. Haz clic en "GUARDAR Y CONTINUAR"

### 3.3 Ámbitos (Scopes)
1. Haz clic en "AGREGAR O QUITAR ÁMBITOS"
2. Selecciona:
   - `../auth/userinfo.email`
   - `../auth/userinfo.profile`
   - `openid`
3. Haz clic en "ACTUALIZAR" y luego "GUARDAR Y CONTINUAR"

### 3.4 Usuarios de prueba
1. Haz clic en "AGREGAR USUARIOS"
2. Agrega tu email y cualquier otro email que quieras probar
3. Haz clic en "GUARDAR Y CONTINUAR"

## Paso 4: Crear credenciales OAuth 2.0

### 4.1 Crear ID de cliente OAuth
1. Ve a "APIs y servicios" → "Credenciales"
2. Haz clic en "+ CREAR CREDENCIALES"
3. Selecciona "ID de cliente de OAuth 2.0"

### 4.2 Configurar aplicación web
1. **Tipo de aplicación**: Aplicación web
2. **Nombre**: `Edward Villa Perfumería Web Client`
3. **URIs de origen autorizados**: 
   - `http://localhost:8000`
4. **URIs de redirección autorizados**:
   - `http://localhost:8000/auth/google/callback`
5. Haz clic en "CREAR"

### 4.3 Guardar credenciales
1. Copia el **ID de cliente** y **Secreto del cliente**
2. Guárdalos de forma segura

## Paso 5: Configurar variables de entorno

### 5.1 Editar archivo .env
Agrega estas líneas a tu archivo `.env`:

```env
# Google OAuth Configuration
GOOGLE_CLIENT_ID=tu_client_id_copiado_aqui
GOOGLE_CLIENT_SECRET=tu_client_secret_copiado_aqui
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

**EJEMPLO:**
```env
GOOGLE_CLIENT_ID=123456789-abcdefghijklmnop.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-abcdefghijklmnopqrstuvwxyz
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

## Paso 6: Verificar configuración

### 6.1 Limpiar caché y reiniciar
```bash
php artisan config:clear
php artisan cache:clear
php artisan serve
```

### 6.2 Probar la configuración
```bash
php artisan tinker
>>> config('services.google')
```

Deberías ver algo como:
```php
=> [
     "client_id" => "123456789-abcdefghijklmnop.apps.googleusercontent.com",
     "client_secret" => "GOCSPX-abcdefghijklmnopqrstuvwxyz",
     "redirect" => "http://localhost:8000/auth/google/callback",
   ]
```

### 6.3 Probar el login
1. Ve a `http://localhost:8000/login`
2. Haz clic en "Continuar con Google"
3. Deberías ser redirigido a Google para autenticarte

## Solución de problemas comunes

### Error: "Missing required parameter: redirect_uri"

Este error indica que la configuración de Google OAuth no está completa. Verifica:

1. **Variables de entorno**: Asegúrate de que `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` y `GOOGLE_REDIRECT_URL` estén configuradas en tu archivo `.env`

2. **URL de redirección**: La URL en `GOOGLE_REDIRECT_URL` debe coincidir exactamente con la configurada en Google Cloud Console

3. **Reiniciar servidor**: Después de cambiar variables de entorno, reinicia el servidor con `php artisan serve`

4. **Verificar configuración**: Ejecuta `php artisan config:clear` para limpiar la caché de configuración

### Error: "Error 400: invalid_request"

1. Verifica que la URL de redirección en Google Cloud Console sea exactamente: `http://localhost:8000/auth/google/callback`
2. Asegúrate de que el proyecto en Google Cloud Console tenga habilitada la API de Google+

### Error: "Error 403: access_denied"

1. Verifica que tu aplicación esté en modo de prueba en Google Cloud Console
2. Agrega tu email como usuario de prueba en la pantalla de consentimiento OAuth

## Comandos útiles para depuración

```bash
# Limpiar caché de configuración
php artisan config:clear

# Verificar configuración actual
php artisan tinker
>>> config('services.google')

# Reiniciar servidor
php artisan serve
```

## Notas importantes

- Los usuarios que se registren con Google tendrán una contraseña aleatoria generada automáticamente
- El campo `google_id` se usa para identificar usuarios de Google
- Los usuarios pueden tener tanto login tradicional como con Google usando el mismo email
- El sistema ahora incluye validación de configuración y mejor manejo de errores
