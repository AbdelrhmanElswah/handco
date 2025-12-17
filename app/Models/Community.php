<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'subtitle',
        'location_link',
    ];

    public function mainImage()
    {
        return $this->morphOne(Media::class, 'modelable')->where('info', 'main');
    }
}
