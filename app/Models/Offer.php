<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'discount_percentage',
        'final_price',
        'start_date',
        'end_date',
        'active',
        'description'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'active' => 'boolean',
        'discount_percentage' => 'decimal:2',
        'final_price' => 'decimal:2'
    ];

    /**
     * Relación con Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope para ofertas activas
     */
    public function scopeActive($query)
    {
        return $query->where('active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    /**
     * Verificar si la oferta está vigente
     */
    public function isValid()
    {
        return $this->active && 
               $this->start_date <= now() && 
               $this->end_date >= now();
    }
}
