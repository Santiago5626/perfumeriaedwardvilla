# Keep-Alive para Render (Plan Gratuito)

## 🎯 Propósito

Este sistema mantiene el servidor de Render despierto durante horario activo (6 AM - 12 AM hora de Colombia) para evitar que entre en modo "sleep" después de 15 minutos de inactividad.

## 🔧 Componentes

### 1. Endpoint `/ping` (Laravel)
- **Ubicación**: `routes/web.php`
- **Función**: Responde con un JSON simple indicando que el servidor está activo
- **Respuesta**: `{"status": "ok", "timestamp": "2025-12-04T13:00:00.000000Z"}`

### 2. GitHub Actions Workflow
- **Ubicación**: `.github/workflows/keep-alive.yml`
- **Frecuencia**: Cada 14 minutos
- **Horario activo**: 6:00 AM - 11:59 PM (hora de Colombia, UTC-5)
- **Horario inactivo**: 12:00 AM - 5:59 AM (el servidor puede dormirse)

## ⚙️ Configuración

### Habilitar GitHub Actions

1. Ve a tu repositorio en GitHub
2. Navega a **Settings** → **Actions** → **General**
3. En "Workflow permissions", asegúrate de que esté habilitado
4. El workflow se activará automáticamente después del primer push

### Ejecutar manualmente (Opcional)

Puedes probar el workflow manualmente:
1. Ve a tu repositorio en GitHub
2. Click en **Actions**
3. Selecciona "Keep Server Alive"
4. Click en **Run workflow**

## 📊 Monitoreo

Para ver los logs del workflow:
1. Ve a **Actions** en tu repositorio
2. Selecciona "Keep Server Alive"
3. Verás el historial de ejecuciones con:
   - ✅ Pings exitosos (HTTP 200)
   - ⚠️ Errores si el servidor no responde
   - 🌙 Mensajes cuando está fuera del horario activo

 

1. Edita `.github/workflows/keep-alive.yml`
2. Cambia `TZ=America/Bogota` por tu zona horaria
3. Ajusta los cron schedules según tus necesidades

## 💡 Ventajas

- ✅ **Gratis**: Usa GitHub Actions (gratuito para repos públicos)
- ✅ **Eficiente**: Solo hace pings durante horario activo
- ✅ **Ahorro**: Pausa durante la noche para no saturar el plan gratuito
- ✅ **Configurable**: Fácil de ajustar horarios
- ✅ **Sin dependencias**: No requiere servicios externos

## ⚠️ Limitaciones del Plan Gratuito de Render

- El servidor se duerme después de **15 minutos** de inactividad
- El servidor puede tardar **30-60 segundos** en despertar
- Ancho de banda mensual limitado (100 GB)
- Horas de cómputo mensuales limitadas (750 horas)

## 🔄 Alternativas

Si necesitas que el servidor esté **siempre activo**:
- Upgrade al plan pago de Render ($7/mes)
- Usa servicios como UptimeRobot (24/7, pero puede agotar el plan gratuito más rápido)

---

**Nota**: Este sistema es perfecto para aplicaciones con tráfico durante el día y menor actividad nocturna.
