<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Página principal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas públicas de productos
Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categoria/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Rutas del carrito (públicas)
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
Route::put('/carrito/actualizar/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrito/eliminar/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/carrito/limpiar', [CartController::class, 'clear'])->name('cart.clear');

// Rutas del carrito (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/carrito/migrar', [CartController::class, 'migrateSessionCart'])->name('cart.migrate');
});

// Rutas del checkout (requieren autenticación)
Route::middleware(['auth'])->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/envio', [App\Http\Controllers\CheckoutController::class, 'shipping'])->name('shipping');
    Route::post('/envio', [App\Http\Controllers\CheckoutController::class, 'processShipping'])->name('shipping.process');
    Route::get('/confirmar', [App\Http\Controllers\CheckoutController::class, 'showConfirm'])->name('confirm');
    Route::post('/procesar', [App\Http\Controllers\CheckoutController::class, 'process'])->name('process');
    Route::get('/pago', [App\Http\Controllers\CheckoutController::class, 'payment'])->name('payment');
    Route::get('/exito', [App\Http\Controllers\CheckoutController::class, 'success'])->name('success');
    Route::post('/webhook', [App\Http\Controllers\CheckoutController::class, 'webhook'])->name('webhook');
});

// Rutas de pedidos (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    Route::post('/pedidos', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Rutas de administración (requieren autenticación y ser admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestión de productos
    Route::get('/productos', [ProductController::class, 'adminIndex'])->name('productos.index');
    Route::get('/productos/crear', [ProductController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductController::class, 'store'])->name('productos.store');
    Route::get('/productos/{product}/editar', [ProductController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{product}', [ProductController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{product}', [ProductController::class, 'destroy'])->name('productos.destroy');
    
    // Gestión de categorías
    Route::resource('categorias', CategoryController::class)->except(['show']);
    
    // Gestión de ofertas
    Route::get('/ofertas', [AdminController::class, 'offers'])->name('offers');
    Route::post('/ofertas', [AdminController::class, 'storeOffer'])->name('offers.store');
    Route::put('/ofertas/{offer}', [AdminController::class, 'updateOffer'])->name('offers.update');
    Route::patch('/ofertas/{offer}/desactivar', [AdminController::class, 'deactivateOffer'])->name('offers.deactivate');
    
    // Reportes
    Route::get('/reportes/ventas', [AdminController::class, 'salesReport'])->name('reports.sales');
    Route::get('/reportes/inventario', [AdminController::class, 'inventoryReport'])->name('reports.inventory');
    
    // Gestión de pedidos
    Route::get('/pedidos', [OrderController::class, 'adminIndex'])->name('pedidos.index');
    Route::patch('/pedidos/{order}/estado', [OrderController::class, 'updateStatus'])->name('pedidos.updateStatus');
});

// Rutas de autenticación
Auth::routes();

// Rutas de autenticación con Google
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Ruta opcional para desconectar cuenta de Google (requiere autenticación)
Route::middleware(['auth'])->group(function () {
    Route::post('auth/google/disconnect', [App\Http\Controllers\Auth\GoogleController::class, 'disconnectGoogle'])->name('auth.google.disconnect');
});

// Rutas del newsletter/suscripciones
Route::post('/newsletter/subscribe', [App\Http\Controllers\SubscriberController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/verify/{token}', [App\Http\Controllers\SubscriberController::class, 'verify'])->name('newsletter.verify');
Route::get('/newsletter/unsubscribe/{email}', [App\Http\Controllers\SubscriberController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// API Routes for search
Route::get('/api/search', [ProductController::class, 'search'])->name('api.search');
