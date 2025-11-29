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
    if (Str::startsWith($this->media, ['http://', 'https://'])) {
        return $this->media;
    }

    // Use config instead of env() for production compatibility
    $s3Url = config('filesystems.disks.s3.url');
    if ($s3Url) {
        return rtrim($s3Url, '/') . '/handco/' . $this->path_file_name . '/' . $this->media;
    }

    return asset('files/' . $this->path_file_name . '/' . $this->media);
}



}
