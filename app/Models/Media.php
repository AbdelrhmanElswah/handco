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
    // Use env() directly as fallback in case config cache is stale
    $s3Key = config('filesystems.disks.s3.key') ?: env('AWS_ACCESS_KEY_ID');
    $s3Secret = config('filesystems.disks.s3.secret') ?: env('AWS_SECRET_ACCESS_KEY');
    $s3Url = config('filesystems.disks.s3.url') ?: env('AWS_URL');
    
    // Use S3 if fully configured (key, secret, and URL exist)
    // Only skip S3 if explicitly in local/testing environment
    $s3Configured = !empty($s3Key) && !empty($s3Secret) && !empty($s3Url);
    $isLocalEnv = in_array(app()->environment(), ['local', 'testing']);
    
    // If S3 is configured and not in local/testing, use S3
    // On production, always prefer S3 if configured
    if ($s3Configured && !$isLocalEnv) {
        $s3Path = rtrim($s3Url, '/') . '/handco/' . $path . $this->media;
        return $s3Path;
    }

    // Use local storage for local/testing environment or if S3 is not fully configured
    return asset('files/' . $path . $this->media);
}



}
