# Configuración de Supabase — Perfumería Edward Villa

## ¿Qué es Supabase?
Supabase es una alternativa a Firebase basada en **PostgreSQL**. Ofrece base de datos en la nube, autenticación, almacenamiento y APIs REST generadas automáticamente. Tiene tier gratuito.

---

## Paso 1: Crear el proyecto en Supabase

1. Ir a [https://supabase.com](https://supabase.com) y crear una cuenta
2. Hacer clic en **"New Project"**
3. Configurar:
   - **Name:** `perfumeria-edward-villa`
   - **Database Password:** (guardar esta contraseña, se usará en el `.env`)
   - **Region:** `South America (São Paulo)` — para menor latencia desde Colombia
4. Esperar a que el proyecto se inicialice (~2 minutos)

---

## Paso 2: Obtener las credenciales de conexión

1. En el panel de Supabase ir a **Settings → Database**
2. En la sección **Connection info**, copiar los siguientes valores:

| Campo | Dónde encontrarlo |
|---|---|
| **Host** | `db.XXXXXXXXXX.supabase.co` |
| **Puerto** | `5432` |
| **Base de datos** | `postgres` |
| **Usuario** | `postgres` |
| **Contraseña** | La que elegiste al crear el proyecto |

---

## Paso 3: Crear las tablas en Supabase

1. En el panel de Supabase ir a **SQL Editor**
2. Hacer clic en **"New Query"**
3. Pegar el contenido completo del archivo `database/supabase_schema.sql`
4. Hacer clic en **"Run"**
5. Verificar en **Table Editor** que aparecen todas las tablas

---

## Paso 4: Configurar el `.env` de Laravel

Reemplazar las variables de base de datos en el archivo `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=db.XXXXXXXXXX.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=tu_contraseña_de_supabase
```

> **IMPORTANTE:** Reemplazar `XXXXXXXXXX` con el ID real del proyecto de Supabase.

---

## Paso 5: Verificar la conexión desde Laravel

```bash
# Verificar que Laravel conecta correctamente
php artisan migrate:status

# Si la conexión es exitosa, las migraciones deberían mostrarse sin error
# (pueden aparecer como "not yet run" si las tablas se crearon con el SQL)
```

### Opción A: Si usas el SQL de Supabase (recomendado)
```bash
# Solo marcar las migraciones como ejecutadas sin volver a correrlas
php artisan migrate --pretend
```

### Opción B: Si prefieres que Laravel cree las tablas
```bash
# Eliminar las tablas creadas en Supabase y dejar que Laravel las cree
php artisan migrate:fresh
```

---

## Paso 6: Ejecutar seeders (opcional)

Si tienes datos de prueba en los seeders:

```bash
php artisan db:seed
```

---

## Verificación Final

1. Levantar el servidor: `php artisan serve`
2. Navegar a `http://localhost:8000`
3. Los productos deben cargar desde Supabase
4. Verificar en **Supabase → Table Editor** que los datos aparecen

---

## Diferencias importantes MySQL vs PostgreSQL

| Aspecto | MySQL (anterior) | PostgreSQL/Supabase (nuevo) |
|---|---|---|
| ENUM | Nativo | Sustituido por `VARCHAR` + `CHECK` |
| Auto-increment | `AUTO_INCREMENT` | `BIGSERIAL` |
| Comillas strings | `"` o `'` | Solo `'` |
| Case-sensitive | No (por defecto) | Sí |

### Campos ajustados en este proyecto:

- **`products.gender`** → antes `ENUM`, ahora `VARCHAR(10)` con CHECK `('male', 'female', 'unisex')`
- **`orders.status`** → antes `ENUM`, ahora `VARCHAR(20)` con CHECK `('pending', 'paid', 'shipped', 'delivered', 'cancelled')`

---

## Solución de Problemas

### Error: "SSL connection required"
Agregar al `.env`:
```env
DB_SSLMODE=require
```

### Error: "could not translate host name"
Verificar que el host en `.env` sea exactamente el que aparece en Supabase → Settings → Database.

### Error en migraciones por tablas ya existentes
```bash
php artisan migrate --pretend
# o ejecutar solo las migraciones pendientes
php artisan migrate
```
