<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_key',
        'section_name',
        'title',
        'subtitle',
        'content',
        'list_items',
        'stats_items',
        'testimonials',
        'accordion_items',
        'contact_phones',
        'contact_addresses',
        'contact_emails',
        'social_links',
        'is_active',
    ];

    protected $casts = [
        'list_items' => 'array',
        'stats_items' => 'array',
        'testimonials' => 'array',
        'accordion_items' => 'array',
        'contact_phones' => 'array',
        'contact_addresses' => 'array',
        'contact_emails' => 'array',
        'social_links' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get a CMS section by its key
     */
    public static function getByKey($key)
    {
        return static::where('section_key', $key)->where('is_active', true)->first();
    }

    /**
     * Define a one-to-one relationship for the background image.
     */
    public function backgroundImage()
    {
        return $this->morphOne(Media::class, 'modelable')->where('info', 'background');
    }

    /**
     * Define a one-to-one relationship for the section image.
     */
    public function sectionImage()
    {
        return $this->morphOne(Media::class, 'modelable')->where('info', 'section');
    }
}
