<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Estados permitidos para el campo status.
     * Reemplaza la restriccion del ENUM de MySQL para compatibilidad con PostgreSQL.
     */
    const ESTADOS_VALIDOS = ['pending', 'paid', 'shipped', 'delivered', 'cancelled'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        // Datos del comprador
        'first_name',
        'email',
        'phone',
        // Dirección de envío
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'notes',
        // Montos
        'subtotal',
        'shipping',
        'total',
        // Estado y pago
        'status',
        'payment_method',
        'payment_id',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the order items for the order (alias for orderItems).
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
