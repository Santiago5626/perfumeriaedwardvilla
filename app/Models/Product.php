<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'stock',
        'category_id',
        'size',
        'gender',
        'active'
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the cart items for the product.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the offers for the product.
     */
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * Get active offer for the product.
     */
    public function activeOffer()
    {
        return $this->offers()->active()->first();
    }

    /**
     * Get final price with discount if there's an active offer.
     */
    public function getFinalPriceAttribute()
    {
        $offer = $this->activeOffer();
        return $offer ? $offer->final_price : $this->price;
    }

    /**
     * Check if product has an active offer.
     */
    public function hasActiveOffer()
    {
        return $this->activeOffer() !== null;
    }

    /**
     * Get discount percentage if there's an active offer.
     */
    public function getDiscountPercentageAttribute()
    {
        $offer = $this->activeOffer();
        return $offer ? $offer->discount_percentage : 0;
    }
}
