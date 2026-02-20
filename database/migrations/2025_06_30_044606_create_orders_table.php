<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Datos del comprador
            $table->string('first_name');
            $table->string('email');
            $table->string('phone');

            // Dirección de envío
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country', 2)->default('CO');
            $table->string('postal_code')->nullable();
            $table->text('notes')->nullable();

            // Montos
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            // Estado y pago
            // Se usa string en lugar de enum para compatibilidad con PostgreSQL (Supabase)
            $table->string('status', 20)->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
