<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_percent',
        'allowed_package',
        'requires_grant',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'requires_grant' => 'boolean',
        'is_active'      => 'boolean',
    ];

    public function grants(): HasMany
    {
        return $this->hasMany(CouponGrant::class);
    }

    public static function findByCode(string $code): ?self
    {
        return static::whereRaw('UPPER(code) = ?', [strtoupper(trim($code))])->first();
    }
}
