<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'category_id',
        'title',
        'location',
        'tags',
        'description',
        'utilities_id',
        'floor_area',
    ];

    // Cast tags to array for easier access
    protected $casts = [
        'tags' => 'array',
    ];

    // Define relationships to link a project to its category and utilities
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function utility()
    {
        return $this->belongsTo(Utility::class, 'utilities_id');
    }
}
