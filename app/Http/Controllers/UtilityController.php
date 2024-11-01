<?php

namespace App\Http\Controllers;

use App\Models\Utility;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function index()
    {
        $utilities = Utility::all();
        return view('utilities.index', compact('utilities'));
    }

    public function create()
    {
        return view('utilities.create');
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
        ]);

        Utility::create($request->all());
        return redirect()->route('utilities.index')->with('success', 'Utility created successfully.');
    }

    public function show(Utility $utility)
    {
        return view('utilities.show', compact('utility'));
    }

    public function edit(Utility $utility)
    {
        return view('utilities.edit', compact('utility'));
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
        ]);

        $utility->update($request->all());
        return redirect()->route('utilities.index')->with('success', 'Utility updated successfully.');
    }

    public function destroy(Utility $utility)
    {
        $utility->delete();
        return redirect()->route('utilities.index')->with('success', 'Utility deleted successfully.');
    }
}
