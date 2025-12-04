<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['modelable_type', 'modelable_id', 'media', 'info', 'path_file_name', 'file_type'];

    protected $appends = ['media_link', 'name'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'modelable_type',
        'modelable_id',
        'info',
        'file_type',
        'media',
    ];

    public function getNameAttribute()
    {
        return $this->media;
    }

    public function modelable()
    {
        return $this->morphTo();
    }


public function getMediaLinkAttribute()
{
    // Return empty if media filename is not set
    if (empty($this->media)) {
        return '';
    }

    // If media is already a full URL, return it as is
    if (Str::startsWith($this->media, ['http://', 'https://'])) {
        return $this->media;
    }

    // Check if we're in local environment or S3 is not configured
    $isLocal = app()->environment('local') || !config('filesystems.disks.s3.key');
    
    if ($isLocal) {
        // Return local file path
        $path = $this->path_file_name ? $this->path_file_name . '/' : '';
        return asset('files/' . $path . $this->media);
    }

    // Use S3 URL for production
    $s3Url = config('filesystems.disks.s3.url');
    if ($s3Url) {
        $path = $this->path_file_name ? $this->path_file_name . '/' : '';
        return rtrim($s3Url, '/') . '/handco/' . $path . $this->media;
    }

    // Fallback to local if S3 URL is not configured
    $path = $this->path_file_name ? $this->path_file_name . '/' : '';
    return asset('files/' . $path . $this->media);
}



}
