<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PricingOptionFeature extends Model
{
    protected $fillable = [
        'pricing_package_option_id', 'feature', 'is_inherited', 'sort_order',
    ];

    protected $casts = [
        'is_inherited' => 'boolean',
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(PricingPackageOption::class, 'pricing_package_option_id');
    }
}