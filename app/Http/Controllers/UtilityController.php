<?php

namespace App\Http\Controllers;

use App\Models\Utility;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function index()
    {
        $utilities = Utility::all();
        return view('dashboard.utility.index', compact('utilities'));
    }

    public function create()
    {
        return view('dashboard.utility.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'parking_spaces' => 'nullable|integer',
            'swimming_pool' => 'boolean',
            'gym' => 'boolean',
            'garden' => 'boolean',
            'air_conditioning' => 'boolean',
            'furnished' => 'boolean',
            'garage_facility' => 'boolean',
            'fire_security' => 'boolean',
            'fire_place_facility' => 'boolean',
            'play_ground' => 'boolean',
            'marble_floor' => 'boolean',
            'store_room' => 'boolean',
            'high_class_door' => 'boolean',
            'floor_heating_system' => 'boolean',
            'smart_home_system' => 'boolean',
            'central_heating_hvac' => 'boolean',
            'walk_in_closets' => 'boolean',
            'en_suite_bathrooms' => 'boolean',
            'built_in_kitchen_appliances' => 'boolean',
            'laundry_room' => 'boolean',
            'bbq_area' => 'boolean',
            'gated_community_access' => 'boolean',
            'guest_house_maids_room' => 'boolean',
            'private_pool' => 'boolean',
            'landscaped_garden' => 'boolean',
            'covered_parking' => 'boolean',
        ]);

        $data = $request->all();
        $data['swimming_pool'] = $request->has('swimming_pool') ? 1 : 0;
        $data['gym'] = $request->has('gym') ? 1 : 0;
        $data['garden'] = $request->has('garden') ? 1 : 0;
        $data['air_conditioning'] = $request->has('air_conditioning') ? 1 : 0;
        $data['furnished'] = $request->has('furnished') ? 1 : 0;
        $data['garage_facility'] = $request->has('garage_facility') ? 1 : 0;
        $data['fire_security'] = $request->has('fire_security') ? 1 : 0;
        $data['fire_place_facility'] = $request->has('fire_place_facility') ? 1 : 0;
        $data['play_ground'] = $request->has('play_ground') ? 1 : 0;
        $data['marble_floor'] = $request->has('marble_floor') ? 1 : 0;
        $data['store_room'] = $request->has('store_room') ? 1 : 0;
        $data['high_class_door'] = $request->has('high_class_door') ? 1 : 0;
        $data['floor_heating_system'] = $request->has('floor_heating_system') ? 1 : 0;
        $data['smart_home_system'] = $request->has('smart_home_system') ? 1 : 0;
        $data['central_heating_hvac'] = $request->has('central_heating_hvac') ? 1 : 0;
        $data['walk_in_closets'] = $request->has('walk_in_closets') ? 1 : 0;
        $data['en_suite_bathrooms'] = $request->has('en_suite_bathrooms') ? 1 : 0;
        $data['built_in_kitchen_appliances'] = $request->has('built_in_kitchen_appliances') ? 1 : 0;
        $data['laundry_room'] = $request->has('laundry_room') ? 1 : 0;
        $data['bbq_area'] = $request->has('bbq_area') ? 1 : 0;
        $data['gated_community_access'] = $request->has('gated_community_access') ? 1 : 0;
        $data['guest_house_maids_room'] = $request->has('guest_house_maids_room') ? 1 : 0;
        $data['private_pool'] = $request->has('private_pool') ? 1 : 0;
        $data['landscaped_garden'] = $request->has('landscaped_garden') ? 1 : 0;
        $data['covered_parking'] = $request->has('covered_parking') ? 1 : 0;

        Utility::create($data);
        return redirect()->route('utilities.index')->with('success', 'Utility created successfully.');
    }

    public function edit(Utility $utility)
    {
        return view('dashboard.utility.edit', compact('utility'));
    }

    public function update(Request $request, Utility $utility)
    {
        $request->validate([
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'parking_spaces' => 'nullable|integer',
            'swimming_pool' => 'boolean',
            'gym' => 'boolean',
            'garden' => 'boolean',
            'air_conditioning' => 'boolean',
            'furnished' => 'boolean',
            'garage_facility' => 'boolean',
            'fire_security' => 'boolean',
            'fire_place_facility' => 'boolean',
            'play_ground' => 'boolean',
            'marble_floor' => 'boolean',
            'store_room' => 'boolean',
            'high_class_door' => 'boolean',
            'floor_heating_system' => 'boolean',
        ]);

        // Set default values for checkboxes that may be missing in the request
        $data = $request->all();
        $data['swimming_pool'] = $request->has('swimming_pool') ? 1 : 0;
        $data['gym'] = $request->has('gym') ? 1 : 0;
        $data['garden'] = $request->has('garden') ? 1 : 0;
        $data['air_conditioning'] = $request->has('air_conditioning') ? 1 : 0;
        $data['furnished'] = $request->has('furnished') ? 1 : 0;
        $data['garage_facility'] = $request->has('garage_facility') ? 1 : 0;
        $data['fire_security'] = $request->has('fire_security') ? 1 : 0;
        $data['fire_place_facility'] = $request->has('fire_place_facility') ? 1 : 0;
        $data['play_ground'] = $request->has('play_ground') ? 1 : 0;
        $data['marble_floor'] = $request->has('marble_floor') ? 1 : 0;
        $data['store_room'] = $request->has('store_room') ? 1 : 0;
        $data['high_class_door'] = $request->has('high_class_door') ? 1 : 0;
        $data['floor_heating_system'] = $request->has('floor_heating_system') ? 1 : 0;

        $utility->update($data);


        return redirect()->route('utilities.index')->with('success', 'Utility updated successfully.');
    }


    public function destroy(Utility $utility)
    {
        $utility->delete();
        return redirect()->route('utilities.index')->with('success', 'Utility deleted successfully.');
    }
}
