<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'is_active',
        'verified_at',
        'verification_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Generar token de verificación
     */
    public static function generateVerificationToken()
    {
        return Str::random(64);
    }

    /**
     * Verificar si el suscriptor está verificado
     */
    public function isVerified()
    {
        return !is_null($this->verified_at);
    }

    /**
     * Marcar como verificado
     */
    public function markAsVerified()
    {
        $this->update([
            'verified_at' => now(),
            'verification_token' => null,
        ]);
    }

    /**
     * Scope para suscriptores activos y verificados
     */
    public function scopeActiveAndVerified($query)
    {
        return $query->where('is_active', true);
    }
}
