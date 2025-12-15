<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffPlanProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'developer',
        'location',
        'location_link',
        'starting_price',
        'completion_date',
        'development_type',
        'description',
        'overview',
        'key_features',
        'payment_plan',
        'nearby_attractions',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'key_features' => 'array',
        'payment_plan' => 'array',
        'nearby_attractions' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'starting_price' => 'decimal:2',
    ];

    // Relationship to get hero/main image
    public function mainImage()
    {
        return $this->morphOne(Media::class, 'modelable')->where('info', 'main');
    }

    // Relationship to get gallery images
    public function galleryImages()
    {
        return $this->morphMany(Media::class, 'modelable')->where('info', 'gallery');
    }

    // Relationship to get all images
    public function images()
    {
        return $this->morphMany(Media::class, 'modelable');
    }
}

