<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PricingPackageOption extends Model
{
    protected $fillable = [
        'pricing_package_id', 'type', 'label',
        'price_chf', 'is_recommended', 'is_only_option', 'sort_order',
    ];

    protected $casts = [
        'is_recommended' => 'boolean',
        'is_only_option' => 'boolean',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(PricingPackage::class, 'pricing_package_id');
    }

    public function features(): HasMany
    {
        return $this->hasMany(PricingOptionFeature::class)->orderBy('sort_order');
    }

    /** Formatted CHF price e.g. "1'499" */
    public function formattedPrice(): string
    {
        return number_format($this->price_chf, 0, '.', "'");
    }
}