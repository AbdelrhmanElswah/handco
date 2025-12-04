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

    $path = $this->path_file_name ? $this->path_file_name . '/' : '';
    
    // Check if S3 is configured (has key, secret, and URL)
    $s3Key = config('filesystems.disks.s3.key');
    $s3Secret = config('filesystems.disks.s3.secret');
    $s3Url = config('filesystems.disks.s3.url');
    
    // Use S3 if fully configured (key, secret, and URL exist) and NOT in local environment
    $s3Configured = !empty($s3Key) && !empty($s3Secret) && !empty($s3Url);
    $isLocalEnv = app()->environment('local');
    
    if ($s3Configured && !$isLocalEnv) {
        return rtrim($s3Url, '/') . '/handco/' . $path . $this->media;
    }

    // Use local storage for local environment or if S3 is not fully configured
    return asset('files/' . $path . $this->media);
}



}
