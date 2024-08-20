<?php

// app/Models/Blog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    protected $hidden = ['image'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return asset('storage/app/' . $this->image);
    }
}

