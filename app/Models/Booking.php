<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'email',
        'phone_number',
        'message',
    ];

    /**
     * Define the relationship with the Project model.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
