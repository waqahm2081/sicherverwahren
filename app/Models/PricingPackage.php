<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PricingPackage extends Model
{
    protected $fillable = [
        'name', 'slug', 'category', 'portfolio_label', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(PricingPackageOption::class)->orderBy('sort_order');
    }

    public function digitalOption(): ?PricingPackageOption
    {
        return $this->options->firstWhere('type', 'digital');
    }

    public function onsiteOption(): ?PricingPackageOption
    {
        return $this->options->firstWhere('type', 'onsite');
    }

    /** Returns CHF saving amount (onsite - digital), or null if no digital option */
    public function savings(): ?int
    {
        $digital = $this->digitalOption();
        $onsite  = $this->onsiteOption();

        if (! $digital || ! $onsite) {
            return null;
        }

        return $onsite->price_chf - $digital->price_chf;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}