# 🛠️ Edward Villa Perfumería - Documentación para Desarrolladores

Sistema completo de e-commerce para venta de perfumes desarrollado con Laravel 9 y Bootstrap 5.

---

## 📖 Índice

1. [Descripción General](#descripción-general)
2. [Stack Tecnológico](#stack-tecnológico)
3. [Requisitos del Sistema](#requisitos-del-sistema)
4. [Instalación y Configuración](#instalación-y-configuración)
5. [Estructura del Proyecto](#estructura-del-proyecto)
6. [Base de Datos](#base-de-datos)
7. [Funcionalidades Implementadas](#funcionalidades-implementadas)
8. [Autenticación y Autorización](#autenticación-y-autorización)
9. [Sistema de Email](#sistema-de-email)
10. [API y Rutas](#api-y-rutas)
11. [Modelos y Relaciones](#modelos-y-relaciones)
12. [Testing](#testing)
13. [Deployment](#deployment)
14. [Solución de Problemas](#solución-de-problemas)
15. [Mejoras Futuras](#mejoras-futuras)

---

## 🎯 Descripción General

**Edward Villa Perfumería** es una aplicación web de comercio electrónico completa que permite:

- Gestión de productos, categorías y ofertas
- Sistema de autenticación (tradicional + Google OAuth)
- Carrito de compras con sesiones
- Procesamiento de pedidos
- Panel de administración
- Sistema de newsletter con verificación de email
- Notificaciones automáticas de ofertas
- Reportes de ventas e inventario

### **Características Destacadas**

- ✅ MVC pattern con Laravel 9
- ✅ Eloquent ORM para manejo de base de datos
- ✅ Blade templating engine
- ✅ Bootstrap 5 para UI responsivo
- ✅ AJAX para interacciones dinámicas
- ✅ Middleware para autorización
- ✅ Sistema de correos con Laravel Mail
- ✅ Socialite para OAuth (Google)
- ✅ CSRF protection
- ✅ Validación de formularios
- ✅ Logging y manejo de errores

---

## 💻 Stack Tecnológico

### **Backend**
- **Framework**: Laravel 9.x
- **PHP**: ^8.0.2
- **Base de Datos**: MySQL/MariaDB
- **Autenticación**: Laravel Sanctum + Laravel Socialite
- **ORM**: Eloquent

### **Frontend**
- **CSS Framework**: Bootstrap 5.2.3
- **JS Build Tool**: Vite 4.0
- **JavaScript**: ES6+ con Axios
- **Preprocesador CSS**: Sass 1.56
- **Íconos**: Bootstrap Icons

### **Dependencias Principales**

#### Composer (PHP)
```json
{
  "guzzlehttp/guzzle": "^7.2",
  "laravel/framework": "^9.19",
  "laravel/sanctum": "^3.0",
  "laravel/socialite": "^5.21",
  "laravel/tinker": "^2.7",
  "laravel/ui": "^4.6"
}
```

#### NPM (JavaScript)
```json
{
  "@popperjs/core": "^2.11.6",
  "axios": "^1.1.2",
  "bootstrap": "^5.2.3",
  "laravel-vite-plugin": "^0.7.2",
  "sass": "^1.56.1",
  "vite": "^4.0.0"
}
```

---

## ⚙️ Requisitos del Sistema

### **Software Requerido**

- **PHP**: >= 8.0.2
- **Composer**: >= 2.x
- **Node.js**: >= 16.x
- **NPM**: >= 8.x
- **MySQL/MariaDB**: >= 5.7 / >= 10.3
- **Servidor Web**: Apache/Nginx

### **Extensiones PHP Requeridas**

- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO_MySQL
- Tokenizer
- XML

---

## 🚀 Instalación y Configuración

### **1. Clonar el Repositorio**

```bash
git clone <URL_DEL_REPOSITORIO>
cd perfumeriaedwardvilla-main
```

### **2. Instalar Dependencias PHP**

```bash
composer install
```

### **3. Instalar Dependencias JavaScript**

```bash
npm install
```

### **4. Configurar Variables de Entorno**

```bash
# Copiar archivo de ejemplo
cp .env.example .env

# Generar key de aplicación
php artisan key:generate
```

### **5. Configurar Base de Datos**

Edita el archivo `.env` con tus credenciales:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perfumeria_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### **6. Ejecutar Migraciones**

```bash
# Crear todas las tablas
php artisan migrate

# Opcional: Ejecutar seeders para datos de prueba
php artisan db:seed
```

### **7. Configurar Google OAuth (Opcional)**

Edita `.env` con tus credenciales de Google Cloud:

```env
GOOGLE_CLIENT_ID=tu_client_id
GOOGLE_CLIENT_SECRET=tu_client_secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

Ver documentación completa en: [GOOGLE_OAUTH_SETUP.md](GOOGLE_OAUTH_SETUP.md)

### **8. Configurar SMTP para Emails (Opcional)**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="Edward Villa Perfumería"
```

Ver documentación completa en: [CONFIGURACION_SMTP.md](CONFIGURACION_SMTP.md)

### **9. Compilar Assets**

```bash
# Para desarrollo (con watch)
npm run dev

# Para producción
npm run build
```

### **10. Iniciar Servidor de Desarrollo**

```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

### **11. Crear Usuario Administrador**

```bash
php artisan tinker
```

```php
>>> $user = new App\Models\User();
>>> $user->name = 'Admin';
>>> $user->email = 'admin@ejemplo.com';
>>> $user->password = Hash::make('password123');
>>> $user->is_admin = true;
>>> $user->save();
```

---

## 📁 Estructura del Proyecto

```
perfumeriaedwardvilla-main/
│
├── app/
│   ├── Console/              # Comandos de consola
│   ├── Exceptions/           # Manejo de excepciones
│   ├── Http/
│   │   ├── Controllers/      # Controladores
│   │   │   ├── AdminController.php
│   │   │   ├── CartController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── CheckoutController.php
│   │   │   ├── HomeController.php
│   │   │   ├── OrderController.php
│   │   │   ├── ProductController.php
│   │   │   ├── SubscriberController.php
│   │   │   └── Auth/
│   │   │       └── GoogleController.php
│   │   ├── Middleware/       # Middleware personalizado
│   │   └── Requests/         # Form requests
│   ├── Mail/                 # Mailables
│   │   ├── NewOfferNotification.php
│   │   ├── SubscriptionVerification.php
│   │   └── OrderConfirmation.php
│   ├── Models/               # Modelos Eloquent
│   │   ├── Cart.php
│   │   ├── Category.php
│   │   ├── Offer.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Product.php
│   │   ├── Subscriber.php
│   │   └── User.php
│   └── Providers/            # Service providers
│
├── bootstrap/                # Archivos de bootstrap
│
├── config/                   # Archivos de configuración
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   ├── mail.php
│   └── services.php         # Configuración OAuth
│
├── database/
│   ├── factories/            # Model factories
│   ├── migrations/           # Migraciones de base de datos
│   └── seeders/              # Seeders
│
├── public/                   # Archivos públicos
│   ├── images/               # Imágenes de productos
│   ├── videos/               # Videos
│   └── index.php             # Punto de entrada
│
├── resources/
│   ├── css/                  # Archivos CSS
│   ├── js/                   # Archivos JavaScript
│   ├── sass/                 # Archivos SASS
│   └── views/                # Vistas Blade
│       ├── admin/            # Vistas de administración
│       ├── auth/             # Vistas de autenticación
│       ├── cart/             # Vistas del carrito
│       ├── categories/       # Vistas de categorías
│       ├── checkout/         # Vistas de checkout
│       ├── home/             # Vistas de inicio
│       ├── layouts/          # Layouts principales
│       ├── orders/           # Vistas de pedidos
│       ├── products/         # Vistas de productos
│       └── emails/           # Templates de email
│
├── routes/
│   ├── api.php               # Rutas API
│   ├── channels.php          # Broadcasting channels
│   ├── console.php           # Comandos de consola
│   └── web.php               # Rutas web principales
│
├── storage/                  # Archivos de almacenamiento
│   ├── app/                  # Archivos de aplicación
│   ├── framework/            # Framework cache/sessions
│   └── logs/                 # Logs de aplicación
│
├── tests/                    # Tests automatizados
│
├── .env.example              # Ejemplo de variables de entorno
├── artisan                   # CLI de Laravel
├── composer.json             # Dependencias PHP
├── package.json              # Dependencias JavaScript
├── vite.config.js            # Configuración de Vite
└── phpunit.xml               # Configuración PHPUnit
```

---

## 🗄️ Base de Datos

### **Diagrama de Entidad-Relación**

```
┌─────────────┐         ┌─────────────┐         ┌─────────────┐
│   Users     │         │  Products   │         │ Categories  │
├─────────────┤         ├─────────────┤         ├─────────────┤
│ id (PK)     │         │ id (PK)     │◄────────│ id (PK)     │
│ name        │         │ name        │         │ name        │
│ email       │         │ description │         │ description │
│ password    │         │ price       │         │ created_at  │
│ is_admin    │         │ image       │         │ updated_at  │
│ google_id   │         │ stock       │         └─────────────┘
│ created_at  │         │ category_id │
│ updated_at  │         │ size        │
└──────┬──────┘         │ gender      │
       │                │ active      │
       │                │ created_at  │
       │                │ updated_at  │
       │                └──────┬──────┘
       │                       │
       │                       │
       │                ┌──────▼──────┐
       │                │   Offers    │
       │                ├─────────────┤
       │                │ id (PK)     │
       │                │ product_id  │
       │                │ discount_%  │
       │                │ start_date  │
       │                │ end_date    │
       │                │ is_active   │
       │                └─────────────┘
       │
       │                ┌─────────────┐
       ├───────────────►│    Cart     │
       │                ├─────────────┤
       │                │ id (PK)     │
       │                │ user_id     │
       │                │ product_id  │
       │                │ quantity    │
       │                │ session_id  │
       │                └─────────────┘
       │
       │                ┌─────────────┐
       ├───────────────►│   Orders    │
       │                ├─────────────┤
       │                │ id (PK)     │
       │                │ user_id     │
       │                │ total       │
       │                │ status      │
       │                │ address     │
       │                │ created_at  │
       │                └──────┬──────┘
       │                       │
       │                ┌──────▼──────┐
       │                │ OrderItems  │
       │                ├─────────────┤
       │                │ id (PK)     │
       │                │ order_id    │
       │                │ product_id  │
       │                │ quantity    │
       │                │ price       │
       │                └─────────────┘
       │
       │          ┌──────────────┐
       │          │ Subscribers  │
       │          ├──────────────┤
       │          │ id (PK)      │
       │          │ email        │
       │          │ is_active    │
       │          │ verified_at  │
       │          │ token        │
       │          └──────────────┘
       │
```

### **Tablas Principales**

#### **users**
```sql
- id: bigint (PK, auto_increment)
- name: varchar(255)
- email: varchar(255) UNIQUE
- email_verified_at: timestamp
- password: varchar(255)
- is_admin: tinyint(1) default 0
- google_id: varchar(255) NULLABLE
- remember_token: varchar(100)
- created_at: timestamp
- updated_at: timestamp
```

#### **categories**
```sql
- id: bigint (PK, auto_increment)
- name: varchar(255)
- description: text
- created_at: timestamp
- updated_at: timestamp
```

#### **products**
```sql
- id: bigint (PK, auto_increment)
- name: varchar(255)
- description: text
- price: decimal(10,2)
- image: varchar(255)
- stock: integer
- category_id: bigint (FK → categories.id)
- size: varchar(50)
- gender: enum('masculino','femenino','unisex')
- active: tinyint(1) default 1
- created_at: timestamp
- updated_at: timestamp
```

#### **offers**
```sql
- id: bigint (PK, auto_increment)
- product_id: bigint (FK → products.id)
- discount_percentage: decimal(5,2)
- start_date: datetime
- end_date: datetime
- is_active: tinyint(1) default 1
- created_at: timestamp
- updated_at: timestamp
```

#### **cart**
```sql
- id: bigint (PK, auto_increment)
- user_id: bigint (FK → users.id) NULLABLE
- product_id: bigint (FK → products.id)
- quantity: integer
- session_id: varchar(255) NULLABLE
- created_at: timestamp
- updated_at: timestamp
```

#### **orders**
```sql
- id: bigint (PK, auto_increment)
- user_id: bigint (FK → users.id)
- total: decimal(10,2)
- status: enum('pendiente','procesando','enviado','entregado')
- shipping_address: text
- created_at: timestamp
- updated_at: timestamp
```

#### **order_items**
```sql
- id: bigint (PK, auto_increment)
- order_id: bigint (FK → orders.id)
- product_id: bigint (FK → products.id)
- quantity: integer
- price: decimal(10,2)
- created_at: timestamp
- updated_at: timestamp
```

#### **subscribers**
```sql
- id: bigint (PK, auto_increment)
- email: varchar(255) UNIQUE
- is_active: tinyint(1) default 1
- verified_at: timestamp NULLABLE
- verification_token: varchar(255)
- created_at: timestamp
- updated_at: timestamp
```

### **Migraciones**

```bash
# Crear nueva migración
php artisan make:migration create_nombre_tabla --create=nombre_tabla

# Ejecutar migraciones
php artisan migrate

# Revertir última migración
php artisan migrate:rollback

# Revertir todas las migraciones
php artisan migrate:reset

# Refrescar base de datos (elimina y recrea)
php artisan migrate:refresh

# Refrescar y ejecutar seeders
php artisan migrate:refresh --seed
```

---

## ⚡ Funcionalidades Implementadas

### **1. Frontend Público**

#### **Página Principal (HomeController)**
- Slider de productos destacados
- Listado de categorías
- Productos en oferta
- Formulario de suscripción al newsletter
- Búsqueda de productos

#### **Catálogo de Productos (ProductController)**
- Vista de grid con todos los productos
- Filtros por categoría
- Paginación
- Vista detallada de producto individual
- Sistema de búsqueda AJAX

#### **Carrito de Compras (CartController)**
- Agregar productos al carrito
- Actualizar cantidades
- Eliminar productos
- Calcular subtotales y totales
- Persistencia con sesiones
- Migración de carrito guest → usuario autenticado

#### **Proceso de Checkout (CheckoutController)**
- Formulario de información de envío
- Vista de confirmación de pedido
- Integración con pasarela de pago
- Webhook para confirmación de pago
- Página de éxito

### **2. Panel de Administración**

#### **Dashboard (AdminController)**
- Resumen de ventas
- Estadísticas de productos
- Últimos pedidos
- Gráficos de rendimiento

#### **Gestión de Productos**
- CRUD completo de productos
- Subida de imágenes
- Asignación de categorías
- Control de stock
- Activar/desactivar productos

#### **Gestión de Categorías**
- CRUD completo de categorías
- Listado de productos por categoría

#### **Gestión de Ofertas**
- Crear ofertas con descuentos
- Definir fechas de inicio y fin
- Asignar ofertas a productos
- Activar/desactivar ofertas
- Notificación automática a suscriptores

#### **Gestión de Pedidos**
- Vista de todos los pedidos
- Actualización de estados
- Detalles de pedidos
- Información de clientes

#### **Reportes**
- Reporte de ventas por período
- Reporte de inventario
- Productos más vendidos

### **3. Sistema de Autenticación**

#### **Registro y Login Tradicional**
- Registro con validación
- Login con email y contraseña
- Recuperación de contraseña
- Verificación de email

#### **Google OAuth**
- Login con cuenta de Google
- Registro automático de nuevos usuarios
- Vinculación de cuentas existentes
- Desconectar cuenta de Google

#### **Middleware de Autorización**
```php
// Middleware 'auth' - usuario autenticado
Route::middleware(['auth'])->group(function () {
    // rutas protegidas
});

// Middleware 'admin' - usuario administrador
Route::middleware(['auth', 'admin'])->group(function () {
    // rutas de administración
});
```

### **4. Sistema de Newsletter**

#### **Suscripción**
- Formulario AJAX en homepage
- Validación de email
- Generación de token de verificación
- Envío de email de confirmación

#### **Verificación**
- Link de verificación por email
- Activación de suscripción
- Página de confirmación

#### **Notificaciones de Ofertas**
- Envío automático al crear ofertas
- Envío en lotes de 50 para optimización
- Solo a suscriptores verificados
- Template HTML profesional

#### **Desuscripción**
- Link en cada email
- Desactivación inmediata

---

## 🔐 Autenticación y Autorización

### **Configuración de Auth**

Laravel UI proporciona scaffolding de autenticación:

```bash
# Ya instalado en el proyecto
composer require laravel/ui
php artisan ui bootstrap --auth
```

### **Rutas de Autenticación**

```php
// routes/web.php
Auth::routes();

// Rutas generadas automáticamente:
// GET  /login           - Formulario de login
// POST /login           - Procesar login
// POST /logout          - Logout
// GET  /register        - Formulario de registro
// POST /register        - Procesar registro
// GET  /password/reset  - Formulario recuperación
// POST /password/email  - Enviar email de reset
// GET  /password/reset/{token} - Formulario de nueva contraseña
// POST /password/reset  - Procesar nueva contraseña
```

### **Google OAuth Setup**

#### **1. Configurar en config/services.php**

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URL'),
],
```

#### **2. GoogleController**

```php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        
        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'password' => Hash::make(Str::random(16)),
            ]
        );

        Auth::login($user);
        return redirect()->route('home');
    }
}
```

### **Middleware Personalizado - Admin**

```php
// app/Http/Middleware/CheckAdmin.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'No autorizado');
        }
        return $next($request);
    }
}
```

Registrar en `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    'admin' => \App\Http\Middleware\CheckAdmin::class,
];
```

---

## 📧 Sistema de Email

### **Configuración SMTP**

Ver: [CONFIGURACION_SMTP.md](CONFIGURACION_SMTP.md)

### **Mailables Implementados**

#### **1. NewOfferNotification**

```php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Offer;

class NewOfferNotification extends Mailable
{
    use Queueable;

    public $offer;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    public function build()
    {
        return $this->subject('¡Nueva Oferta en Edward Villa Perfumería!')
                    ->view('emails.new_offer');
    }
}
```

#### **2. SubscriptionVerification**

Envío de email de verificación al suscribirse.

#### **3. OrderConfirmation**

Confirmación de pedido al cliente.

### **Envío de Emails**

```php
use Illuminate\Support\Facades\Mail;
use App\Mail\NewOfferNotification;

// Enviar email individual
Mail::to($user->email)->send(new NewOfferNotification($offer));

// Enviar en lote
$subscribers = Subscriber::active()->verified()->get();
foreach ($subscribers->chunk(50) as $chunk) {
    foreach ($chunk as $subscriber) {
        Mail::to($subscriber->email)->send(new NewOfferNotification($offer));
    }
}
```

### **Testing con Mailtrap**

Para desarrollo, usar Mailtrap:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_username
MAIL_PASSWORD=tu_password
```

---

## 🛣️ API y Rutas

### **Rutas Web Principales**

```php
// routes/web.php

// Públicas
GET  /                              → HomeController@index
GET  /productos                     → ProductController@index
GET  /productos/{product}           → ProductController@show
GET  /categoria/{category}          → CategoryController@show

// Carrito (público)
GET  /carrito                       → CartController@index
POST /carrito/agregar               → CartController@add
PUT  /carrito/actualizar/{item}     → CartController@update
DELETE /carrito/eliminar/{item}     → CartController@remove
DELETE /carrito/limpiar             → CartController@clear

// Checkout (autenticado)
GET  /checkout/envio                → CheckoutController@shipping
POST /checkout/envio                → CheckoutController@processShipping
GET  /checkout/confirmar            → CheckoutController@showConfirm
POST /checkout/procesar             → CheckoutController@process
GET  /checkout/pago                 → CheckoutController@payment
GET  /checkout/exito                → CheckoutController@success
POST /checkout/webhook              → CheckoutController@webhook

// Pedidos (autenticado)
POST /pedidos                       → OrderController@store
GET  /pedidos                       → OrderController@index
GET  /pedidos/{order}               → OrderController@show

// Admin (auth + admin)
GET    /admin                       → AdminController@dashboard
GET    /admin/productos             → ProductController@adminIndex
POST   /admin/productos             → ProductController@store
PUT    /admin/productos/{product}   → ProductController@update
DELETE /admin/productos/{product}   → ProductController@destroy
RESOURCE /admin/categorias          → CategoryController
GET    /admin/ofertas               → AdminController@offers
POST   /admin/ofertas               → AdminController@storeOffer
PUT    /admin/ofertas/{offer}       → AdminController@updateOffer
PATCH  /admin/ofertas/{offer}/desactivar → AdminController@deactivateOffer
GET    /admin/reportes/ventas       → AdminController@salesReport
GET    /admin/reportes/inventario   → AdminController@inventoryReport
GET    /admin/pedidos               → OrderController@adminIndex
PATCH  /admin/pedidos/{order}/estado → OrderController@updateStatus

// Newsletter
POST /newsletter/subscribe          → SubscriberController@subscribe
GET  /newsletter/verify/{token}     → SubscriberController@verify
GET  /newsletter/unsubscribe/{email} → SubscriberController@unsubscribe

// OAuth
GET  /auth/google                   → GoogleController@redirectToGoogle
GET  /auth/google/callback          → GoogleController@handleGoogleCallback
POST /auth/google/disconnect        → GoogleController@disconnectGoogle

// API
GET  /api/search                    → ProductController@search
```

### **Rutas API (AJAX)**

#### **Búsqueda de Productos**

```javascript
// GET /api/search?q={query}
axios.get('/api/search', {
    params: { q: searchTerm }
})
.then(response => {
    console.log(response.data); // Array de productos
});
```

#### **Respuesta JSON**

```json
[
    {
        "id": 1,
        "name": "Perfume XYZ",
        "price": "89.99",
        "image": "/images/perfume-xyz.jpg",
        "category": "Masculino"
    }
]
```

---

## 🧩 Modelos y Relaciones

### **User Model**

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'google_id', 'is_admin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    // Relaciones
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    // Scopes
    public function scopeAdmin($query)
    {
        return $query->where('is_admin', true);
    }

    // Accessors
    public function getIsAdminAttribute($value)
    {
        return (bool) $value;
    }
}
```

### **Product Model**

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'image', 'stock',
        'category_id', 'size', 'gender', 'active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean',
    ];

    // Relaciones
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Métodos de ayuda
    public function activeOffer()
    {
        return $this->offers()->active()->first();
    }

    public function hasActiveOffer()
    {
        return $this->activeOffer() !== null;
    }

    // Accessors
    public function getFinalPriceAttribute()
    {
        $offer = $this->activeOffer();
        return $offer ? $offer->final_price : $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        $offer = $this->activeOffer();
        return $offer ? $offer->discount_percentage : 0;
    }
}
```

### **Category Model**

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
```

### **Offer Model**

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'product_id', 'discount_percentage', 
        'start_date', 'end_date', 'is_active'
    ];

    protected $casts = [
        'discount_percentage' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
    }

    // Accessors
    public function getFinalPriceAttribute()
    {
        $discount = $this->product->price * ($this->discount_percentage / 100);
        return $this->product->price - $discount;
    }
}
```

### **Order Model**

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'total', 'status', 'shipping_address'
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
```

### **Subscriber Model**

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscriber extends Model
{
    protected $fillable = [
        'email', 'is_active', 'verified_at', 'verification_token'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'verified_at' => 'datetime',
    ];

    // Métodos de ayuda
    public static function generateVerificationToken()
    {
        return Str::random(32);
    }

    public function markAsVerified()
    {
        $this->update([
            'verified_at' => now(),
            'is_active' => true,
        ]);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }
}
```

---

## 🧪 Testing

### **Configuración de Testing**

```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar tests específicos
php artisan test --filter NombreDelTest

# Con coverage
php artisan test --coverage
```

### **Ejemplo de Test**

```php
// tests/Feature/ProductTest.php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_products_page()
    {
        $response = $this->get('/productos');
        $response->assertStatus(200);
    }

    public function test_can_view_single_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id
        ]);

        $response = $this->get("/productos/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_admin_can_create_product()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/productos', [
            'name' => 'Nuevo Perfume',
            'description' => 'Descripción',
            'price' => 99.99,
            'stock' => 10,
            'category_id' => $category->id,
            'size' => '100ml',
            'gender' => 'unisex',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('products', [
            'name' => 'Nuevo Perfume'
        ]);
    }
}
```

---

## 🚀 Deployment

### **Preparación para Producción**

#### **1. Configurar .env para producción**

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com

# Usar base de datos de producción
DB_CONNECTION=mysql
DB_HOST=tu_host_produccion
DB_DATABASE=tu_db_produccion
DB_USERNAME=tu_usuario_produccion
DB_PASSWORD=tu_password_seguro

# SMTP de producción (SendGrid, Mailgun, etc.)
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=tu_api_key

# Google OAuth con URL de producción
GOOGLE_REDIRECT_URL=https://tudominio.com/auth/google/callback
```

#### **2. Optimizar aplicación**

```bash
# Cachear configuración
php artisan config:cache

# Cachear rutas
php artisan route:cache

# Cachear vistas
php artisan view:cache

# Optimizar autoloader
composer install --optimize-autoloader --no-dev

# Compilar assets para producción
npm run build
```

#### **3. Configurar permisos**

```bash
# Dar permisos a storage y bootstrap/cache
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### **4. Migrar base de datos**

```bash
php artisan migrate --force
```

#### **5. Configurar cron jobs (opcional)**

```bash
# Editar crontab
crontab -e

# Agregar:
* * * * * cd /ruta/al/proyecto && php artisan schedule:run >> /dev/null 2>&1
```

### **Deployment en Servicios Cloud**

#### **Heroku**

```bash
# Instalar Heroku CLI y login
heroku login

# Crear app
heroku create nombre-app

# Agregar buildpacks
heroku buildpacks:add heroku/php
heroku buildpacks:add heroku/nodejs

# Configurar variables de entorno
heroku config:set APP_KEY=$(php artisan key:generate --show)
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false

# Agregar base de datos
heroku addons:create cleardb:ignite

# Deploy
git push heroku main

# Migrar base de datos
heroku run php artisan migrate --force
```

#### **DigitalOcean / VPS**

```bash
# Conectar via SSH
ssh user@tu_servidor

# Instalar dependencias
sudo apt update
sudo apt install php8.1 php8.1-fpm php8.1-mysql nginx mysql-server

# Clonar repositorio
git clone <repo_url> /var/www/perfumeria

# Instalar dependencias
cd /var/www/perfumeria
composer install --no-dev
npm install && npm run build

# Configurar Nginx
sudo nano /etc/nginx/sites-available/perfumeria

# Configuración básica de Nginx:
server {
    listen 80;
    server_name tudominio.com;
    root /var/www/perfumeria/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}

# Activar sitio
sudo ln -s /etc/nginx/sites-available/perfumeria /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# Configurar SSL con Let's Encrypt
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d tudominio.com
```

---

## 🔧 Solución de Problemas

### **Error: "No application encryption key"**

```bash
php artisan key:generate
```

### **Error: "Class not found"**

```bash
composer dump-autoload
```

### **Error de permisos en storage**

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### **Errores de migración**

```bash
# Rollback y re-migrar
php artisan migrate:rollback
php artisan migrate

# O refrescar completamente
php artisan migrate:fresh
```

### **Assets no se cargan**

```bash
# Recompilar assets
npm run build

# Limpiar caché
php artisan cache:clear
```

### **Google OAuth no funciona**

1. Verificar que `GOOGLE_CLIENT_ID` y `GOOGLE_CLIENT_SECRET` estén en `.env`
2. Verificar que la URL de redirección en Google Cloud Console coincida exactamente
3. Limpiar caché: `php artisan config:clear`
4. Ver: [GOOGLE_OAUTH_SETUP.md](GOOGLE_OAUTH_SETUP.md)

### **Emails no se envían**

1. Verificar configuración SMTP en `.env`
2. Probar con Mailtrap primero
3. Revisar logs: `storage/logs/laravel.log`
4. Ver: [CONFIGURACION_SMTP.md](CONFIGURACION_SMTP.md)

### **Debugging**

```bash
# Ver logs en tiempo real
tail -f storage/logs/laravel.log

# Activar debug en desarrollo
# En .env:
APP_DEBUG=true
```

---

## 🔮 Mejoras Futuras

### **Funcionalidades Sugeridas**

1. **Sistema de Wishlist (Lista de Deseos)**
   - Permitir a usuarios guardar productos favoritos
   - Notificaciones cuando hay ofertas en productos guardados

2. **Sistema de Reseñas y Calificaciones**
   - Permitir a usuarios calificar productos
   - Sistema de comentarios
   - Validación de compra verificada

3. **Multi-idioma**
   - Soporte para español e inglés
   - Internacionalización con Laravel Localization

4. **Multi-moneda**
   - Soporte para diferentes monedas
   - Conversión automática de precios

5. **Sistema de Cupones**
   - Cupones de descuento
   - Códigos promocionales
   - Ofertas por primera compra

6. **Programa de Puntos/Lealtad**
   - Puntos por compras
   - Recompensas por referidos
   - Niveles de membresía

7. **Notificaciones Push**
   - Notificaciones web push para ofertas
   - Recordatorios de carrito abandonado

8. **Integración con Redes Sociales**
   - Login con Facebook, Twitter
   - Compartir productos en redes sociales
   - Instagram feed en homepage

9. **Chat en Vivo**
   - Soporte al cliente en tiempo real
   - Chatbot básico

10. **Análisis y Reportes Avanzados**
    - Dashboard con gráficos interactivos
    - Análisis de comportamiento de usuarios
    - Predicción de demanda

11. **Sistema de Inventario Avanzado**
    - Alertas de stock bajo
    - Reabastecimiento automático
    - Seguimiento de proveedores

12. **API RESTful Completa**
    - API para aplicación móvil
    - Documentación con Swagger
    - Rate limiting

### **Optimizaciones Técnicas**

1. **Colas (Queues)**
   - Mover envío de emails a colas
   - Procesamiento de imágenes en background

2. **Cache**
   - Implementar Redis para cache
   - Cache de productos y categorías
   - Cache de queries frecuentes

3. **CDN**
   - Servir assets desde CDN
   - Optimización de imágenes

4. **Tests Automatizados**
   - Aumentar cobertura de tests
   - Tests de integración
   - Tests E2E con Dusk

5. **CI/CD**
   - Pipeline de deploy automático
   - Tests automáticos en cada commit
   - GitHub Actions / GitLab CI

---

## 📚 Recursos Adicionales

### **Documentación**

- [Laravel Documentation](https://laravel.com/docs/9.x)
- [Bootstrap Documentation](https://getbootstrap.com/docs/5.2)
- [Laravel Socialite](https://laravel.com/docs/9.x/socialite)
- [Vite Documentation](https://vitejs.dev/)

### **Tutoriales**

- [Laracasts](https://laracasts.com/)
- [Laravel Daily](https://laraveldaily.com/)
- [Laravel News](https://laravel-news.com/)

### **Comunidad**

- [Laravel Forums](https://laracasts.com/discuss)
- [Laravel Discord](https://discord.gg/laravel)
- [Stack Overflow - Laravel Tag](https://stackoverflow.com/questions/tagged/laravel)

---

## 📄 Licencia

Este proyecto está bajo la licencia MIT. Ver el archivo `LICENSE` para más detalles.

---

## 👨‍💻 Contribuir

Si deseas contribuir al proyecto:

1. Fork el repositorio
2. Crea una nueva rama (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crea un Pull Request

---

## 📞 Contacto

Para cualquier consulta técnica o colaboración:

- **Email**: desarrollo@edwardvillaperfumeria.com
- **GitHub Issues**: [Crear Issue](https://github.com/tu-repo/issues)

---

**Desarrollado con ❤️ usando Laravel y Bootstrap**
