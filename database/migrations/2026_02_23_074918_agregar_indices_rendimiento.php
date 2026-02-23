<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración de rendimiento: agrega índices en columnas usadas frecuentemente
 * en filtros WHERE y JOINs para acelerar las consultas a Supabase (PostgreSQL).
 */
return new class extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up(): void
    {
        // Índice en products.active — usado en todos los filtros de la tienda
        Schema::table('products', function (Blueprint $table) {
            $table->index('active', 'idx_productos_activo');
            $table->index('category_id', 'idx_productos_categoria');
        });

        // Índices en offers — usados en whereHas de ofertas activas
        Schema::table('offers', function (Blueprint $table) {
            $table->index('active', 'idx_ofertas_activo');
            $table->index('end_date', 'idx_ofertas_fin');
            $table->index('start_date', 'idx_ofertas_inicio');
            $table->index('product_id', 'idx_ofertas_producto');
        });

        // Índice en cart.user_id — usado en conteo y listado del carrito
        Schema::table('cart', function (Blueprint $table) {
            $table->index('user_id', 'idx_carrito_usuario');
        });
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_productos_activo');
            $table->dropIndex('idx_productos_categoria');
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->dropIndex('idx_ofertas_activo');
            $table->dropIndex('idx_ofertas_fin');
            $table->dropIndex('idx_ofertas_inicio');
            $table->dropIndex('idx_ofertas_producto');
        });

        Schema::table('cart', function (Blueprint $table) {
            $table->dropIndex('idx_carrito_usuario');
        });
    }
};
