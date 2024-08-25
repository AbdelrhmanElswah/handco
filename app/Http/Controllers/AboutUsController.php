<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class AboutUsController extends Controller
{
    /**
     * Show the form for editing the "About Us" content.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $setting = Setting::first();
        return view('dashboard.about-us.create', ['setting' => $setting]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'description' => 'required|string',
        ]);

        // Create or update the "About Us" setting
        $setting = Setting::updateOrCreate(
            ['id' => 1], // Condition: Match by ID (assuming the setting has a fixed ID)
            ['about_us' => $validatedData['description']] // Values to update/crea
        );

        // Redirect with a success message
        return redirect()->route('about.index')->with('success', 'About Us section updated successfully!');
    }


    


    /**
     * Update the "About Us" content in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'about_us' => 'required|string',
        ]);

        // Assuming you have a Setting model where "about_us" is stored
        $setting = Setting::first();
        $setting->about_us = $request->input('about_us');
        $setting->save();

        return redirect()->route('about.index')->with('success', 'About Us updated successfully.');
    }
}
