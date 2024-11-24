<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_link',
    ];

    /**
     * Define a one-to-one relationship for the main image.
     */
    public function mainImage()
    {
        return $this->morphOne(Media::class, 'modelable')->where('info', 'main');
    }

}
