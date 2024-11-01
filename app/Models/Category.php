<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Define relationships if needed, for example, a category could have many projects
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
