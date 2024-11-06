<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category_id',
    ];

    /**
     * Define the relationship with the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
