<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CourseVideo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'video_url',
        'duration',
        'tag',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(PricingPackage::class, 'course_video_package');
    }
}