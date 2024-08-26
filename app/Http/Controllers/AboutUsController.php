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
        $validatedData = $request->validate([
            'description' => 'required|string',
        ]);
        $setting = Setting::updateOrCreate(
            ['id' => 1], 
            ['about_us' => $validatedData['description']] 
        );

        // Redirect with a success message
        return redirect()->route('about.create')->with('success', 'About Us section updated successfully!');
    }


    public function getAboutUs()
    {
        $setting = Setting::first();

        if ($setting) {
            return response()->json([
                'success' => true,
                'about_us' => $setting->about_us,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'About Us content not found',
            ], 404);
        }
    }



}
