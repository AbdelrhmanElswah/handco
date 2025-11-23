<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    use HasFactory;

    protected $fillable = [
        'bedrooms',
        'bathrooms',
        'parking_spaces',
        'swimming_pool',
        'gym',
        'garden',
        'air_conditioning',
        'furnished',
        'garage_facility',
        'fire_security',
        'fire_place_facility',
        'play_ground',
        'marble_floor',
        'store_room',
        'high_class_door',
        'floor_heating_system',
        'balcony',
        'view_of_landmarks',
        'built_in_wardrobes',
        'smart_home_system',
        'central_heating_hvac',
        'walk_in_closets',
        'en_suite_bathrooms',
        'built_in_kitchen_appliances',
        'laundry_room',
        'bbq_area',
        'gated_community_access',
        'guest_house_maids_room',
        'private_pool',
        'landscaped_garden',
        'covered_parking',
    ];

    // Define relationships if needed, for example, a utility could be related to multiple projects
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
