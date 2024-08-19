<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{

    public function index()
    {
        $portfolios = Portfolio::all();
        return view('dashboard.portofilo.index', compact('portfolios'));
    }


    public function create()
    {
        return view('dashboard.portofilo.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('portfolios', 'public');
        }

        Portfolio::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imagePath,
        ]);

        return redirect()->route('portofilo')->with('success', 'Portfolio created successfully');
    }


    public function edit($id)
    {
        $portfolio = Portfolio::find($id);

        return view('dashboard.portofilo.edit', compact('portfolio'));
    }


    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        // Find the portfolio by ID
        $portfolio = Portfolio::findOrFail($id);

        // Handle the image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($portfolio->image) {
                Storage::delete('public/' . $portfolio->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('portfolios', 'public');
            $portfolio->image = $imagePath;
        }

        // Update the portfolio with the new data
        $portfolio->title = $request->input('title');
        $portfolio->description = $request->input('description');
        $portfolio->save();

        // Redirect to the portfolio listing page with a success message
        return redirect()->route('portofilo')->with('success', 'Portfolio updated successfully');
    }


    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        // Delete the portfolio image if exists
        if ($portfolio->image) {
            Storage::delete('public/' . $portfolio->image);
        }

        $portfolio->delete();

        return redirect()->route('portofilo')->with('success', 'Portfolio deleted successfully');
    }
}
